<?php

namespace Zahzah\ModuleWarehouse\Resources\Building;

use Zahzah\LaravelSupport\Resources\ApiResource;

class ViewBuilding extends ApiResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray(\Illuminate\Http\Request $request): array{
      $arr = [
        'id'         => $this->id,
        'name'       => $this->name,
        'created_at' => $this->created_at,
        'updated_at' => $this->updated_at
      ];
      
      return $arr;
    }
}
