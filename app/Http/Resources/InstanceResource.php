<?php

namespace App\Http\Resources;

use App\AppClient;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Controllers\MediaStorage;


class InstanceResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $storage = new MediaStorage;

        $image = $storage->files('images/'.$this->id.'/image');
        $image = empty($image) ? null : $storage->url($storage->getThumb($image[0]));


        return [

            'id' => $this->id,
            'name' => $this->name,
            'image' => $image,
            'city' => $this->city,
            'address' => $this->address,
            'postcode' => $this->postcode,
            'instance_type_id' => $this->instance_type_id,
            'instance_category_id' => $this->instance_category_id,
            'description' => $this->description,
            'time_start' => $this->time_start,
            'time_end' => $this->time_end,
            'latitude' => $this->latitude,
            'longitude' => $this->longitude,
            'price' => $this->price,
            'discount' => $this->discount,
            'quantity' => $this->quantity,
            'quantity_left' => $this->quantity_left,
            'claim_duration' => $this->claim_duration,
            'user_claims' => $this->user_claims,
            'user_left_feedback' => $this->user_feedback,
            'valid_claims' => $this->valid_claims,
            'active' => $this->active,
            'is_charity' => $this->is_charity,
            'charity_link' => $this->charity_link,
            'is_now' => $this->is_now,
            'is_buy_now' => $this->is_buy_now,
            'client' => new AppClientResource(AppClient::where('id',$this->client_id)->first()),

        ];
    }
}