<?php

namespace App\Http\Controllers\Folders;

use Illuminate\Http\Request;
use App\User;
use App\Tag;
use App\ClientTag;
use App\ClientPhoto;
use App\ClientItem;
use App\Log;
use App\Role;
use DB;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Hash;

class FoldersController extends \App\Http\Controllers\BaseController
{
    public function __construct()
    {
        $this->middleware(['permission:clients_access'])->only('index');
        $this->middleware(['permission:clients_create'])->only(['create','store']);
        $this->middleware(['permission:clients_show'])->only('show');
        $this->middleware(['permission:clients_edit'])->only(['edit','update']);
        $this->middleware(['permission:clients_delete'])->only('destroy');
    }

    public function index(Request $request)
    {
        $model          = new User();
        $isFiltered     = false;
        // $total          = $model::count();
        $modelQuery     = $model::query();
        $requestClonned = clone $request;

        $cleanup = $requestClonned->except(['page']);
        $requestClonned->query = new \Symfony\Component\HttpFoundation\ParameterBag($cleanup);

        if (count($requestClonned->all()) > 0) {
            $isFiltered = (!empty(array_filter($requestClonned->all())));
        }

        if ($isFiltered || $request->get('c') == "0") {
            if ($request->get('s', false)) {
                $s = $request->get('s');

                $modelQuery->where(function($query) use($s, $model) {
                    $query->where($model::getTableName() . '.name', 'LIKE', "%$s%")
                          ->orWhere($model::getTableName() . '.name','LIKE', "%$s%");
                });
            }

            if ($request->get('t', false)) {
                $t = $request->get('t');

                $modelQuery->join(ClientTag::getTableName(), function($join) use($t, $model) {
                    $join->on($model::getTableName() . '.id', '=', CLientTag::getTableName() . '.user_id')
                             ->where(ClientTag::getTableName() . '.tag_id', (int)$t);
                });
            }

            if ($request->get('c', false) || $request->get('c') == 0) {
                $c = $request->get('c');

                $modelQuery->where('category', $c);
            }
        }

        $modelQuery->leftJoin(ClientItem::getTableName(), $model::getTableName() . '.id', '=', ClientItem::getTableName() . '.user_id');
        $modelQuery->where($model::getTableName() . '.id', '!=', $model::$superadminId);
        $modelQuery->groupBy($model::getTableName() . '.id');
        $modelQuery->select(DB::raw($model::getTableName() . ".*, SUM(" . ClientItem::getTableName() . '.qty) as qty'));

        $total   = $modelQuery->count();
        $records = $modelQuery->orderBy('name', 'ASC')->paginate($model::PAGINATE_RECORDS);

        $tags       = Tag::all();
        $categories = User::$categories;

        return view('folders.index', compact('total', 'records', 'request', 'isFiltered', 'tags', 'categories'));
    }

    public function create()
    {
        $tags       = Tag::all();
        $categories = User::$categories;
        $roles      = Role::orderBy('id', 'ASC')->get();

        return view('folders.create', compact('tags', 'categories', 'roles'));
    }

    public function store(Request $request)
    {
        $data               = $request->all();
        $data['created_by'] = auth()->user()->id;
        $model              = new User();
        $clientTagModel     = new ClientTag();

        $validator = $model::validators($data);

        $validator->validate();

        $data['password'] = (!empty($data['password'])) ? Hash::make($data['password']) : '';

        $create = $model::create($data);

        if ($create) {
            $find = $model::find($create->id);
            self::createLog($find, __("Created client {$find->name}"), Log::CREATE, [], $find->toArray());

            // Assign role
            if (!empty($data['role_id'])) {
                $role = Role::find($data['role_id']);
                if ($role) {
                    $create->assignRole($role);
                }
            }

            $tagData['user_id'] = $create->id;
            $tagData['tag_id']  = (!empty($data['tags'])) ? $data['tags'] : [];

            $this->photos($create->id, $request->photos, 'create');

            $validator = $clientTagModel::validators($tagData, true);
            if ($validator) {
                foreach ((array)$tagData as $index => $data) {
                    $tagDatas = [];

                    if (is_array($data)) {
                        foreach ($data as $tag) {
                            $tagDatas['user_id'] = $create->id;
                            $tagDatas['tag_id']  = $tag;

                            $tagCreate = $clientTagModel->create($tagDatas);
                        }
                    }
                }
            }

            return redirect('folders')->with('success', __("Folder created!"));
        }

        return redirect('folders/create')->with('error', __("There has been an error!"));
    }

