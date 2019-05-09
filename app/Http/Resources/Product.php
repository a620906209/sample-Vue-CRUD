<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Product extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        // return parent::toArray($request);
        return [
            'id' => $this->id,
            'product_name' => $this->product_name,
            'product_type' => $this->product_type,
            'product_price' => $this->product_price,
        ];
    }
    // public function with($request)
    // {
    //     return [
    //         'version' => '1.0.1',
    //         'auth_url' => url('http://www.google.com')
    //     ];
    // }
}
