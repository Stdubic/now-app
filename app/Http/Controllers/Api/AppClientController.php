<?php

namespace App\Http\Controllers\Api;

use App\AppClient;
use App\AppUser;
use App\Http\Requests\RegisterAppClient;
use App\Http\Resources\AppClientResource;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;

/**
 * Class AppClientController
 * @package App\Http\Controllers\Api
 */
class AppClientController extends Controller
{
    /**
     * @param RegisterAppClient $request
     * @return AppClientResource
     */
    public function register(RegisterAppClient $request)
    {
        $app_user = AppClient::create([
            'email' => strtolower($request->email),
            'password' => Hash::make($request->password),
            'name' => $request->name,
            'address' => $request->address,
            'post_code' => $request->post_code,
            'contact_number' => $request->contact_number,
            'city' => $request->city,
            'category' => $request->category,
            'latitude' => $request->lat,
            'longitude' => $request->long,
            'role_id' => setting('registration_api_role_id'),
        ]);

        return new AppClientResource($app_user);
    }


}
