<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AppClientStars extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['stars', 'app_client_id', 'app_user_id','instance_id'];


}
