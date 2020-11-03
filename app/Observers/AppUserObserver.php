<?php

namespace App\Observers;

use App\AppUser;


class AppUserObserver
{
    /**
     * Handle the customer "created" event.
     *
     * @param  \App\AppUser  $appUser
     * @return void
     */
    public function created(AppUser $appUser)
    {
       //
    }

    /**
     * Handle the customer "updated" event.
     *
     * @param  \App\AppUser  $appUser
     * @return void
     */
    public function updated(AppUser $appUser)
    {
        //
    }

    /**
     * Handle the customer "deleted" event.
     *
     * @param  \App\AppUser  $appUser
     * @return void
     */
    public function deleting(AppUser $appUser)
    {
        //

    }

    /**
     * Handle the customer "restored" event.
     *
     * @param  \App\AppUser  $appUser
     * @return void
     */
    public function restored(AppUser $appUser)
    {
        //
    }

    /**
     * Handle the customer "force deleted" event.
     *
     * @param  \App\AppUser  $appUser
     * @return void
     */
    public function forceDeleted(AppUser $appUser)
    {
        //
    }
}