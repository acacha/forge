<?php

use App\User;
use Spatie\Permission\Exceptions\PermissionAlreadyExists;
use Spatie\Permission\Exceptions\RoleAlreadyExists;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

if (! function_exists('initialize_forge_management_permissions')) {

    /**
     * Initialize staff management permissions and roles.
     */
    function initialize_forge_management_permissions()
    {
        //ROLES
        $manageForge = role_first_or_create('manage-forge');
        $student = role_first_or_create('student');

        //MANAGE FORGE ROLE
        permission_first_or_create('store-user-servers');
        give_permission_to_role($manageForge,'store-user-servers');

        //STUDENT ROLE
        permission_first_or_create('todo');
        give_permission_to_role($student,'todo');

        app(PermissionRegistrar::class)->registerPermissions();

    }
}

if (! function_exists('first_user_as_forge_manager')) {
    /**
     * Seed teachers.
     */
    function first_user_as_relationships_manager()
    {
        initialize_forge_permissions();
        $user = User::all()->first();
        $user->assignRole('manage-forge');
    }
}

if (! function_exists('role_first_or_create')) {
    /**
     * Create  role by name or retrieve role if already exists.
     * @param $role
     * @return \Illuminate\Database\Eloquent\Model|\Spatie\Permission\Contracts\Role|Role
     */
    function role_first_or_create($role)
    {
        try {
            return Role::create(['name' => $role]);
        } catch (RoleAlreadyExists $e) {
            return Role::findByName($role);
        }
    }
}

if (! function_exists('permission_first_or_create')) {
    /**
     * Create permission by name or retrieve permission if already exists.
     *
     * @param $permission
     * @return \Illuminate\Database\Eloquent\Model|\Spatie\Permission\Contracts\Permission
     */
    function permission_first_or_create($permission)
    {
        try {
            return Permission::create(['name' => $permission]);
        } catch (PermissionAlreadyExists $e) {
            return Permission::findByName($permission);
        }
    }
}

if (! function_exists('give_permission_to_role')) {
    /**
     * @param $role
     * @param $permission
     */
    function give_permission_to_role($role, $permission)
    {
        try {
            $role->givePermissionTo($permission);
        } catch (Illuminate\Database\QueryException $e) {
            info('Permissions ' . $permission . ' already assigned to role ' . $role->name);
        }
    }
}
