<?php

namespace App\Observers;

use App\Claim;

class ClaimObserver
{
    /**
     * Handle the Claim "created" event.
     *
     * @param  \App\Claim  $claim
     * @return void-
     */
    public function created(Claim $claim)
    {
        //
    }

    /**
     * Handle the Claim "updated" event.
     *
     * @param  \App\Claim  $claim
     * @return void
     */
    public function updated(Claim $claim)
    {
        //
    }

    /**
     * Handle the Claim "deleted" event.
     *
     * @param  \App\Claim  $claim
     * @return void
     */
    public function deleting(Claim $claim)
    {
      //

    }

    /**
     * Handle the Claim "restored" event.
     *
     * @param  \App\Claim  $claim
     * @return void
     */
    public function restored(Claim $claim)
    {
        //
    }

    /**
     * Handle the Claim "force deleted" event.
     *
     * @param  \App\Claim  $instance
     * @return void
     */
    public function forceDeleted(Claim $claim)
    {
        //
    }
}
