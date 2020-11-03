<?php

namespace App\Http\Controllers\Api;


use App\Instance;
use App\Claim;
use Carbon\Carbon;
use App\Http\Resources\InstanceResource;
use App\Http\Resources\ClaimResource;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\StoreInstance;
use App\Http\Requests\EditInstance;
use App\Http\Requests\RadiusRequest;
use App\Http\Requests\ActivateInstance;
use App\Http\Controllers\MediaStorage;


/**
 * Class InstanceController
 * @package App\Http\Controllers\Api
 */
class InstanceController extends Controller
{
    /**
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index()
    {
        return InstanceResource::collection(Instance::with('type','category','claims')->get());
    }

    /**
     * @param RadiusRequest $request
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function radius(RadiusRequest $request)
    {

        $request_date = Carbon::parse($request->date);

        $request_date_start = Carbon::parse($request->date);
        $request_date_end = new Carbon($request_date->addDay(1));
        $request_date_start = $request_date_start->toDateTimeString();
        $request_date_end = $request_date_end->toDateTimeString();



        return InstanceResource::collection( Instance::with('type','category','claims')


            ->where
            (function ($query) use ($request) {
                return $query

                    ->whereRaw(" (ST_Distance_Sphere(point, POINT($request->lat, $request->long)) < $request->radius)");


            })

            ->where
            (function ($query) use ($request_date_start, $request_date_end) {
                return $query

                    ->where([['time_start', '>=', $request_date_start],['time_start', '<=', $request_date_end ]])
                    ->orWhere([['time_end', '>=', $request_date_start],['time_end', '<=', $request_date_end ]])
                    ->orWhere([['time_start', '<=', $request_date_start],['time_end', '>=', $request_date_end ]]);


            })

            ->where
            (function ($query) {
                return $query

                    ->where('active', '=',1 );

            })
            ->get());


    }


    /**
     * @param $id
     * @return InstanceResource
     */
    public function show($id)
    {

        $instance = Instance::with('type','category','claims')->findOrFail($id);
        return new InstanceResource($instance);

    }

    /**
     * @param StoreInstance $request
     * @return InstanceResource|\Illuminate\Http\JsonResponse
     */
    public function create(StoreInstance $request)
    {


        if ( $request->is_now == 1 )
        {
            $now = Carbon::now();

            if( $request->time_end < $now )
            {
                return response()->json(['success'=> false]);
            }
            else
            {

                $instance = Instance::create(
                    [
                        'name' => $request->name,
                        'city' => $request->city,
                        'address' => $request->address,
                        'postcode' => $request->postcode,
                        'instance_type_id' => $request->instance_type_id,
                        'instance_category_id' => $request->instance_category_id,
                        'description' => $request->description,
                        'time_start' => $now,
                        'time_end' => $request->time_end,
                        'latitude' => $request->latitude,
                        'longitude' => $request->longitude,
                        'price' => $request->price,
                        'discount' => $request->discount,
                        'quantity' => $request->quantity,
                        'claim_duration' => $request->claim_duration,
                        'is_charity' => $request->is_charity,
                        'charity_link' => $request->charity_link,
                        'point' => DB::raw("ST_GeomFromText('POINT($request->latitude $request->longitude)')"),
                        'active' => $request->active,
                        'is_buy_now' => $request->is_buy_now,
                        'is_now' => true
                    ]
                );
                $instance = Instance::with('type','category','claims')->findOrFail($instance->id);
                $user = getUser();
                $user->instances()->attach($instance->id);

                return new InstanceResource($instance);
            }

        }
        else
        {
            $now = Carbon::now();

            if ($request->time_start < $now || $request->time_end < $now || $request->time_start > $request->time_end)
            {
                return response()->json(['success'=> false]);
            }
            else
            {
                $instance = Instance::create(
                    [
                        'name' => $request->name,
                        'city' => $request->city,
                        'address' => $request->address,
                        'postcode' => $request->postcode,
                        'instance_type_id' => $request->instance_type_id,
                        'instance_category_id' => $request->instance_category_id,
                        'description' => $request->description,
                        'time_start' => $request->time_start,
                        'time_end' => $request->time_end,
                        'latitude' => $request->latitude,
                        'longitude' => $request->longitude,
                        'price' => $request->price,
                        'discount' => $request->discount,
                        'quantity' => $request->quantity,
                        'claim_duration' => $request->claim_duration,
                        'is_charity' => $request->is_charity,
                        'charity_link' => $request->charity_link,
                        'point' => DB::raw("ST_GeomFromText('POINT($request->latitude $request->longitude)')"),
                        'active' => $request->active,
                        'is_buy_now' => $request->is_buy_now,
                        'is_now' => false
                    ]
                );
                $instance = Instance::with('type','category','claims')->findOrFail($instance->id);
                $user = getUser();
                $user->instances()->attach($instance->id);

                return new InstanceResource($instance);
            }



        }


    }

