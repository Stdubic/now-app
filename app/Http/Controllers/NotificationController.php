<?php

namespace App\Http\Controllers;

use App\Notification;
use App\Http\Requests\MultiValues;
use App\Http\Requests\StoreNotification;

class NotificationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $notifications = Notification::orderBy('created_at', 'desc')->get();

        return view('notifications.list', compact('notifications'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        return view('notifications.add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreNotification $request)
    {

        $notification = Notification::create([
            'title' => $request->title,
            'body' => $request->body
        ]);



        return redirect(route('notifications.list'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Notification  $notification
     * @return \Illuminate\Http\Response
     */
    public function show(Notification $notification)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Notification  $notification
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $notification = Notification::findOrFail($id);

        return view('notifications.add', compact('notification'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Notification  $notification
     * @return \Illuminate\Http\Response
     */
    public function update(StoreNotification $request, Notification $id)
    {
        $id->update([
            'title' => $request->title,
            'body' => $request->body
        ]);


        return redirect(route('notifications.list'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Notification  $notification
     * @return \Illuminate\Http\Response
     */
    public function destroy(Notification $id)
    {
        $id->delete();

        return redirect(route('notifications.list'));
    }

    public function multiRemove(MultiValues $request)
    {
        foreach($request->values as $id) Notification::find($id)->delete();

        return back();
    }

    public function fire(Notification $id)
    {
        $this->sendNotification($id);

        return redirect(route('notifications.list'));
    }

    public function multiFire(MultiValues $request)
    {
        foreach($request->values as $id)
        {
            $notification = Notification::find($id);
            if(!$notification) continue;

            $this->sendNotification($notification);
        }

        return back();
    }

    private function sendNotification($notification)
    {

        $onesignal = new OneSignalHandler;

        return $onesignal->addNotification([
            'headings' => [
                'en' => $notification->title
            ],
            'contents' => [
                'en' => $notification->body
            ],
            'include_player_ids' => $notification->devices()
        ]);

    }
}
