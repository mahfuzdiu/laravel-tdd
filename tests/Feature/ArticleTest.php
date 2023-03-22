<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Log;
use Tests\TestCase;

class ArticleTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /** @test */
    public function test_creates_an_article(): void
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)->post('/articles', [
            'title' => $this->faker->title,
            'image_url' => $this->faker->url,
            'description' => $this->faker->text
        ]);

        $response->assertStatus(200);
        $this->assertDatabaseCount('articles', 1);
        $response->assertJson(['message' => 'Article created']);
    }
}
