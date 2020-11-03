<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class RoleRoute
 * @package App
 */
class RoleRoute extends Model
{
    /**
     * @var array
     */
    protected $fillable = [
        'role_id', 'route',
	];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function role()
	{
		return $this->belongsTo(Role::class);
	}
}
