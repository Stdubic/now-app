<?php

namespace App\Http\Controllers\Api;


use App\AppClient;
use App\AppUser;
use App\Claim;
use App\Instance;
use App\InstanceClient;
use App\Http\Resources\AppClientResource;
use App\Http\Resources\AppUserResource;
use App\Http\Resources\InstanceResource;
use App\Http\Resources\ClaimResource;
use App\Http\Requests\ChangePassword;
use App\Http\Requests\DeleteUser;
use App\Http\Requests\EditProfile;
use App\Http\Requests\ExistsRequest;
use App\Http\Requests\CategoryInterest;
use App\Http\Requests\ClientTos;
use App\Http\Requests\OauthCheck;
use App\Http\Requests\StripeOauth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\MediaStorage;
use Laravel\Socialite\Facades\Socialite;


/**
 * Class ProfileController
 * @package App\Http\Controllers\Api
 */
class ProfileController extends Controller
{
    /**
     * ProfileController constructor.
     */
    public function __construct()
    {
        \Stripe\Stripe::setApiKey(setting('stripe_rest_api_key'));
        \Stripe\Stripe::setClientId(setting('stripe_client_id'));
    }
    /**
     * @return AppClientResource|AppUserResource
     */
    public function me()
    {

        $user = getUser();
        return $user::IS_CLIENT ? new AppClientResource($user) : new AppUserResource($user);

    }

    /**
     * @param DeleteUser $request
     * @return \Illuminate\Http\JsonResponse|void
     */
    public function delete(DeleteUser $request)
    {

        $user = getUser();

        if(!Hash::check($request->password, $user->password)) return abort(403);

        $user->delete();

        return response()->json(['success'=> true]);

    }

    /**
     * @param EditProfile $request
     * @return AppClientResource|AppUserResource
     */
    public function edit(EditProfile $request)
    {
        $user = getUser();

        if( $user::IS_CLIENT )
        {
            $user = AppClient::find($user->id);

            $user->name = $request->name;
            $user->city = $request->city;
            $user->address = $request->address;
            $user->post_code = $request->post_code;
            $user->contact_number = $request->contact_number;
            $user->latitude = $request->lat;
            $user->longitude = $request->long;

            $user->save();


            return new AppClientResource($user);
        }

        else{

            $user = AppUser::find($user->id);

            $user->first_name = $request->first_name;
            $user->last_name = $request->last_name;
            $user->contact_number = $request->contact_number;

            $user->save();

            return new AppUserResource($user);

        }


    }

    /**
     * @param ExistsRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function exists(ExistsRequest $request)
    {

        if (AppUser::where('email', '=', $request->email)->count() > 0 || AppClient::where('email', '=', $request->email)->count() > 0 )
        {
           return response()->json(['exists' => true]);
        }
        else
        {
            return response()->json(['exists' => false]);
        }

    }

    /**
     * @param ChangePassword $request
     * @return AppClientResource|AppUserResource|void
     */
    public function updatePassword(ChangePassword $request)
    {

        $user = getUser();
        if(!Hash::check($request->password_old, $user->password)) return abort(403);

        $user->password = Hash::make($request->password);
        $user->save();

        return $user->IsAppClient() ? new AppClientResource($user) : new AppUserResource($user);

    }

    /**
     * @param CategoryInterest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function categoriesOfInterest(CategoryInterest $request)
    {

        $user = getUser();

        $user->favorite_category_ids = array_map(function($value) { return (int)$value; },$request->category_ids);
        $user->save();

        return response()->json(['success'=> true]);

    }

    /**
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function claims()
    {

        $user = getUser();
        return ClaimResource::collection(Claim::with('instance')->whereUserId($user->id)->get());

    }

    /**
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     * @return InstanceResource
     */
    public function instances()
    {

        $user = getUser();
        $client_instance = InstanceClient::where('user_id', $user->id)->pluck('instance_id')->toArray();

        return InstanceResource::collection( Instance::with('type','category','claims')->whereIn('id', $client_instance)->paginate(50) );

    }

    /**
     * @param ClientTos $request
     * @return AppClientResource
     */
    public function tos(ClientTos $request)
    {
        $user = getUser();

        $storage = new MediaStorage;

        $storage->deleteDir('tos/'.$request->id);
        $storage->handle(['tos' => $request->tos], ['tos' => 'tos/'.$user->id.'/tos']);

        $user->save();

        return new AppClientResource($user);
    }

    /**
     * @return  AppUserResource
     */
    public function revokeFacebook()
    {

        $user = getUser();

        $user->facebook_id = null;

        $user->save();

        return new AppUserResource($user);

    }


    /**
     * @return AppUserResource
     */
    public function revokeGoogle()
    {

        $user = getUser();

        $user->google_id = null;

        $user->save();

        return new AppUserResource($user);


    }

    /**
     * @param OauthCheck $request
     * @return \Illuminate\Http\JsonResponse | AppUserResource
     */
    public function connectFacebook(OauthCheck $request)
    {
        try
        {
            $user = Socialite::driver('facebook')->userFromToken($request->token);
        }
        catch (\Exception $e)
        {
            return response()->json(['success'=> false]);
        }

        $app_user = AppUser::where('facebook_id', '=', $user->getId())->first();

        if ($app_user === null)
        {

            $app_user = getUser();

            $app_user->facebook_id = $user->getId();

            $app_user->save();
        }
        else
        {
            return response()->json(['success'=> false], 409);
        }


        return new AppUserResource($app_user);

    }


    /**
     * @param OauthCheck $request
     * @return \Illuminate\Http\JsonResponse | AppUserResource
     */
    public function connectGoogle(OauthCheck $request)
    {
        try
        {
            $user = Socialite::driver('google')->userFromToken($request->token);
        }
        catch (\Exception $e)
        {
            return response()->json(['success'=> false]);
        }

        $app_user = AppUser::where('google_id', '=', $user->getId())->first();

        if ($app_user === null)
        {

            $app_user = getUser();

            $app_user->google_id = $user->getId();

            $app_user->save();
        }
        else
        {
            return response()->json(['success'=> false], 409);
        }


        return new AppUserResource($app_user);

    }


    /**
     * @param StripeOauth $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function stripeDisconnect(StripeOauth $request)
    {

        $user = getUser();

        $user->stripe_account = null;

        $user->save();

        try
        {
            \Stripe\OAuth::deauthorize([
                'stripe_user_id' => $request->code,
            ]);

        }
        catch (\Exception  $e)
        {

            return response()->json(['success'=> false,'error'=> $e->getMessage()]);

        }

        return response()->json(['success'=> true]);


    }

}