    /**
     * @param EditInstance $request
     * @param $id
     * @return InstanceResource|\Illuminate\Http\JsonResponse
     */
    public function edit(EditInstance $request, $id)
    {



        if ( $request->is_now == 1 )
        {
            $now = Carbon::now();

            if( $request->time_end < $now )
            {
                return response()->json(['success'=> false]);
            }
            else
            {


                if ($request->image)
                {
                    $storage = new MediaStorage;
                    $storage->deleteDir('images/'.$id);

                    $instance = Instance::find($id);


                    $instance->name = $request->name;
                    $instance->address = $request->address;
                    $instance->postcode = $request->postcode;
                    $instance->instance_type_id = $request->instance_type_id;
                    $instance->instance_category_id = $request->instance_category_id;
                    $instance->description = $request->description;
                    $instance->time_start = $request->time_start;
                    $instance->time_end = $request->time_end;
                    $instance->latitude = $request->latitude;
                    $instance->longitude = $request->longitude;
                    $instance->price = $request->price;
                    $instance->discount = $request->discount;
                    $instance->quantity = $request->quantity;
                    $instance->claim_duration = $request->claim_duration;
                    $instance->is_charity = $request->is_charity;
                    $instance->charity_link = $request->charity_link;
                    $instance->point = DB::raw("ST_GeomFromText('POINT($request->latitude $request->longitude)')");
                    $instance->active  = $request->active;
                    $instance->is_buy_now  = $request->is_buy_now;


                    $instance->save();


                    $instance = Instance::with('type','category','claims')->findOrFail($instance->id);

                    return new InstanceResource($instance);


                }
                else
                {


                    $instance = Instance::find($id);


                    $instance->name = $request->name;
                    $instance->address = $request->address;
                    $instance->postcode = $request->postcode;
                    $instance->instance_type_id = $request->instance_type_id;
                    $instance->instance_category_id = $request->instance_category_id;
                    $instance->description = $request->description;
                    $instance->time_start = $request->time_start;
                    $instance->time_end = $request->time_end;
                    $instance->latitude = $request->latitude;
                    $instance->longitude = $request->longitude;
                    $instance->price = $request->price;
                    $instance->discount = $request->discount;
                    $instance->quantity = $request->quantity;
                    $instance->claim_duration = $request->claim_duration;
                    $instance->is_charity = $request->is_charity;
                    $instance->charity_link = $request->charity_link;
                    $instance->point = DB::raw("ST_GeomFromText('POINT($request->latitude $request->longitude)')");
                    $instance->active  = $request->active;
                    $instance->is_buy_now  = $request->is_buy_now;


                    $instance->save();


                    $instance = Instance::with('type','category','claims')->findOrFail($instance->id);

                    return new InstanceResource($instance);
                }

            }

        }
        else
        {


            $now = Carbon::now();

            if ($request->time_start < $now || $request->time_end < $now || $request->time_start > $request->time_end)
            {

                return response()->json(['success'=> false]);

            }
            else
            {


                if ($request->image)
                {
                    $storage = new MediaStorage;
                    $storage->deleteDir('images/'.$id);

                    $instance = Instance::find($id);


                    $instance->name = $request->name;
                    $instance->address = $request->address;
                    $instance->postcode = $request->postcode;
                    $instance->instance_type_id = $request->instance_type_id;
                    $instance->instance_category_id = $request->instance_category_id;
                    $instance->description = $request->description;
                    $instance->time_start = $request->time_start;
                    $instance->time_end = $request->time_end;
                    $instance->latitude = $request->latitude;
                    $instance->longitude = $request->longitude;
                    $instance->price = $request->price;
                    $instance->discount = $request->discount;
                    $instance->quantity = $request->quantity;
                    $instance->claim_duration = $request->claim_duration;
                    $instance->is_charity = $request->is_charity;
                    $instance->charity_link = $request->charity_link;
                    $instance->point = DB::raw("ST_GeomFromText('POINT($request->latitude $request->longitude)')");
                    $instance->active  = $request->active;
                    $instance->is_buy_now  = $request->is_buy_now;


                    $instance->save();


                    $instance = Instance::with('type','category','claims')->findOrFail($instance->id);

                    return new InstanceResource($instance);

                }
                else
                {

                    $instance = Instance::find($id);


                    $instance->name = $request->name;
                    $instance->address = $request->address;
                    $instance->postcode = $request->postcode;
                    $instance->instance_type_id = $request->instance_type_id;
                    $instance->instance_category_id = $request->instance_category_id;
                    $instance->description = $request->description;
                    $instance->time_start = $request->time_start;
                    $instance->time_end = $request->time_end;
                    $instance->latitude = $request->latitude;
                    $instance->longitude = $request->longitude;
                    $instance->price = $request->price;
                    $instance->discount = $request->discount;
                    $instance->quantity = $request->quantity;
                    $instance->claim_duration = $request->claim_duration;
                    $instance->is_charity = $request->is_charity;
                    $instance->charity_link = $request->charity_link;
                    $instance->point = DB::raw("ST_GeomFromText('POINT($request->latitude $request->longitude)')");
                    $instance->active  = $request->active;
                    $instance->is_buy_now  = $request->is_buy_now;


                    $instance->save();


                    $instance = Instance::with('type','category','claims')->findOrFail($instance->id);

                    return new InstanceResource($instance);
                }

            }


        }

    }


