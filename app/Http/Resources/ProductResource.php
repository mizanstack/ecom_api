<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return 
        [

            'id'          => $this->id,
            'name'        => $this->name,
            'slug'        => str_replace(' ', '-',$this->name),
            'qty'         => $this->qty,
            'image'       => url('images/product/').'/'.$this->image,
            'description' => $this->description,
        ];
    }
}
