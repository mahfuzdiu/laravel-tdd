<?php

namespace Tests\Feature;

use App\Models\Article;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Log;
use Tests\TestCase;

class ArticleTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /** @test */
    public function test_read_articles()
    {
        $currentPage = 1;
        $response =  $this->get('/articles?page=' . $currentPage);
        $response->assertOk();
    }


    /** @test */
    public function test_creates_an_article()
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

    /** @test */
    public function test_updates_an_article()
    {
        $user = User::factory()->create();
        $article = Article::create([
            'title' => $this->faker->title,
            'image_url' => $this->faker->url,
            'description' => $this->faker->text,
            'created_by' => $user->id
        ]);

        $response = $this->put('/articles/' . $article->id, array_merge($article->toArray(), ['title' => $this->faker->title]));

        $response->assertOk();
        $response->assertJsonStructure([
            'message',
            'article'
        ]);
    }
}
