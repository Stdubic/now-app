<?php

namespace App\Http\Controllers;


use App\Term;
use App\Http\Requests\StoreTerms;


/**
 * Class TosController
 * @package App\Http\Controllers
 */
class TosController extends Controller
{

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit()
    {
        $settings = Term::firstOrFail();

        return view('tos.add', compact('settings'));
    }


    /**
     * @param StoreTerms $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(StoreTerms $request)
    {
        $status = Term::firstOrFail()->update([
            'title' => $request->title,
            'tos' => $request->tos,
            'privacy_policy' => $request->privacy_policy,
        ]);

        return redirect(route('tos.edit'));
    }


}
