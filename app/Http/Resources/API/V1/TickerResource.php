<?php

namespace App\Http\Resources\API\V1;

use Illuminate\Http\Resources\Json\JsonResource;

class TickerResource extends JsonResource
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
            'rate' => $this->formatted_rate,
        ];
    }
}
