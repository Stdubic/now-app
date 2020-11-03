<?php

namespace App\Observers;

use App\AppClient;
use App\Http\Controllers\MediaStorage;


class AppClientObserver
{
    /**
     * Handle the customer "created" event.
     *
     * @param  \App\AppClient  $appClient
     * @return void
     */
    public function created(AppClient $appClient)
    {
        //
    }

    /**
     * Handle the customer "updated" event.
     *
     * @param  \App\AppClient  $appClient
     * @return void
     */
    public function updated(AppClient $appClient)
    {
        //
    }

    /**
     * Handle the customer "deleted" event.
     *
     * @param  \App\AppClient  $appClient
     * @return void
     */
    public function deleting(AppClient $appClient)
    {

        $appClient->instances->each(function ($item) {
            $item->delete();
        });

        $storage = new MediaStorage;
        $storage->deleteDir('tos/'.$appClient->id);


    }

    /**
     * Handle the customer "restored" event.
     *
     * @param  \App\AppClient  $appClient
     * @return void
     */
    public function restored(AppClient $appClient)
    {
        //
    }

    /**
     * Handle the customer "force deleted" event.
     *
     * @param  \App\AppClient  $appClient
     * @return void
     */
    public function forceDeleted(AppClient $appClient)
    {
        //
    }
}