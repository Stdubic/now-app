<?php

namespace App\Http\Controllers\Api;


use App\Http\Resources\InstanceTypeResource;
use App\InstanceType;
use App\Http\Controllers\Controller;


/**
 * Class InstanceTypeController
 * @package App\Http\Controllers\Api
 */
class InstanceTypeController extends Controller
{
    /**
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index()
    {
        return InstanceTypeResource::collection(InstanceType::all());
    }

}
