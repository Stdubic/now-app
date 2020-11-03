<?php

namespace App\Http\Controllers;


use App\Term;


/**
 * Class AppInfoController
 * @package App\Http\Controllers
 */
class AppInfoController extends Controller
{

    public function index()
    {
        $terms =  Term::first()->pluck('privacy_policy');

        return view('mobile.privacy-policy', compact('terms'));
    }

}
