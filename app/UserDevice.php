<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class UserDevice
 * @package App
 */
class UserDevice extends Model
{
    /**
     * @var array
     */
    protected $fillable = [
        'app_user_id', 'device_id',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(AppUser::class);
    }
}
