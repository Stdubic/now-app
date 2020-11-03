<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Observers\InstanceObserver;
use Carbon\Carbon;


/**
 * Class Instance
 * @package App
 */
class Instance extends Model
{
    /**
     * @var array
     */
    protected $fillable = [
        'name','location','instance_category_id','instance_type_id','description','time_start','time_end','latitude','longitude','price','discount','quantity','city','active','point','address','postcode','is_charity','charity_link', 'is_now','claim_duration','is_buy_now'];

    /**
     * @var array
     */
    protected $appends = ['quantity_left','client_id','client_name','user_claims','user_feedback','valid_claims'];

    /**
     * @return mixed
     */
    public function getQuantityLeftAttribute()
    {
        $now = Carbon::now();

        $claims = Claim::where('claim_timestamp', '<=', $now )->where('claim_until', '>=', $now )->where('instance_id', $this->id)->count();

        return $this->quantity - $claims;
    }

    /**
     * @return mixed
     */
    public function getClientIdAttribute()
    {
        $instance_client = InstanceClient::where('instance_id', $this->id)->first();

        return $instance_client->user_id;

    }

    /**
     * @return mixed
     */
    public function getClientNameAttribute()
    {
        $instance_client = InstanceClient::where('instance_id', $this->id)->first();

        $client = AppClient::find($instance_client->user_id);

        return $client->name;

    }

    /**
     * @return bool
     */
    public function getUserClaimsAttribute()
    {
        $user = getUser();
        $instance_client = Claim::where('user_id', $user->id)->where('instance_id',$this->id)->first();


        if($instance_client)
        {
            return true;
        }
        else
        {
            return false;
        }

    }


    /**
     * @return mixed
     */
    public function getValidClaimsAttribute()
    {

        $now = Carbon::now();

        $claims = Claim::where('claim_timestamp', '<=', $now )->where('claim_until', '>=', $now )->where('instance_id',$this->id)->count();

        return $claims;

    }

    /**
     * @return bool
     */
    public function getUserFeedbackAttribute()
    {

        $user = getUser();
        $instance_client = AppClientStars::where('app_user_id', $user->id)->where('instance_id',$this->id)->first();


        if($instance_client)
        {
            return true;
        }
        else
        {
            return false;
        }


    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category()
    {
        return $this->belongsTo(Category::class,'instance_category_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function type()
    {
        return $this->belongsTo(InstanceType::class ,'instance_type_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function claims()
    {
        return $this->hasMany(Claim::class);
    }

    /**
     *
     */
    protected static function boot()
    {
        parent::boot();

        self::observe(InstanceObserver::class);
    }

}
