<?php

namespace App\Http\Controllers\Api;


use App\Http\Resources\CategoryResource;
use App\Category;
use App\Http\Controllers\Controller;


/**
 * Class CategoryController
 * @package App\Http\Controllers\Api
 */
class CategoryController extends Controller
{
    /**
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index()
    {
        return CategoryResource::collection(Category::all());
    }

}
