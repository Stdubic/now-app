<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Term
 * @package App
 */
class Term extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['tos','privacy_policy', 'title'];

}
