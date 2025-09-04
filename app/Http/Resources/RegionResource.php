<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class RegionResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,

            // مترجمين
            'name' => $this->getTranslation('name', app()->getLocale()),
            'address' => $this->getTranslation('address', app()->getLocale()),

            // المدينة
            'city' => $this->whenLoaded('city', function () {
                return [
                    'id' => $this->city->id,
                    'name' => $this->city->getTranslation('name', app()->getLocale()),
                ];
            }),

            // المستشفيات المرتبطة (اختياري)
            'hospitals' => HospitalResource::collection($this->whenLoaded('hospitals')),

            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
