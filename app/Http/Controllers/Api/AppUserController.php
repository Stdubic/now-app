<?php

namespace App\Http\Controllers\Api;

use App\AppUser;
use App\Http\Requests\RegisterAppUser;
use App\Http\Requests\RegisterOauthAppUser;
use App\Http\Resources\AppUserResource;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use Laravel\Socialite\Facades\Socialite;


/**
 * Class AppUserController
 * @package App\Http\Controllers\Api
 */
class AppUserController extends Controller
{
    /**
     * @param RegisterAppUser $request
     * @return AppUserResource
     */
    public function register(RegisterAppUser $request)
    {
        $app_user = AppUser::create([
            'email' => strtolower($request->email),
            'password' => Hash::make($request->password),
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'contact_number' => $request->contact_number,
            'favorite_category_ids' => array_map(function($value) { return (int)$value; },$request->favorite_category_ids),
            'role_id' => setting('registration_api_role_id'),
        ]);

        return new AppUserResource($app_user);
    }

    /**
     * @param RegisterOauthAppUser $request
     * @return \Illuminate\Http\JsonResponse | AppUserResource
     */
    public function facebookRegister(RegisterOauthAppUser $request)
    {

        try
        {
            $user = Socialite::driver('facebook')->userFromToken($request->access_token);
        }
        catch (\Exception $e)
        {
            return response()->json(['success'=> false]);
        }
        $app_user = AppUser::where('facebook_id', '=', $user->getId())->first();

        if ($app_user === null)
        {

            $app_user = AppUser::create([
                'email' => strtolower($request->email),
                'password' => Hash::make($request->password),
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'contact_number' => $request->contact_number,
                'favorite_category_ids' => array_map(function($value) { return (int)$value; },$request->favorite_category_ids),
                'role_id' => setting('registration_api_role_id'),
                'facebook_id' => $user->getId()
            ]);
        }
        else
        {
            return response()->json(['success'=> false], 409);
        }


        return new AppUserResource($app_user);
    }

    /**
     * @param RegisterOauthAppUser $request
     * @return \Illuminate\Http\JsonResponse | AppUserResource
     */
    public function googleRegister(RegisterOauthAppUser $request)
    {

        try
        {
            $user = Socialite::driver('google')->userFromToken($request->access_token);
        }
        catch (\Exception $e)
        {
            return response()->json(['success'=> false]);
        }

        $app_user = AppUser::where('facebook_id', '=', $user->getId())->first();

        if ($app_user === null)
        {

            $app_user = AppUser::create([
                'email' => strtolower($request->email),
                'password' => Hash::make($request->password),
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'contact_number' => $request->contact_number,
                'favorite_category_ids' => array_map(function($value) { return (int)$value; },$request->favorite_category_ids),
                'role_id' => setting('registration_api_role_id'),
                'google_id' => $user->getId()
            ]);

        }
        else
        {
            return response()->json(['success'=> false], 409);
        }


        return new AppUserResource($app_user);
    }


}
