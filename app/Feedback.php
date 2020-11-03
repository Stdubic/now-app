<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Feedback
 * @package App
 */
class Feedback extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['message','app_user_id','app_client_id'];
}
