<?php

namespace App\Http\Resources;

use App\Http\Controllers\JwtHandler;
use Illuminate\Http\Resources\Json\JsonResource;

class AppUserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {

        return [
            'id' => $this->id,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'email' => $this->email,
            'contact_number' => $this->contact_number,
            'token' => $this->token(),
            'user'=> 'app-user',
            'favorite_category_ids' => $this->favorite_category_ids,
            'facebook_id' => $this->facebook_id,
            'google_id' => $this->google_id,

        ];
    }
}
