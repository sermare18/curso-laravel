<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

// Nos permite devolver colecciones de datos en formatos json
// Utilizado en routes/api.php
class ContactResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return parent::toArray($request);
    }
}
