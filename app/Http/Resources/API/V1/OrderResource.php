<?php

namespace App\Http\Resources\API\V1;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'currency_from' => strtoupper($this->currencyFrom->symbol),
            'currency_to' => strtoupper($this->currencyTo->symbol),
            'value' => $this->value,
            'converted_value' => $this->converted_value,
            'rate' => $this->rate,
            'created_at' => $this->created_at,
        ];
    }
}
