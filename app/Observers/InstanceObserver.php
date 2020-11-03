<?php

namespace App\Observers;

use App\Instance;
use App\Http\Controllers\MediaStorage;

class InstanceObserver
{
    /**
     * Handle the Instance "created" event.
     *
     * @param  \App\Instance  $instance
     * @return void
     */
    public function created(Instance $instance)
    {
        $storage = new MediaStorage;
        $storage->deleteDir('images/'.$instance->id);
        $storage->handle(['image' => request()->image], ['image' => 'images/'.$instance->id.'/image']);
    }

    /**
     * Handle the Instance "updated" event.
     *
     * @param  \App\Instance  $instance
     * @return void
     */
    public function updated(Instance $instance)
    {
        $storage = new MediaStorage;
        $storage->handle(['image' => request()->image], ['image' => 'images/'.$instance->id.'/image']);
    }

    /**
     * Handle the Instance "deleted" event.
     *
     * @param  \App\Instance  $instance
     * @return void
     */
    public function deleting(Instance $instance)
    {

        $instance->claims->each(function ($item) {
            $item->delete();
        });


        $storage = new MediaStorage;
        $storage->deleteDir('images/'.$instance->id);

    }

    /**
     * Handle the Instance "restored" event.
     *
     * @param  \App\Instance  $instance
     * @return void
     */
    public function restored(Instance $instance)
    {
        //
    }

    /**
     * Handle the Instance "force deleted" event.
     *
     * @param  \App\Instance  $instance
     * @return void
     */
    public function forceDeleted(Instance $instance)
    {
        //
    }
}
