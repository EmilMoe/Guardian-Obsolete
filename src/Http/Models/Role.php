<?php

namespace EmilMoe\Guardian\Http\Models;

use EmilMoe\Guardian\Support\Guardian;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Role extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'client_id'];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = ['locked' => 'boolean'];

    /**
     * Save a new model and return the instance.
     *
     * @param array $attributes
     * @return static
     */
    public static function create(array $attributes = [])
    {
        if (Guardian::hasClients())
            $attributes[Guardian::getClientColumn()] = Guardian::getClientId();

        return parent::create($attributes);
    }

    /**
     * Create a new Role model instance.
     *
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        $this->table = config('guardian.table.role');
        parent::__construct($attributes);
    }

    /**
     * Get all permissions attached to the role.
     *
     * @return BelongsToMany
     */
    public function permissions()
    {
        return $this->belongsToMany(Permission::class, Guardian::getRolesPermissionsTable(), 'role_id', 'permission_id')
            ->withTimestamps();
    }

    /**
     * Get all users that are attached to the role.
     * 
     * @return BelongsToMany
     */
    public function users()
    {
        return $this->belongsToMany(Guardian::getUserClass(), Guardian::getUsersRolesTable(), 'role_id', 'user_id')
            ->withTimestamps();
    }

    /**
     * Update the model in the database.
     *
     * @param array $attributes
     * @param array $options
     * @return bool|int
     */
    public function update(array $attributes = [], array $options = [])
    {
        if (Guardian::hasClients())
            $attributes[Guardian::getClientColumn()] = Guardian::getClientId();

        if ($this->locked)
            return false;

        return parent::update($attributes, $options);
    }

    /**
     * Add user to role.
     *
     * If user doesn't have same client id or role is locked,
     * the action will be prevented.
     *
     * @param int $userid
     */
    public function addUser($userid)
    {
        if ($this->locked == true)
            return;

        if (Guardian::hasClients())
            if (Guardian::getClientId() != $this->{Guardian::getClientColumn()})
                return;

        if (! $this->users()->get()->contains($userid))
            $this->users()->attach($userid);
    }

    /**
     * Remove user from role.
     *
     * If user doesn't have same client id or role is locked,
     * the action will be prevented.
     *
     * @param int $userid
     */
    public function removeUser($userid)
    {
        if ($this->locked == true)
            return;

        if (Guardian::hasClients())
            if (Guardian::getClientId() != $this->{Guardian::getClientColumn()})
                return;

        $this->users()->detach($userid);
    }

    /**
     * Add permission to role.
     *
     * If user doesn't have same client id or role is locked,
     * the action will be prevented.
     *
     * @param string $permission
     */
    public function addPermission($permission)
    {
        if ($this->locked == true)
            return;

        if (Guardian::hasClients())
            if (Guardian::getClientId() != $this->{Guardian::getClientColumn()})
                return;

        $id = Permission::where('name', $permission)->first()->id;

        if (! $this->permissions()->get()->contains($id))
            $this->permissions()->attach($id);
    }

    /**
     * Remove permission from role.
     *
     * If user doesn't have same client id or role is locked,
     * the action will be prevented.
     *
     * @param string $permission
     */
    public function removePermission($permission)
    {
        if ($this->locked == true)
            return;

        if (Guardian::hasClients())
            if (Guardian::getClientId() != $this->{Guardian::getClientColumn()})
                return;

        $id = Permission::where('name', $permission)->first()->id;

        $this->permissions()->detach($id);
    }

    /**
     * Scope to require client ID is met.
     *
     * @param $query
     * @return mixed
     */
    public function scopeClient($query)
    {
        if (! Guardian::hasClients())
            return $query;

        return $query->where('client_id', Guardian::getClientId());
    }

    /**
     * Scope to ensure selected roles are not locked.
     *
     * @param $query
     * @return mixed
     */
    public function scopeNotLocked($query)
    {
        return $query->where('locked', false);
    }
}