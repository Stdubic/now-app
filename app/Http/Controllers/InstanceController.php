<?php

namespace App\Http\Controllers;

use App\Instance;
use App\Http\Requests\StoreInstance;
use App\Http\Requests\MultiValues;

/**
 * Class InstanceController
 * @package App\Http\Controllers
 */
class InstanceController extends Controller
{

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $instances = Instance::with('type','category')->orderBy('created_at', 'desc')->get();

        return view('instances.list', compact('instances'));
    }


    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        return view('instances.add');
    }


    /**
     * @param StoreInstance $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(StoreInstance $request)
    {
        //
    }


    /**
     * @param Instance $document
     */
    public function show(Instance $document)
    {
        //
    }


    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id)
    {
        $instance = Instance::with('type','category')->find($id);

        return view('instances.add', compact('instance','type','category'));
    }


    /**
     * @param StoreInstance $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(StoreInstance $request, $id)
    {
        //
    }


    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function destroy($id)
    {
        //
    }

    /**
     * @param MultiValues $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function multiRemove(MultiValues $request)
    {

        //
    }

}
