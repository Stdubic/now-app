<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Controllers\MediaStorage;

class CategoryResource extends JsonResource
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

        $image = $storage->files('category/'.$this->id.'/image');
        $image = empty($image) ? null : $storage->url($storage->getThumb($image[0]));

        return [
            'id' => $this->id,
            'name' => $this->name,
            'image'=> $image
        ];
    }
}
