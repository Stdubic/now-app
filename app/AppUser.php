<?php

namespace App;

use App\Observers\AppUserObserver;
use Illuminate\Support\Facades\Route;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * Class AppUser
 * @package App
 */
class AppUser extends Authenticatable implements JWTSubject
{
    use Notifiable;

    /**
     *
     */
    const IS_CLIENT = false;
    /**
     * @var string
     */
    protected $guard = 'app_user-api';
    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'favorite_category_ids' => 'array',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name', 'last_name', 'contact_number','email', 'password', 'role_id', 'timezone'. 'active','favorite_category_ids', 'category','facebook_id','google_id'
    ];

    /**
     *
     */
    public function token()
    {
        return auth('api')->login($this);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function claims()
    {
        return $this->belongsToMany(Claim::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function categories()
    {
        return $this->belongsToMany(CategoryUser::class, 'instance_categories_per_users', 'user_id', 'instance_category_id');
    }

    /**
     * @return bool
     */
    public function isAppClient()
    {
        return false;
    }

    /**
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];


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

    /**
     *
     */
    protected static function boot()
    {
        parent::boot();

        self::observe(AppUserObserver::class);
    }
}
