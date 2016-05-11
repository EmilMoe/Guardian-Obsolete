<?php

namespace EmilMoe\Guardian\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use EmilMoe\Guardian\Http\Models\Role;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;

class RolesController extends Controller
{
    /**
     * Validation rules for changing data.
     *
     * @var array
     */
    protected $rules = ['name' => 'required'];

    /**
     * List all accessible roles.
     *
     * @return Collection|static[]
     */
    public function index()
    {
        return Role::with('permissions')
            ->client()
            ->get();
    }

    /**
     * Create new role.
     *
     * @param Request $request
     * @return Model
     */
    public function store(Request $request)
    {
        $this->validate($request, $this->rules);

        return Role::create($request->all());
    }

    /**
     * Update existent role.
     *
     * @param Request $request
     * @param $id
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, $this->rules);

        Role::client()
            ->findOrFail($id)
            ->update($request->all());
    }

    /**
     * Show a single role.
     *
     * @param $id
     * @return mixed
     */
    public function show($id)
    {
        return Role::where('id', $id)
            ->client()
            ->with('permissions')
            ->with('users')
            ->get();
    }

    /**
     * Delete a single role.
     *
     * @param $id
     */
    public function destroy($id)
    {
        Role::client()
            ->findOrFail($id)
            ->delete();
    }
}