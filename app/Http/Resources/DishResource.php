<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin \App\Models\Dish
 */
class DishResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'weight_g' => $this->weight_g,
            'price' => $this->price,
            'calories' => $this->calories,
            'is_vegan' => $this->is_vegan ? 'yes' : 'no',
            'menu_section' => $this->whenLoaded('menuSection', fn () => [
                'id' => $this->menuSection->id,
                'name' => $this->menuSection->name,
            ]),
            'created_at' => $this->created_at?->toIso8601String(),
        ];
    }
}
