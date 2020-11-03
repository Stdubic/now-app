<?php

namespace App;

use Illuminate\Support\Facades\Route;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * Class User
 * @package App
 */
class User extends Authenticatable
{
	use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'role_id', 'timezone'. 'active',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
	];

    /**
     * @return string
     */
    public function profile()
	{
		return route('users.edit', $this->id);
	}

    /**
     * @return bool
     */
    public function isAppClient()
    {
        return false;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function role()
	{
		return $this->belongsTo(Role::class);
	}

    /**
     * @param $curr_route
     * @param string $method
     * @param null $mode
     * @return bool
     */
    public function canViewRoute($curr_route, $method = 'GET', $mode = null)
	{
		$status = false;
		if(!$mode) $mode = $this->role->mode;
		$routes = $this->role->routes;
		$all_routes = Route::getRoutes();
		$curr_route = parse_url($curr_route, PHP_URL_PATH);

		foreach($routes as $route)
		{
			$route = $all_routes->getByName($route->route);
			if(!$route || !in_array($method, $route->methods())) continue;

			$route = preg_replace('%\{.+?\}%', '?.*', $route->uri());
			$status = preg_match('%'.$route.'$%', $curr_route);

			if($status) break;
		}

		return ($status && $mode == Role::LIST_MODE_WHITE) || (!$status && $mode == Role::LIST_MODE_BLACK);
	}
}
