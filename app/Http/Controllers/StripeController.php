<?php

namespace App\Http\Controllers;

use App\AppClient;

class StripeController extends Controller
{

    public function __construct()
    {
        \Stripe\Stripe::setApiKey(setting('stripe_rest_api_key'));
        \Stripe\Stripe::setClientId(setting('stripe_client_id'));
    }


    public function oauth()
    {

        if (isset($_GET['code']))
        {

            $code = $_GET['code'];
            $state = $_GET['state'];

            $state = base64_decode( $state );
            $state = json_decode( $state );

            try
            {
                $resp = \Stripe\OAuth::token([
                    'grant_type' => 'authorization_code',
                    'code' => $code,
                ]);
            }
            catch (\Stripe\Error\OAuth\OAuthBase $e)
            {
                $success = false;
                $error_description = $e->getMessage();

                return view('oauth', compact( 'error_description', 'success'));
            }


            $accountId = $resp->stripe_user_id;


            $client = AppClient::find( $state->client_id );
            $client->stripe_account = $accountId;

            $client->save();

            $success = true;
            $error_description = false;

            return view('oauth', compact('success', 'error_description'));


        }
        elseif (isset($_GET['error']))
        {

            $success = false;
            $error_description = $_GET['error_description'];

            return view('oauth', compact( 'error_description', 'success'));

        }
        else
        {

            echo "Something went wrong try again";

        }

    }
//
//    public function oauth()
//    {
//
//        if (isset($_GET['code']))
//        {
//
//            $code = $_GET['code'];
//            $state = $_GET['state'];
//
//            $state = base64_decode( $state );
//            $state = json_decode( $state );
//
//            try
//            {
//                $resp = \Stripe\OAuth::token([
//                    'grant_type' => 'authorization_code',
//                    'code' => $code,
//                ]);
//            }
//            catch (\Stripe\Error\OAuth\OAuthBase $e)
//            {
//                exit("Error: " . $e->getMessage());
//            }
//
//
//            $accountId = $resp->stripe_user_id;
//            $account = \Stripe\Account::retrieve($accountId);
//
//
//            $client = AppClient::find( $state->client_id );
//            $client->stripe_account = $accountId;
//
//            $client->save();
//
//            echo "<p>Success! Account <code>$accountId</code> with email:<code>$account->email</code>  is connected.</p>\n";
//
//        }
//        elseif (isset($_GET['error']))
//        {
//
//            $error = $_GET['error'];
//            $error_description = $_GET['error_description'];
//            echo "<p>Error: code=" . htmlspecialchars($error, ENT_QUOTES) . ", description=" . htmlspecialchars($error_description, ENT_QUOTES) . "</p>\n";
//
//        }
//        else
//        {
//            $url = \Stripe\OAuth::authorizeUrl([
//                'scope' => 'read_only',
//            ]);
//            echo "<a href=\"$url\">Connect with Stripe</a>\n";
//        }
//
//    }

}
