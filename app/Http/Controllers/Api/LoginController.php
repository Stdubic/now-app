<?php

namespace App\Http\Controllers\Api;


use App\AppClient;
use App\AppUser;
use App\Http\Resources\AppClientResource;
use App\Http\Resources\AppUserResource;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\OauthCheck;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use Laravel\Socialite\Facades\Socialite;


/**
 * Class LoginController
 * @package App\Http\Controllers\Api
 */
class LoginController extends Controller
{

    /**
     * @param LoginRequest $request
     * @return AppClientResource|AppUserResource|null|void
     */
    public function login(LoginRequest $request)
    {
        $user = $this->loginAppUser($request) ?? $this->loginClient( $request);
        return $user ?? abort(401);
    }

    /**
     * @param LoginRequest $request
     * @return AppUserResource|null
     */
    private function loginAppUser(LoginRequest $request)
    {
        $user = AppUser::where([
            'email' => $request->email,
            'active' => 1
        ])->first();

        $user = ($user && Hash::check($request->password, $user->password)) ? new AppUserResource($user) : null;
        if($user) return $user;

    }

    /**
     * @param LoginRequest $request
     * @return AppClientResource|null
     */
    private function loginClient(LoginRequest $request)
    {
        $user = AppClient::where([
            'email' => $request->email,
            'active' => 1
        ])->first();

        $user = ($user && Hash::check($request->password, $user->password)) ? new AppClientResource($user) : null;
        if($user) return $user;

    }

    /**
     * @param OauthCheck $request
     * @return \Illuminate\Http\JsonResponse | AppUserResource
     */
    public function facebook(OauthCheck $request)
    {

        try
        {
            $user = Socialite::driver('facebook')->userFromToken($request->token);
        }
        catch (\Exception $e)
        {
            return response()->json(['success'=> false]);
        }

        if(AppUser::where('facebook_id', '=', $user->getId())->count() > 0)
        {
            $user = AppUser::where('facebook_id', '=', $user->getId())->first();

            return new AppUserResource($user);
        }
        else
        {
            return response()->json(['success'=> false]);
        }

    }
    /**
     * @param OauthCheck $request
     * @return \Illuminate\Http\JsonResponse | AppUserResource
     */
    public function google(OauthCheck $request)
    {

        try
        {
            $user = Socialite::driver('google')->userFromToken($request->token);
        }
        catch (\Exception $e)
        {
            return response()->json(['success'=> false]);
        }

        if(AppUser::where('google_id', '=', $user->getId())->count() > 0)
        {
            $user = AppUser::where('google_id', '=', $user->getId())->first();

            return new AppUserResource($user);
        }
        else
        {
            return response()->json(['success'=> false]);
        }

    }


}
