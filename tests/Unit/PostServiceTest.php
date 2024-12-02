<?php

namespace Tests\Unit;

use App\Models\Post;
use App\Services\PostService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;
use Tests\TestCase;

class PostServiceTest extends TestCase
{
    use RefreshDatabase;

    private PostService $postService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->postService = new PostService(new Post());
    }

    public function test_get_posts(): void
    {
        Post::factory()->createMany([
            ['topic' => 'Test Topic 1'],
            ['topic' => 'Test Topic 2'],
            ['topic' => 'Test Topic 3'],
        ]);

        $request = new Request(['topic' => 'Test']);
        $result = $this->postService->getPosts($request);

        $this->assertCount(3, $result['result']);
        $this->assertEquals(3, $result['count']);
    }
}