    public function photos($id, $datas, $flag = 'create')
    {
        $create = false;

        if (!empty($datas)) {
            if ($flag == 'update') {
                ClientPhoto::where('user_id', $id)->delete();
            }

            foreach ($datas as $data) {
                if ($data instanceof UploadedFile) {
                    $check['photo']   = $data;
                    $check['user_id'] = $id;

                    if (ClientPhoto::validators($check, true)) {
                        $imageName = time() . '_' . $id . '.' . $data->getClientOriginalExtension();
                        $moveFiles = $data->storeAs(ClientPhoto::$storageFolderName . "/{$id}", $imageName, ClientPhoto::$fileSystems);

                        if ($moveFiles) {
                            $check['photo'] = $imageName;

                            $create = ClientPhoto::create($check);
                        }
                    }
                }
            }
        }

        return $create;
    }

    public function edit(int $id)
    {
        $record = User::find($id);

        if ($record) {
            $tags       = Tag::all();
            $categories = User::$categories;
            $roles      = Role::orderBy('id', 'ASC')->get();

            return view('folders.edit', compact('record', 'tags', 'categories', 'roles'));
        }

        return redirect('folders')->with('error', __("Not found!"));
    }

    public function update(Request $request, int $id)
    {
        $model  = new User();
        $record = $model::find($id);

        if ($record) {
            if ($record->id == $model::$superadminId) {
                return redirect('folders')->with('error', __("You can't change Superadmin!"));
            }

            $data               = $request->all();
            $data['updated_by'] = auth()->user()->id;
            $clientTagModel     = new ClientTag();

            if (empty($data['password'])) {
                unset($data['password']);
            }

            $validator = $model::validators($data, false, true, $record);

            $validator->validate();

            $oldData = $record->toArray();

            if (!empty($data['password'])) {
                $data['password'] = Hash::make($data['password']);
            }

            $update = $record->update($data);

            if ($update) {
                $find = $model::find($id);
                self::createLog($find, __("Updated client {$find->name}"), Log::UPDATE, $oldData, $find->toArray());

                $tagData['user_id'] = $id;
                $tagData['tag_id']  = (!empty($data['tags'])) ? $data['tags'] : [];

                $this->photos($id, $request->photos, 'update');

                // Update role
                if (!$record->isSuperAdmin()) {
                    if (isset($data['role_id']) && $data['role_id'] != "") {
                        $role = Role::find($data['role_id']);

                        // Check if the posted role_id same with client's current role
                        // if not revoke the old role and assign a new one
                        if ($role && !$record->hasRole($role)) {

                            // Check if the user has any role
                            if (!$record->hasAnyRole(Role::all())) {
                                $record->assignRole($role);
                            } else {
                                $currentRole = $record->getRoleNames()[0];
                                $record->removeRole($currentRole);
                                $record->assignRole($role);
                            } 
                        }
                    }
                }

                $validator = $clientTagModel::validators($tagData, true);
                if ($validator) {
                    // First remove older tags.
                    $find = $clientTagModel::where('user_id', $id)->delete();
                    /*if (!empty($find) && !$find->isEmpty()) {
                        // self::remove($find);
                    }*/

                    foreach ((array)$tagData as $index => $data) {
                        $tagDatas = [];

                        if (is_array($data)) {
                            foreach ($data as $tag) {
                                $tagDatas['user_id'] = $id;
                                $tagDatas['tag_id']  = $tag;

                                $tagCreate = $clientTagModel->create($tagDatas);
                            }
                        }
                    }
                }

                return redirect('folders')->with('success', __("Folder updated!"));
            }
        }

        return redirect('folders')->with('error', __("There has been an error!"));
    }

    public function destroy(int $id)
    {
        $record = User::where('id', $id)->get();

        if (!empty($record[0])) {
            DB::beginTransaction();

            $find = ClientTag::where('user_id', $id)->get();
            if (!empty($find) && !$find->isEmpty()) {
                self::remove($find);
            }

            $isRemoved = self::remove($record);

            if ($isRemoved) {
                self::createLog($record[0], __("Deleted client " . $record[0]->name), Log::DELETE, $record[0]->toArray(), []);

                DB::commit();

                return redirect('folders')->with('success', __("Folder deleted!"));
            } else {
                DB::rollBack();

                return redirect('folders')->with('error', __("There has been an error!"));
            }
        }

        return redirect('folders')->with('error', __("Not found!"));
    }

    public function show($id)
    {
        $record = User::find($id);

        if ($record) {
            $permissions = app('App\Http\Controllers\Roles\RoleController')->getPermissionsByGroup();

            return view('folders.show', ['client' => $record, 'groups' => $permissions]);
        }

        return redirect('folders')->with('error', __("Client not found!"));
    }
}
