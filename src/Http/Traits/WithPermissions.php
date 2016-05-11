<?php

namespace EmilMoe\Guardian\Http\Traits;

use EmilMoe\Guardian\Http\Models\Role;
use EmilMoe\Guardian\Support\Guardian;
use EmilMoe\Guardian\Http\Models\Permission;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;

trait WithPermissions
{
    /**
     * Get all roles the user is attached to.
     *
     * @return EloquentCollection
     */
    public function roles()
    {
        return $this->belongsToMany(Role::class, Guardian::getUsersRolesTable());
    }

    /**
     * Get all permissions the user has access to through roles.
     *
     * @return Collection
     */
    public function permissions()
    {
        $p = collect([]);

        foreach ($this->roles()->get() as $role)
            $p = $p->merge($role->permissions()->get());

        return $p->unique();
    }

    /**
     * Check whether the user has access to a specific permission.
     * If ID is provided a check for local access and inherit access
     * will be performed automatically too.
     *
     * @param $permission
     * @param null $id
     * @return bool
     */
    public function hasAccess($permission, $id = null)
    {
        if ($this->hasGlobalAccess($permission))
            return true;

        if ($this->hasLocalAccess($permission, $id))
            return true;

        if ($this->hasInheritAccess($permission, $id))
            return true;

        return false;
    }

    /**
     * Check whether the user has access to a permission at any
     * given point. If user does not have global access but
     * local access in 1 or more occurrences the hasAccessAny
     * will return true.
     *
     * @param $permission
     * @return bool
     */
    public function hasAccessAny($permission)
    {
        if ($this->hasAccess($permission))
            return true;

        $permission = Permission::where('name', $permission);

        if ($permission->count() == 0 || $permission->first()->table == null)
            return false;

        return DB::table(Permission::where('name', $permission)->first()->table)
            ->where($permission->first()->user_id_column, Auth::id())
            ->where('is_privileged', true)
            ->count() > 0;
    }

    /**
     * Determines whether the user has global access to the
     * given permission.
     *
     * @param $permission
     * @return bool
     */
    private function hasGlobalAccess($permission)
    {
        return $this->permissions()->contains('name', $permission);
    }

    /**
     * Determines whether the user has local access to the
     * permission with the given ID.
     *
     * @param $permission
     * @param $id
     * @return bool
     */
    private function hasLocalAccess($permission, $id)
    {
        if (! $id)
            return false;

        $permission = Permission::where('name', $permission);

        if ($permission->count() == 0 || $permission->first()->table == null)
            return false;

        if (DB::table($permission->first()->table)
                ->where($permission->first()->user_id_column, Auth::id())
                ->where($permission->first()->foreign_id_column, $id)
                ->where('is_privileged', true)
                ->count() > 0)
            return true;

        return false;
    }

    /**
     * Determining whether the user is granted access to a
     * permission indirectly through inheritance where a
     * superior permission grants access down a tree
     * structure.
     *
     * @param $permission
     * @param $id
     * @return bool
     */
    private function hasInheritAccess($permission, $id)
    {
        if (! $id)
            return false;

        if (method_exists(Auth::user(), $permission .'Privilege'))
            return Auth::user()->{$permission .'Privilege'}($id);

        return false;
    }
}