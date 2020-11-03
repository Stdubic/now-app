<?php

namespace App\Http\Controllers\Api;


use App\Instance;
use App\Setting;
use App\AppClient;
use App\Claim;
use App\AppUserPayments;
use App\InstanceClient;
use App\Http\Requests\StripePayment;
use App\Http\Controllers\Controller;
use Carbon\Carbon;




/**
 * Class ProfileController
 * @package App\Http\Controllers\Api
 */
class StripeController extends Controller
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
     * @param StripePayment $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function payment(StripePayment $request)
    {

        $user = getUser();
        $settings = Setting::find(1);

        $instance_client = InstanceClient::where('instance_id', $request->instance_id)->first();
        $user_id = $instance_client->user_id;

        $app_client = AppClient::find($user_id);
        $destination_account = $app_client->stripe_account;



        $instance = Instance::find($request->instance_id);

        $application_fee = ($settings->application_fee / 100) * $instance->price;

        $description = 'User:  ' . $user->first_name . '   paid:  '. $instance->name ;

        $now = Carbon::now();

        $quantity_left = $instance->getQuantityLeftAttribute();


        if($instance->time_end < $now)
        {
            return response()->json(['success'=> false, 'error' => 'expired']);
        }
        elseif($instance->instance_type_id == 2)
        {
            if($quantity_left > 0)
            {
                try
                {
                    $charge = \Stripe\Charge::create ( array (
                        "amount" => $instance->price,
                        "currency" => $settings->currency,
                        "source" => $request->token,
                        "application_fee" => $application_fee,
                        "destination" => array(
                            "account" => $destination_account,
                        ),
                        "description" => $description
                    ) );

                }
                catch ( \Exception $e  )
                {
                    return response()->json(['success'=> false,'error'=> $e->getMessage()]);

                }


                $token = str_random(32);

                Claim::create([

                    'user_id' => $user->id,
                    'redeemed' => 0,
                    'claim_token' => $token,
                    'claim_timestamp'=> $now,
                    'claim_until'=> Carbon::now()->addMinutes($instance->claim_duration),
                    'paid' => 1,
                    'instance_id' => $instance->id,

                ]);

                AppUserPayments::create([

                    'user_id' => $user->id,
                    'claim_id' => $request->instance_id,
                    'stripe_token' => $charge->id,
                    'price' => $instance->price,
                    'destination_account' => $destination_account,
                    'description' => $description,

                ]);

                return response()->json(['success'=> true]);

            }
            else
            {
                return response()->json(['success'=> false, 'error' => 'no quantity']);
            }

        }
        else
        {

            try
            {
                $charge = \Stripe\Charge::create ( array (
                    "amount" => $instance->price,
                    "currency" => $settings->currency,
                    "source" => $request->token,
                    "application_fee" => $application_fee,
                    "destination" => array(
                        "account" => $destination_account,
                    ),
                    "description" => $description
                ) );

            }
            catch ( \Exception $e  )
            {
                return response()->json(['success'=> false,'error'=> $e->getMessage()]);

            }


            $token = str_random(32);

            Claim::create([

                'user_id' => $user->id,
                'redeemed' => 0,
                'claim_token' => $token,
                'claim_timestamp'=> $now,
                'claim_until'=> Carbon::now()->addMinutes($instance->claim_duration),
                'paid' => 1,
                'instance_id' => $instance->id,

            ]);

            AppUserPayments::create([

                'user_id' => $user->id,
                'claim_id' => $request->instance_id,
                'stripe_token' => $charge->id,
                'price' => $instance->price,
                'destination_account' => $destination_account,
                'description' => $description,

            ]);

            return response()->json(['success'=> true]);

        }

    }



}
