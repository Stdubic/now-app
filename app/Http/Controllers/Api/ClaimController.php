<?php

namespace App\Http\Controllers\Api;


use App\Claim;
use App\InstanceClient;
use App\Http\Resources\ClaimResource;
use App\Http\Controllers\Controller;
use App\Http\Requests\ClaimToken;
use Carbon\Carbon;


/**
 * Class ClaimController
 * @package App\Http\Controllers\Api
 */
class ClaimController extends Controller
{

    /**
     * @param ClaimToken $request
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function clientToken(ClaimToken $request)
    {

        $jwtClient = getUser();

        $claim = Claim::where('claim_token',$request->token)->firstOrFail();

        $instanceClient = InstanceClient::where('instance_id', $claim->instance_id)->firstOrFail();


        if ($jwtClient->id == $instanceClient->user_id)
        {

            return ClaimResource::collection(Claim::with('instance')->where('claim_token',$request->token)->get());
        }
        else
        {

            return response()->json(['success'=> false,'error' =>'unauthorized']);
        }


    }

    /**
     * @param $id
     * @return ClaimResource
     */
    public function show($id)
    {

        $claim = Claim::findOrFail($id);

        return new ClaimResource($claim);

    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function confirm($id)
    {

        $now = Carbon::now()->toDateTimeString();

        Claim::findOrFail($id)->update(['redeemed' => 1 , 'claim_timestamp'=> $now]);

        return response()->json(['success'=> true]);

    }


}
