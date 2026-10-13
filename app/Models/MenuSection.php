<?php

namespace App\Models;

use Database\Factories\MenuSectionFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MenuSection extends Model
{
    /** @use HasFactory<MenuSectionFactory> */
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'sort_order',
    ];

    /**
     * Get the dishes for the menu section.
     */
    public function dishes(): HasMany
    {
        return $this->hasMany(Dish::class);
    }
}
