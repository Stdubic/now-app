<?php

namespace App\Http\Controllers;

use App\AppUser;
use Illuminate\Http\Request;
use App\Http\Requests\StoreAppUser;
use App\Http\Requests\MultiValues;
use Illuminate\Support\Facades\Hash;

/**
 * Class AppUserController
 * @package App\Http\Controllers
 */
class AppUserController extends Controller
{

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $users = AppUser::orderBy('first_name')->get();

        return view('app-users.list', compact('users'));
    }


    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {

        return view('app-users.add');
    }


    /**
     * @param StoreAppUser $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(StoreAppUser $request)
    {
        $status = AppUser::create([
            'first_name' => $request->name,
            'email' => strtolower($request->email),
            'password' => Hash::make($request->password),
            'active' => isset($request->active),
            'timezone' => $request->timezone,
            'role_id' => setting('registration_api_role_id')
        ]);

        return redirect(route('app-users.list'));
    }


    /**
     * @param $id
     */
    public function show($id)
    {
        //
    }


    /**
     * @param AppUser $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(AppUser $id)
    {
        $user = $id;

        return view('app-users.add', compact('user'));
    }


    /**
     * @param Request $request
     * @param AppUser $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(StoreAppUser $request, AppUser $id)
    {

        $id->update([
            'first_name' => $request->name,
            'email' => strtolower($request->email),
            'password' => Hash::make($request->password),
            'active' => isset($request->active),
            'role_id' => setting('registration_api_role_id')
        ]);

        return redirect(route('app-users.list'));
    }


    /**
     * @param AppUser $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Exception
     */
    public function destroy(AppUser $id)
    {
        $id->delete();

        return redirect(route('app-users.list'));
    }

    /**
     * @param MultiValues $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function multiActivate(MultiValues $request)
    {

        AppUser::whereIn('id', $request->values)->update(['active' => 1]);

        return back();
    }

    /**
     * @param MultiValues $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function multiDeactivate(MultiValues $request)
    {

        AppUser::whereIn('id', $request->values)->update(['active' => 0]);

        return back();
    }

    /**
     * @param MultiValues $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function multiRemove(MultiValues $request)
    {
        AppUser::destroy($request->values);

        return back();
    }
}
