<?php

namespace App\Http\Controllers\Api;


use App\Feedback;
use App\AppClientStars;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreFeedback;
use App\Http\Requests\StoreClientStars;


/**
 * Class FeedbackController
 * @package App\Http\Controllers\Api
 */
class FeedbackController extends Controller
{


    /**
     * @param StoreFeedback $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function create(StoreFeedback $request)
    {

        Feedback::create( ['message' => $request->message,] );

        return response()->json(['success'=> true]);

    }

    /**
     * @param StoreClientStars $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function stars(StoreClientStars $request, $id)
    {

        $user = getUser();

        AppClientStars::create( ['stars' => $request->stars,'app_client_id' => $id,'app_user_id' => $user->id,'instance_id' => $request->instance_id] );

        return response()->json(['success'=> true]);

    }
}
