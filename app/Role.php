<?php

namespace App;

use App\Observers\RoleObserver;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Role
 * @package App
 */
class Role extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

	public const LIST_MODE_WHITE = 1;
    /**
     *
     */
    public const LIST_MODE_BLACK = 2;

    /**
     * @var array
     */
    protected $fillable = [
        'name', 'view_all', 'mode',
	];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function users()
	{
		return $this->hasMany(User::class);
	}

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function routes()
	{
		return $this->hasMany(RoleRoute::class);
	}

    /**
     *
     */
    protected static function boot()
	{
		parent::boot();

		self::observe(RoleObserver::class);
	}
}
