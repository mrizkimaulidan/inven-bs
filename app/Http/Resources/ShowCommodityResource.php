<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ShowCommodityResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'school_operational_assistance_id' => $this->school_operational_assistance_id,
            'school_operational_assistance' => $this->school_operational_assistance,
            'commodity_location_id' => $this->commodity_location_id,
            'commodity_location' => $this->commodity_location,
            'item_code' => $this->item_code,
            'name' => $this->name,
            'material' => $this->material,
            'brand' => $this->brand,
            'year_of_purchase' => $this->year_of_purchase,
            'condition' => $this->condition,
            'condition_name' => $this->getConditionName(),
            'quantity' => $this->quantity,
            'price' => $this->price,
            'price_formatted' => $this->indonesian_currency($this->price),
            'price_per_item' => $this->price_per_item,
            'price_per_item_formatted' => $this->indonesian_currency($this->price_per_item),
            'note' => $this->note
        ];
    }
}
