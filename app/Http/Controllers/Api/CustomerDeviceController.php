<?php

namespace App\Http\Controllers\API;

use App\UserDevice;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserDevice;
use App\Http\Resources\UserDevicesResource;
use App\Http\Resources\CustomerDevicesResource;


/**
 * Class CustomerDeviceController
 * @package App\Http\Controllers\API
 */
class CustomerDeviceController extends Controller
{
    /**
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index()
    {

        return UserDevicesResource::collection(
            UserDevice::where( 'app_user_id', getUser()->id)->paginate(50)
        );
    }


    /**
     * @param StoreUserDevice $request
     * @return CustomerDevicesResource
     */
    public function store(StoreUserDevice $request)
    {
        UserDevice::where([
            ['device_id', $request->device_id],
            ['app_user_id', '<>', getUser()->id]
        ])->delete();

        $device = UserDevice::firstOrCreate([
            'device_id' => $request->device_id,
            'app_user_id' => getUser()->id
        ]);

        return new CustomerDevicesResource($device);
    }

    /**
     * @param StoreUserDevice $request
     * @return array
     */
    public function remove(StoreUserDevice $request)
    {
        return ['status' => UserDevice::where([
            ['device_id', $request->device_id],
            ['app_user_id', '=', getUser()->id]
        ])->delete()];
    }

}
