<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;


/**
 * Class Claim
 * @package App
 */
class Claim extends Model
{
    /**
     * @var array
     */
    protected $fillable = [ 'user_id','instance_id','claim_timestamp','claim_until','redeemed','paid','claim_token'];


    /**
     * @var array
     */
    protected $appends = ['valid_claim'];


    /**
     * @return mixed
     */
    public function getValidClaimAttribute()
    {

        $now = Carbon::now();

        $claims = Claim::where('claim_timestamp', '<=', $now )->where('claim_until', '>=', $now )->where('id', $this->id )->count();

        return $claims;

    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function instance() {
        return $this->belongsTo(Instance::class, 'id');
    }
}
