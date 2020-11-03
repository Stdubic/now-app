<?php

namespace App\Http\Resources;

use App\Instance;
use App\AppUser;
use Illuminate\Http\Resources\Json\JsonResource;

class ClaimResource extends JsonResource
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
            'user' => new AppUserResource(AppUser::where('id',$this->user_id)->first()),
            'instance_id' => $this->instance_id,
            'instance' => new InstanceResource(Instance::where('id', $this->instance_id)->first()),
            'redeemed' => boolval($this->redeemed),
            'paid' => boolval($this->paid),
            'claim_token' => $this->claim_token,
            'valid_claim' => $this->valid_claim,
            'created_at' => formatTimestamp($this->created_at),
            'updated_at' => formatTimestamp($this->updated_at),

        ];
    }
}
