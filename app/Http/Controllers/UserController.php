<?php

namespace App\Http\Controllers;

use App\User;
use App\Role;
use Illuminate\Http\Request;
use App\Http\Requests\StoreUser;
use App\Http\Requests\MultiValues;
use Illuminate\Support\Facades\Hash;

/**
 * Class UserController
 * @package App\Http\Controllers
 */
class UserController extends Controller
{

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
		$users = User::orderBy('name')->get();

		return view('users.list', compact('users'));
	}


    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
		$roles = Role::orderBy('name')->get();

        return view('users.add', compact('roles'));
    }


    /**
     * @param StoreUser $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(StoreUser $request)
    {
		$status = User::create([
			'name' => $request->name,
			'email' => strtolower($request->email),
			'password' => Hash::make($request->password),
			'active' => isset($request->active),
			'timezone' => $request->timezone,
			'role_id' => isset($request->role_id) ? $request->role_id : setting('registration_role_id')
		]);

		return redirect(route('users.list'));
    }


    /**
     * @param $id
     */
    public function show($id)
    {
        //
    }


    /**
     * @param User $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(User $id)
    {
		$user = $id;
		$roles = Role::orderBy('name')->get();

		return view('users.add', compact('user', 'roles'));
    }


    /**
     * @param Request $request
     * @param User $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(Request $request, User $id)
    {
		$request->validate([
			'name' => 'required|max:50',
			'email' => 'required|max:50|email|unique:users,email,'.$id->id,
			'password' => 'required|confirmed|min:'.setting('min_pass_len'),
			'active' => 'boolean',
			'timezone' => 'required|timezone',
			'role_id' => 'required|integer|min:1'
		]);

		$id->update([
			'name' => $request->name,
			'email' => strtolower($request->email),
			'password' => Hash::make($request->password),
			'active' => isset($request->active),
			'timezone' => $request->timezone,
			'role_id' => $request->role_id
		]);

		return redirect(route('users.list'));
    }


    /**
     * @param User $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Exception
     */
    public function destroy(User $id)
    {
		$id->delete();

		return redirect(route('users.list'));
	}

    /**
     * @param MultiValues $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function multiActivate(MultiValues $request)
	{

        User::whereIn('id', $request->values)->update(['active' => 1]);

		return back();
	}

    /**
     * @param MultiValues $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function multiDeactivate(MultiValues $request)
	{

        User::whereIn('id', $request->values)->update(['active' => 0]);

        return back();
	}

    /**
     * @param MultiValues $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function multiRemove(MultiValues $request)
	{
		User::destroy($request->values);

		return back();
	}
}
