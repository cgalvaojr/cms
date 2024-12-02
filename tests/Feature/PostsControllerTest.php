<?php

namespace Tests\Feature;

use App\Models\Post;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PostsControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_get_posts(): void
    {
        Post::factory()->count(3)->create();

        $response = $this->getJson(route('posts.get'));

        $response->assertStatus(200)
            ->assertJsonCount(2);
    }

    public function test_delete_post(): void
    {
        $post = Post::factory()->create();
        $response = $this->deleteJson(route('posts.delete', ['post' => $post->id]));

        $response->assertStatus(200)
            ->assertJson(['result' => 'Post deleted']);

        $this->assertDatabaseMissing('posts', ['id' => $post->id]);
    }

    public function test_delete_non_existent_post(): void
    {
        $nonExistentPostId = 999; // Assuming this ID does not exist

        $response = $this->deleteJson(route('posts.delete', ['post' => $nonExistentPostId]));

        $response->assertStatus(404);
    }
}
