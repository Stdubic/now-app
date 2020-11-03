<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


/**
 * Class Category
 * @package App
 */
class Category extends Model
{
    /**
     * @var string
     */
    protected $table = 'instance_categories';
    /**
     * @var array
     */
    protected $fillable = ['name'];

    /**
     *
     */
    protected static function boot()
    {
        parent::boot();

        self::observe(InstanceCategoryObserver::class);
    }

}
