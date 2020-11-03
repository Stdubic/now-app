<?php

namespace App\Http\Controllers;

use App\AppClient;
use App\AppUser;
use App\Claim;
use App\Instance;
use Illuminate\Http\Request;

/**
 * Class DashboardController
 * @package App\Http\Controllers
 */
class DashboardController extends Controller
{

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $app_user_count = AppClient::count();
        $app_client_count = AppUser::count();
        $app_instance_count = Instance::count();
        $app_claims_count = Claim::count();


        return view('dashboard', compact('app_user_count', 'app_client_count','app_instance_count','app_claims_count'));

    }


    /**
     *
     */
    public function create()
    {
        //
    }


    /**
     * @param Request $request
     */
    public function store(Request $request)
    {
        //
    }


    /**
     * @param $id
     */
    public function show($id)
    {
        //
    }


    /**
     * @param $id
     */
    public function edit($id)
    {
        //
    }


    /**
     * @param Request $request
     * @param $id
     */
    public function update(Request $request, $id)
    {
        //
    }


    /**
     * @param $id
     */
    public function destroy($id)
    {
        //
    }
}
