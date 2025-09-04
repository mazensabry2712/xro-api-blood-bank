<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CityResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->getTranslation('name', app()->getLocale()),

            // Governorate
            'governorate' => $this->whenLoaded('governorate', function () {
                return [
                    'id' => $this->governorate->id,
                    'name' => $this->governorate->getTranslation('name', app()->getLocale()),
                ];
            }),

            // Regions
            'regions' => $this->whenLoaded('regions', function () {
                return \App\Http\Resources\RegionResource::collection($this->regions);
            }),

            // كل المستشفيات في المدينة (اختياري، لو لودّيت hospitals)
            'hospitals' => $this->whenLoaded('hospitals', function () {
                return \App\Http\Resources\HospitalResource::collection($this->hospitals);
            }),

            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
