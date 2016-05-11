<?php

namespace EmilMoe\Guardian\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use EmilMoe\Guardian\Support\Guardian;
use Illuminate\Database\Eloquent\Model;
use EmilMoe\Guardian\Http\Models\Permission;
use Illuminate\Database\Eloquent\Collection;

class PermissionsController extends Controller
{
    /**
     * Validation rules when changing data.
     *
     * @var array
     */
    protected $rules;

    /**
     * Create a new Permission controller instance.
     *
     * PermissionsController constructor.
     */
    public function __construct()
    {
        $this->rules = ['name' => 'required|unique:'. Guardian::getPermissionTable()];
    }

    /**
     * List all permissions.
     *
     * @return Collection|static[]
     */
    public function index()
    {
        return Permission::all();
    }

    /**
     * Create a new permission.
     *
     * @param Request $request
     * @return Model
     */
    public function store(Request $request)
    {
        $this->validate($request, $this->rules);

        return Permission::create($request->all());
    }

    /**
     * Update a single permission.
     *
     * @param Request $request
     * @param $id
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, $this->rules);

        Permission::findOrFail($id)->update($request->all());
    }

    /**
     * Display a single permission.
     *
     * @param $id
     * @return mixed
     */
    public function show($id)
    {
        return Permission::where('id', $id)->get();
    }

    /**
     * Delete a single permission.
     *
     * @param $id
     */
    public function destroy($id)
    {
        Permission::findOrFail($id)
            ->delete();
    }
}