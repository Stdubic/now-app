<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreFeedback;
use App\Feedback;
use App\Http\Requests\MultiValues;

/**
 * Class FeedbackController
 * @package App\Http\Controllers
 */
class FeedbackController extends Controller
{

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $feedback = Feedback::orderBy('created_at')->get();

        return view('feedback.list', compact('feedback'));
    }


    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        return view('feedback.add');
    }


    /**
     * @param StoreFeedback $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(StoreFeedback $request)
    {
        Feedback::create([
            'message' => $request->message,
        ]);

        return redirect(route('feedback.list'));
    }


    /**
     * @param Feedback $feedback
     */
    public function show(Feedback $feedback)
    {
        //
    }


    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id)
    {
        $feedback= Feedback::findOrFail($id);

        return view('feedback.add', compact('feedback'));
    }


    /**
     * @param StoreFeedback $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(StoreFeedback $request, $id)
    {
        Feedback::findOrFail($id)->update([
            'message' => $request->message,
        ]);

        return redirect(route('feedback.list'));
    }


    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function destroy($id)
    {
        Feedback::findOrFail($id)->delete();

        return $this->index();
    }

    /**
     * @param MultiValues $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function multiRemove(MultiValues $request)
    {
        $values = $request->values;

        foreach($values as $id) Feedback::find($id)->delete();

        return back();
    }

}
