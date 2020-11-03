<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class AppUserPayments
 * @package App
 */
class AppUserPayments extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'claim_id', 'stripe_token','price', 'destination_account', 'description'
    ];
}
