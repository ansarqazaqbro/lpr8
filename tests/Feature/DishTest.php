<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DishTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test that /dishes returns 200 OK.
     */
    public function test_dishes_index_returns_successful_response(): void
    {
        $response = $this->get('/dishes');

        $response->assertStatus(200);
        $response->assertSee('Управление меню');
    }
}
