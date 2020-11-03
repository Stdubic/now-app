<?php

namespace App\Http\Controllers;

use App\Role;
use App\RoleRoute;
use Illuminate\Http\Request;
use App\Http\Requests\StoreRole;
use App\Http\Requests\MultiValues;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $roles = Role::orderBy('name')->get();

		return view('roles.list', compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('roles.add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRole $request)
    {
        $role = Role::create([
			'name' => $request->name,
			'view_all' => isset($request->view_all),
			'mode' => $request->mode
		]);

		$routes = isset($request->routes) ? $request->routes : [];

		foreach($routes as $route)
		{
			RoleRoute::create([
				'role_id' => $role->id,
				'route' => $route
			]);
		}

		return redirect(route('roles.list'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Role  $Role
     * @return \Illuminate\Http\Response
     */
    public function show(Role $Role)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Role  $Role
     * @return \Illuminate\Http\Response
     */
    public function edit(Role $id)
    {
        $role = $id;

		return view('roles.add', compact('role'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Role  $Role
     * @return \Illuminate\Http\Response
     */
    public function update(StoreRole $request, Role $id)
    {
        $id->update([
			'name' => $request->name,
			'view_all' => isset($request->view_all),
			'mode' => $request->mode
		]);

		$id->routes()->delete();
		$routes = isset($request->routes) ? $request->routes : [];

		foreach($routes as $route)
		{
			RoleRoute::create([
				'role_id' => $id->id,
				'route' => $route
			]);
		}

		return redirect(route('roles.list'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Role  $Role
     * @return \Illuminate\Http\Response
     */
    public function destroy(Role $id)
    {
        $id->delete();

		return $this->index();
	}

	public function multiRemove(MultiValues $request)
	{
		Role::destroy($request->values);

		return back();
	}
}
