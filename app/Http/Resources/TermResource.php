<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Setting;


class TermResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $settings = Setting::find(1);

        return [
            'id' => $this->id,
            'title' => $this->title,
            'tos' => $this->tos,
            'privacy_policy' => $this->privacy_policy,
            'stripe_publishable_key' => $settings->stripe_publishable_key,
            'stripe_client_id' => $settings->stripe_client_id,
        ];
    }
}
