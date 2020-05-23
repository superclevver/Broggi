<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;


class RegisterResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return parent::toArray($request);
        //Devuelve toda la informacion del hotel

        /*return [
            "id_ciudad"=>$this->id_ciudad,
            "nombre"=>$this->nombre,
            "hoteles"=>HotelResource::collection($this->hoteles)
        ];*/
    }
}
