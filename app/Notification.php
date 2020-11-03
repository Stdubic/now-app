<?php

namespace App;

use App\Observers\NotificationObserver;
use Illuminate\Database\Eloquent\Model;


/**
 * Class Notification
 * @package App
 */
class Notification extends Model
{
    /**
     * @var array
     */
    protected $fillable = [
        'title', 'body',
    ];


    /**
     * @return array
     */
    public function devices()
    {
        return UserDevice::all()->pluck('device_id')->toArray();
    }

    /**
     *
     */
    protected static function boot()
    {
        parent::boot();

        self::observe(NotificationObserver::class);
    }
}
