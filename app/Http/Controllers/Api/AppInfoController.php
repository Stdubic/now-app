<?php

namespace App\Http\Controllers\API;


use App\Http\Resources\TermResource;
use App\Term;
use App\Http\Controllers\Controller;


/**
 * Class AppInfoController
 * @package App\Http\Controllers\API
 */
class AppInfoController extends Controller
{
    /**
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index()
    {
        return TermResource::collection(Term::orderBy('created_at')->get());
    }

}
