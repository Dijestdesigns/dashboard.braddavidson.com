<?php

use Illuminate\Database\Seeder;
use App\User;
use App\Role;
use App\Permission;
use Illuminate\Support\Facades\Hash;

class DefaultUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::create([
            'id'            => User::$superadminId,
            'name'          => 'Brad Davidson',
            'email'         => 'brad.davidson@gmail.com',
            'password'      => Hash::make('brad@adminShiv#$'),
            'is_superadmin' => true,
        ]);

        $adminRole = Role::create([
            'id'         => 1,
            'name'       => 'Superadmin',
            'guard_name' => 'admin'
        ]);

        $permissions = [
            ['name' => 'clients_access', 'display_name' => 'Client Access', 'group_name' => 'Clients', 'group_slug' => 'clients', 'guard_name' => 'admin'],
            ['name' => 'clients_create', 'display_name' => 'Client Create', 'group_name' => 'Clients', 'group_slug' => 'clients', 'guard_name' => 'admin'],
            ['name' => 'clients_show', 'display_name' => 'Client Show', 'group_name' => 'Clients', 'group_slug' => 'clients', 'guard_name' => 'admin'],
            ['name' => 'clients_edit', 'display_name' => 'Client Edit', 'group_name' => 'Clients', 'group_slug' => 'clients', 'guard_name' => 'admin'],
            ['name' => 'clients_delete', 'display_name' => 'Client Delete', 'group_name' => 'Clients', 'group_slug' => 'clients', 'guard_name' => 'admin'],

            ['name' => 'tags_access', 'display_name' => 'Tag Access', 'group_name' => 'Tags', 'group_slug' => 'tags', 'guard_name' => 'admin'],
            ['name' => 'tags_create', 'display_name' => 'Tag Create', 'group_name' => 'Tags', 'group_slug' => 'tags', 'guard_name' => 'admin'],
            ['name' => 'tags_edit', 'display_name' => 'Tag Edit', 'group_name' => 'Tags', 'group_slug' => 'tags', 'guard_name' => 'admin'],
            ['name' => 'tags_delete', 'display_name' => 'Tag Delete', 'group_name' => 'Tags', 'group_slug' => 'tags', 'guard_name' => 'admin'],

            ['name' => 'inventories_access', 'display_name' => 'Inventories Access', 'group_name' => 'Inventories', 'group_slug' => 'inventories', 'guard_name' => 'admin'],
            ['name' => 'inventories_create', 'display_name' => 'Inventories Create', 'group_name' => 'Inventories', 'group_slug' => 'inventories', 'guard_name' => 'admin'],
            ['name' => 'inventories_edit', 'display_name' => 'Inventories Edit', 'group_name' => 'Inventories', 'group_slug' => 'inventories', 'guard_name' => 'admin'],
            ['name' => 'inventories_change_quantities', 'display_name' => 'Inventories Change Quantities', 'group_name' => 'Inventories', 'group_slug' => 'inventories', 'guard_name' => 'admin'],
            ['name' => 'inventories_move_to_folder', 'display_name' => 'Inventories Move To Folder', 'group_name' => 'Inventories', 'group_slug' => 'inventories', 'guard_name' => 'admin'],
            ['name' => 'inventories_delete', 'display_name' => 'Inventories Delete', 'group_name' => 'Inventories', 'group_slug' => 'inventories', 'guard_name' => 'admin'],

            ['name' => 'coaching_access', 'display_name' => 'Coaching Access', 'group_name' => 'Coaching', 'group_slug' => 'coaching', 'guard_name' => 'admin'],
            ['name' => 'coaching_create', 'display_name' => 'Coaching Create', 'group_name' => 'Coaching', 'group_slug' => 'coaching', 'guard_name' => 'admin'],
            ['name' => 'coaching_edit', 'display_name' => 'Coaching Edit', 'group_name' => 'Coaching', 'group_slug' => 'coaching', 'guard_name' => 'admin'],
            ['name' => 'coaching_delete', 'display_name' => 'Coaching Delete', 'group_name' => 'Coaching', 'group_slug' => 'coaching', 'guard_name' => 'admin'],
            ['name' => 'coaching_show_to_clients', 'display_name' => 'Coaching Show to Clients', 'group_name' => 'Coaching', 'group_slug' => 'coaching', 'guard_name' => 'admin'],
            ['name' => 'coaching_info_access', 'display_name' => 'Coaching Info Access', 'group_name' => 'Coaching', 'group_slug' => 'coaching', 'guard_name' => 'admin'],
            ['name' => 'coaching_info_create', 'display_name' => 'Coaching Info Create', 'group_name' => 'Coaching', 'group_slug' => 'coaching', 'guard_name' => 'admin'],
            ['name' => 'coaching_info_edit', 'display_name' => 'Coaching Info Edit', 'group_name' => 'Coaching', 'group_slug' => 'coaching', 'guard_name' => 'admin'],

            ['name' => 'chat_access', 'display_name' => 'Chat Access', 'group_name' => 'Chat', 'group_slug' => 'chat', 'guard_name' => 'admin'],
            ['name' => 'chat_create', 'display_name' => 'Chat Create', 'group_name' => 'Chat', 'group_slug' => 'chat', 'guard_name' => 'admin'],
            ['name' => 'chat_edit', 'display_name' => 'Chat Edit', 'group_name' => 'Chat', 'group_slug' => 'chat', 'guard_name' => 'admin'],
            ['name' => 'chat_delete', 'display_name' => 'Chat Delete', 'group_name' => 'Chat', 'group_slug' => 'chat', 'guard_name' => 'admin'],
            ['name' => 'chat_group_access', 'display_name' => 'Chat Group Access', 'group_name' => 'Chat', 'group_slug' => 'chat', 'guard_name' => 'admin'],
            ['name' => 'chat_group_add_user', 'display_name' => 'Chat Group Add User', 'group_name' => 'Chat', 'group_slug' => 'chat', 'guard_name' => 'admin'],
            ['name' => 'chat_group_create', 'display_name' => 'Chat Group Create', 'group_name' => 'Chat', 'group_slug' => 'chat', 'guard_name' => 'admin'],
            ['name' => 'chat_group_edit', 'display_name' => 'Chat Group Edit', 'group_name' => 'Chat', 'group_slug' => 'chat', 'guard_name' => 'admin'],
            ['name' => 'chat_group_delete', 'display_name' => 'Chat Group Delete', 'group_name' => 'Chat', 'group_slug' => 'chat', 'guard_name' => 'admin'],
            ['name' => 'chat_group_delete_user', 'display_name' => 'Chat Group Delete User', 'group_name' => 'Chat', 'group_slug' => 'chat', 'guard_name' => 'admin'],

            ['name' => 'calendar_access', 'display_name' => 'Calendar Access', 'group_name' => 'Calendar', 'group_slug' => 'calendar', 'guard_name' => 'admin'],
            ['name' => 'calendar_create', 'display_name' => 'Calendar Create', 'group_name' => 'Calendar', 'group_slug' => 'calendar', 'guard_name' => 'admin'],
            ['name' => 'calendar_edit', 'display_name' => 'Calendar Edit', 'group_name' => 'Calendar', 'group_slug' => 'calendar', 'guard_name' => 'admin'],
            ['name' => 'calendar_delete', 'display_name' => 'Calendar Delete', 'group_name' => 'Calendar', 'group_slug' => 'calendar', 'guard_name' => 'admin'],

            ['name' => 'note_access', 'display_name' => 'Note Access', 'group_name' => 'Notes', 'group_slug' => 'notes', 'guard_name' => 'admin'],
            ['name' => 'note_create', 'display_name' => 'Note Create', 'group_name' => 'Notes', 'group_slug' => 'notes', 'guard_name' => 'admin'],
            ['name' => 'note_edit', 'display_name' => 'Note Edit', 'group_name' => 'Notes', 'group_slug' => 'notes', 'guard_name' => 'admin'],
            ['name' => 'note_delete', 'display_name' => 'Note Delete', 'group_name' => 'Notes', 'group_slug' => 'notes', 'guard_name' => 'admin'],

            ['name' => 'supplements_access', 'display_name' => 'Supplements Access', 'group_name' => 'Supplements', 'group_slug' => 'supplements', 'guard_name' => 'admin'],
            ['name' => 'supplements_create', 'display_name' => 'Supplements Create', 'group_name' => 'Supplements', 'group_slug' => 'supplements', 'guard_name' => 'admin'],
            ['name' => 'supplements_edit', 'display_name' => 'Supplements Edit', 'group_name' => 'Supplements', 'group_slug' => 'supplements', 'guard_name' => 'admin'],
            ['name' => 'supplements_delete', 'display_name' => 'Supplements Delete', 'group_name' => 'Supplements', 'group_slug' => 'supplements', 'guard_name' => 'admin'],

            ['name' => 'stock_levels_access', 'display_name' => 'Stock Level Access', 'group_name' => 'StockLevels', 'group_slug' => 'stock_levels', 'guard_name' => 'admin'],

            ['name' => 'stock_values_access', 'display_name' => 'Stock Value Access', 'group_name' => 'StockValues', 'group_slug' => 'stock_values', 'guard_name' => 'admin'],

            ['name' => 'logs_access', 'display_name' => 'Log Access', 'group_name' => 'Logs', 'group_slug' => 'logs', 'guard_name' => 'admin'],

            ['name' => 'trash_access', 'display_name' => 'Trash Access', 'group_name' => 'Trashes', 'group_slug' => 'trashes', 'guard_name' => 'admin'],

            ['name' => 'constant_update', 'display_name' => 'Constants Update', 'group_name' => 'Constants', 'group_slug' => 'constants', 'guard_name' => 'admin'],

            ['name' => 'roles_access', 'display_name' => 'Access', 'group_name' => 'Roles', 'group_slug' => 'roles', 'guard_name' => 'admin'],
            ['name' => 'roles_create', 'display_name' => 'Create', 'group_name' => 'Roles', 'group_slug' => 'roles', 'guard_name' => 'admin'],
            ['name' => 'roles_edit', 'display_name' => 'Edit', 'group_name' => 'Roles', 'group_slug' => 'roles', 'guard_name' => 'admin'],
            ['name' => 'roles_delete', 'display_name' => 'Delete', 'group_name' => 'Roles', 'group_slug' => 'roles', 'guard_name' => 'admin'],

            ['name' => 'permissions_access', 'display_name' => 'Access', 'group_name' => 'Permissions', 'group_slug' => 'permissions', 'guard_name' => 'admin'],
            ['name' => 'permissions_create', 'display_name' => 'Create', 'group_name' => 'Permissions', 'group_slug' => 'permissions', 'guard_name' => 'admin'],
            ['name' => 'permissions_edit', 'display_name' => 'Edit', 'group_name' => 'Permissions', 'group_slug' => 'permissions', 'guard_name' => 'admin'],
            ['name' => 'permissions_delete', 'display_name' => 'Delete', 'group_name' => 'Permissions', 'group_slug' => 'permissions', 'guard_name' => 'admin'],

            ['name' => 'support_access', 'display_name' => 'Support Access', 'group_name' => 'Support', 'group_slug' => 'support', 'guard_name' => 'admin'],
            ['name' => 'support_create', 'display_name' => 'Support Create', 'group_name' => 'Support', 'group_slug' => 'support', 'guard_name' => 'admin'],
            ['name' => 'support_update', 'display_name' => 'Support Update', 'group_name' => 'Support', 'group_slug' => 'support', 'guard_name' => 'admin'],

            ['name' => 'resource_access', 'display_name' => 'Resource Access', 'group_name' => 'Resources', 'group_slug' => 'resources', 'guard_name' => 'admin'],
            // ['name' => 'resource_show', 'display_name' => 'Resource Show', 'group_name' => 'Resources', 'group_slug' => 'resources', 'guard_name' => 'admin'],
            ['name' => 'resource_create', 'display_name' => 'Resource Create', 'group_name' => 'Resources', 'group_slug' => 'resources', 'guard_name' => 'admin'],
            // ['name' => 'resource_edit', 'display_name' => 'Resource Edit', 'group_name' => 'Resources', 'group_slug' => 'resources', 'guard_name' => 'admin'],
            ['name' => 'resource_delete', 'display_name' => 'Resource Delete', 'group_name' => 'Resources', 'group_slug' => 'resources', 'guard_name' => 'admin'],
        ];

        Permission::insert($permissions);

        $getPermissions = Permission::get();

        $assignPermissions = $getPermissions->map(function($item) {
            return [$item->name];
        });

        $user->assignRole($adminRole);
        $adminRole->givePermissionTo($assignPermissions);

        // Coaches.
        $coachesRole = Role::create([
            'id' => 2,
            'name' => 'Coaches',
            'guard_name' => 'admin'
        ]);

        $assignCoachesPermissions = $getPermissions->map(function($item) {
            $shiv = [
                'clients_access', 'clients_create', 'clients_show', 'clients_edit',
                'coaching_show_to_clients',
                'chat_access', 'chat_create', 'chat_edit',
                'calendar_access', 'calendar_create', 'calendar_edit'
            ];

            if (in_array($item->name, $shiv)) {
                return [$item->name];
            }
        });

        $coaches = User::create([
            'id'            => 2,
            'name'          => 'Coaches',
            'email'         => 'coaches.davidson@gmail.com',
            'created_by'    => User::$superadminId,
            'password'      => Hash::make('coaches@davidson')
        ]);
        // Assign role
        $role = Role::find(2);
        if ($role) {
            $coaches->assignRole($role);
        }

        $coachesRole->givePermissionTo($assignCoachesPermissions);

        // VIP Clients.
        $vipClientsRole = Role::create([
            'id' => 3,
            'name' => 'VIP Clients',
            'guard_name' => 'admin'
        ]);

        $assignVIPClientsPermissions = $getPermissions->map(function($item) {
            $shiv = [
                'coaching_show_to_clients',
                'chat_access', 'chat_create', 'chat_edit',
                'calendar_access', 'calendar_create', 'calendar_edit',
                'diary_access', 'diary_create', 'diary_edit',
                'supplements_access', 'supplements_create', 'supplements_edit'
            ];

            if (in_array($item->name, $shiv)) {
                return [$item->name];
            }
        });
        $vipClientsRole->givePermissionTo($assignVIPClientsPermissions);

        $coaches = User::create([
            'id'            => 3,
            'name'          => 'VIP Clients',
            'email'         => 'vip.clients.davidson@gmail.com',
            'created_by'    => User::$superadminId,
            'password'      => Hash::make('vip.clients@davidson')
        ]);
        // Assign role
        $role = Role::find(3);
        if ($role) {
            $coaches->assignRole($role);
        }

        // Normal Clients.
        $normalClientsRole = Role::create([
            'id' => 4,
            'name' => 'Normal Clients',
            'guard_name' => 'admin'
        ]);

        $assignNormalClientsPermissions = $getPermissions->map(function($item) {
            $shiv = [
                'coaching_show_to_clients',
                'chat_access', 'chat_create', 'chat_edit',
                'calendar_access', 'calendar_create', 'calendar_edit',
                'diary_access', 'diary_create', 'diary_edit',
                'supplements_access', 'supplements_create', 'supplements_edit'
            ];

            if (in_array($item->name, $shiv)) {
                return [$item->name];
            }
        });
        $normalClientsRole->givePermissionTo($assignNormalClientsPermissions);

        $coaches = User::create([
            'id'            => 4,
            'name'          => 'Normal Clients',
            'email'         => 'normal.clients.davidson@gmail.com',
            'created_by'    => User::$superadminId,
            'password'      => Hash::make('normal.clients@davidson')
        ]);
        // Assign role
        $role = Role::find(4);
        if ($role) {
            $coaches->assignRole($role);
        }
    }
}
