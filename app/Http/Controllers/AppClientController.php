<?php

namespace App\Http\Controllers;

use App\AppClient;
use App\InstanceClient;
use App\Instance;
use App\Category;
use App\Http\Requests\StoreAppClient;
use App\Http\Requests\MultiValues;
use Illuminate\Support\Facades\Hash;

/**
 * Class AppClientController
 * @package App\Http\Controllers
 */
class AppClientController extends Controller
{

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $users = AppClient::orderBy('name')->get();

        return view('app-clients.list', compact('users'));
    }


    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        $categories = Category::orderBy('name')->get();

        return view('app-clients.add', compact('categories'));
    }


    /**
     * @param StoreAppClient $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(StoreAppClient $request)
    {
        AppClient::create([
            'name' => $request->name,
            'email' => strtolower($request->email),
            'address' => $request->address,
            'post_code' => $request->post_code,
            'contact_number' => $request->contact_number,
            'city' => $request->city,
            'latitude' => $request->location_lat,
            'longitude' => $request->location_lng,
            'category' => $request->category,
            'password' => Hash::make($request->password),
            'active' => isset($request->active),
            'timezone' => 'UTC',
            'role_id' => setting('registration_api_role_id')
        ]);

        return redirect(route('app-clients.list'));
    }


    /**
     * @param $id
     */
    public function show($id)
    {
        //
    }


    /**
     * @param AppClient $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(AppClient $id)
    {
        $user = $id;
        $categories = Category::orderBy('name')->get();
        $instance_ids = InstanceClient::where('user_id' ,'=' ,$user->id)->pluck('instance_id')->toArray();
        $instances = Instance::with('type','category')->orderBy('created_at', 'desc')->whereIn('id', $instance_ids)->get();

        return view('app-clients.add', compact('user', 'categories','instances'));
    }


    /**
     * @param StoreAppClient $request
     * @param AppClient $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(StoreAppClient $request, AppClient $id)
    {


        $id->update([
            'name' => $request->name,
            'email' => strtolower($request->email),
            'address' => $request->address,
            'post_code' => $request->post_code,
            'contact_number' => $request->contact_number,
            'city' => $request->city,
            'latitude' => $request->location_lat,
            'longitude' => $request->location_lng,
            'category' => $request->category,
            'password' => Hash::make($request->password),
            'active' => isset($request->active),
            'timezone' => 'UTC',
            'role_id' => setting('registration_api_role_id')
        ]);

        return redirect(route('app-clients.list'));
    }


    /**
     * @param AppClient $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Exception
     */
    public function destroy(AppClient $id)
    {
        $id->delete();

        return redirect(route('app-clients.list'));
    }

    /**
     * @param MultiValues $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function multiActivate(MultiValues $request)
    {
        AppClient::whereIn('id', $request->values)->update(['active' => 1]);

        return back();
    }

    /**
     * @param MultiValues $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function multiDeactivate(MultiValues $request)
    {
        AppClient::whereIn('id', $request->values)->update(['active' => 0]);

        return back();
    }

    /**
     * @param MultiValues $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function multiRemove(MultiValues $request)
    {
        AppClient::destroy($request->values);

        return back();
    }
}
