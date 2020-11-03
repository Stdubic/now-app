<?php

namespace App\Http\Controllers;

use App\Category;
use App\Http\Requests\StoreCategory;
use App\Http\Requests\MultiValues;

/**
 * Class CategoryController
 * @package App\Http\Controllers
 */
class CategoryController extends Controller
{

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $categories = Category::orderBy('created_at')->get();

        return view('categories.list', compact('categories'));
    }


    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        return view('categories.add');
    }


    /**
     * @param StoreCategory $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(StoreCategory $request)
    {
        $category = Category::create([
            'name' => $request->name
        ]);

        $media_save = [
            'image' => 'category/'.$category->id.'/image'
        ];


        $storage = new MediaStorage;
        $storage->handle( $request->media, $media_save);

        return redirect(route('categories.list'));
    }


    /**
     * @param Category $document
     */
    public function show(Category $document)
    {
        //
    }


    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id)
    {
        $category = Category::findOrFail($id);

        return view('categories.add', compact('category'));
    }


    /**
     * @param StoreCategory $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(StoreCategory $request, $id)
    {
        Category::findOrFail($id)->update([
            'name' => $request->name
        ]);

        $storage = new MediaStorage;
        $storage->handle($request->media, ['image' => 'category/'.$id.'/image']);

        return redirect(route('categories.list'));
    }


    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function destroy($id)
    {
        Category::findOrFail($id)->delete();

        return $this->index();
    }

    /**
     * @param MultiValues $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function multiRemove(MultiValues $request)
    {
        $values = $request->values;

        foreach($values as $id) Category::find($id)->delete();

        return back();
    }

}
