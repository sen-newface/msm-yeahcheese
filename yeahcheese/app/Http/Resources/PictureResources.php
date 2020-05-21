<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PictureResources extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return[
            'event_id' => $this->event_id,
            'path' => $this->path
        ];
    }
}
