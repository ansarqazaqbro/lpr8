<?php

namespace App\Models;

use Database\Factories\DishFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Dish extends Model
{
    /** @use HasFactory<DishFactory> */
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'menu_section_id',
        'name',
        'description',
        'weight_g',
        'price',
        'calories',
        'is_vegan',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'price' => 'decimal:2',
            'is_vegan' => 'boolean',
        ];
    }

    /**
     * Get the menu section that owns the dish.
     */
    public function menuSection(): BelongsTo
    {
        return $this->belongsTo(MenuSection::class);
    }
}
