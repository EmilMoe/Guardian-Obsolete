<?php

namespace EmilMoe\Guardian\Http\Models;

use EmilMoe\Guardian\Support\Guardian;
use Illuminate\Database\Eloquent\Model;

class Permission extends Model
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
    protected $fillable = ['name'];

    /**
     * Create a new Permission model instance.
     *
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        $this->table = Guardian::getPermissionTable();
        parent::__construct($attributes);
    }
}