    /**
     * @param ActivateInstance $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function active(ActivateInstance $request, $id)
    {

       Instance::findOrFail($id)->update(['active' => $request->active]);

       return response()->json(['success'=> true]);

    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete($id)
    {

        Instance::findOrFail($id)->delete();

        return response()->json(['success'=> true]);

    }

    /**
     * @param $instance_id
     * @return ClaimResource|\Illuminate\Http\JsonResponse
     */
    public function createClaim($instance_id)
    {

        $user = getUser();

        $token = str_random(32);

        $now = Carbon::now();

        $instance = Instance::find($instance_id);

        $quantity_left = $instance->getQuantityLeftAttribute();


        if($instance->time_end < $now)
        {
            return response()->json(['success'=> false, 'error' => 'expired']);
        }
        elseif($instance->instance_type_id == 2)
        {
            if($quantity_left > 0)
            {
                $claim = Claim::create( [
                    'user_id' => $user->id,
                    'claim_timestamp'=> $now,
                    'claim_until'=> Carbon::now()->addMinutes($instance->claim_duration),
                    'redeemed' => 0,
                    'claim_token' => $token,
                    'paid' => 0,
                    'instance_id' => $instance_id,

                ] );

                return new ClaimResource($claim);

            }
            else
            {
                return response()->json(['success'=> false, 'error' => 'no quantity']);
            }

        }
        else
        {

            $claim = Claim::create( [
                'user_id' => $user->id,
                'claim_timestamp'=> $now,
                'claim_until'=> Carbon::now()->addMinutes($instance->claim_duration),
                'redeemed' => 0,
                'claim_token' => $token,
                'paid' => 0,
                'instance_id' => $instance_id,

            ] );


            return new ClaimResource($claim);

        }

    }

    /**
     * @param $instance_id
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function instanceClaim($instance_id)
    {


        return ClaimResource::collection(Claim::with('instance')->where('instance_id',$instance_id)->get());


    }

    /**
     * @param $id
     * @return InstanceResource
     */
    public function complete($id)
    {
        $now = Carbon::now()->toDateTimeString();

        $instance = Instance::find($id);
        $instance->time_end = $now;
        $instance->save();

        return new InstanceResource($instance);

    }

}
