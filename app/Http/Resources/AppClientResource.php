<?php

namespace App\Http\Resources;

use App\Http\Controllers\JwtHandler;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Controllers\MediaStorage;

class AppClientResource extends JsonResource
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

        $tos = $storage->files('tos/'.$this->id.'/tos');
        $tos = empty($tos) ? null : $storage->url($storage->getThumb($tos[0]));


        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'address' => $this->address,
            'post_code' => $this->post_code,
            'contact_number' => $this->contact_number,
            'city' => $this->city,
            'category_id' => $this->category,
            'latitude' => (double)$this->latitude,
            'longitude' => (double)$this->longitude,
            'stars' => $this->stars,
            'tos' => $tos,
            'token' => $this->token(),
            'stripe_account' => $this->stripe_account,
            'user'=> 'client',

        ];
    }
}
