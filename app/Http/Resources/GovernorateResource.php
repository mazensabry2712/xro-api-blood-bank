<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class GovernorateResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->getTranslation('name', app()->getLocale()),
            'code' => $this->code,

            'cities' => $this->whenLoaded('cities', function () {
                return \App\Http\Resources\CityResource::collection($this->cities);
            }),

            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
