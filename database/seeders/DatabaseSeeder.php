<?php

namespace Database\Seeders;

use App\Models\Dish;
use App\Models\MenuSection;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $sections = MenuSection::factory(3)->create();

        Dish::factory(21)->recycle($sections)->create();
    }
}
