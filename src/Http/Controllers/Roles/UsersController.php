<?php

namespace EmilMoe\Guardian\Http\Controllers\Roles;

use App\Http\Controllers\Controller;
use EmilMoe\Guardian\Http\Models\Role;

class UsersController extends Controller
{
    /**
     * Attach an user to a role.
     *
     * @param $role
     * @param $user
     */
    public function add($role, $user)
    {
        Role::findOrFail($role)->addUser($user);
    }

    /**
     * Detach an user from a role.
     *
     * @param $role
     * @param $user
     */
    public function remove($role, $user)
    {
        Role::findOrFail($role)->removeUser($user);
    }
}