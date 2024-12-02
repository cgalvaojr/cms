<?php

namespace Tests\Feature;

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CommentsControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_get_comments()
    {
        $post = Post::factory()->create();
        Comment::factory()->count(3)->create(['post_id' => $post->id]);

        $response = $this->getJson(route('comments.get', ['post' => $post->id]));

        $response->assertStatus(200)
            ->assertJsonCount(2);
    }
    public function test_create_comment()
    {
        $post = Post::factory()->create();
        $commentData = [
            'content' => 'I am writing this comment here',
            'abbreviation' => 'iawtch',
        ];

        $response = $this->postJson(route('comments.create', ['post' => $post->id]), $commentData);

        $response->assertStatus(200)
            ->assertJson(['result' => 'Created comment in post id ' . $post->id]);

        $this->assertDatabaseHas('comments', $commentData);
    }

    public function test_delete_comment()
    {
        $post = Post::factory()->create();
        $comment = Comment::factory()->create(['post_id' => $post->id]);

        $response = $this->deleteJson(route('comments.delete', ['post' => $post->id, 'comment' => $comment->id]));

        $response->assertStatus(200)
            ->assertJson([true]);

        $this->assertDatabaseMissing('comments', ['id' => $comment->id]);
    }
}
