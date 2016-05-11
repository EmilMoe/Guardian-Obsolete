<?php

namespace EmilMoe\Guardian\Http\Controllers\Roles;

use App\Http\Controllers\Controller;
use EmilMoe\Guardian\Http\Models\Role;

class PermissionsController extends Controller
{
    /**
     * Attach a permission to a role.
     *
     * @param $role
     * @param $permission
     */
    public function add($role, $permission)
    {
        Role::findOrFail($role)->addPermission($permission);
    }

    /**
     * Detach a permission from a role.
     *
     * @param $role
     * @param $permission
     */
    public function remove($role, $permission)
    {
        Role::findOrFail($role)->removePermission($permission);
    }
}