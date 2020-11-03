<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

/**
 * Class JwtHandler
 * @package App\Http\Controllers
 */
class JwtHandler extends Controller
{
    /**
     * @var null
     */
    private $guard = null;

    /**
     * JwtHandler constructor.
     * @param null $guard
     */
    public function __construct($guard = null)
	{
		$this->guard = $guard;
	}

    /**
     * @param null $request
     * @return mixed
     */
    public function getToken($request = null)
	{
		$user = $this->user();
		if($user) $user = $this->login($user);

		return $user ? $user : $this->attempt($request);
	}

    /**
     * @param null $guard
     * @return mixed
     */
    public function user($guard = null)
	{
		if(!$guard) $guard = $this->guard;
		return Auth::guard($guard)->user();
	}

    /**
     * @param $credentials
     * @param null $guard
     * @return mixed
     */
    private function attempt($credentials, $guard = null)
	{
		if(!$guard) $guard = $this->guard;
		return Auth::guard($guard)->attempt($credentials);
	}

    /**
     * @param $user
     * @param null $guard
     * @return mixed
     */
    private function login($user, $guard = null)
	{
		if(!$guard) $guard = $this->guard;
		return Auth::guard($guard)->login($user);
	}
}
