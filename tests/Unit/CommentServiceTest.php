<?php

namespace Tests\Unit;

use App\Models\Comment;
use App\Models\Post;
use App\Services\CommentService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;
use Mockery;
use Tests\TestCase;

class CommentServiceTest extends TestCase
{
    use RefreshDatabase;

    private CommentService $commentService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->commentService = new CommentService(new Comment());
    }

    public function test_get_comments(): void
    {
        $post = Mockery::mock(Post::class);
        $commentsQueryBuilder = Mockery::mock(Builder::class);

        $post->shouldReceive('comments->getQuery')
            ->andReturn($commentsQueryBuilder);

        $commentsQueryBuilder->shouldReceive('where')
            ->with('content', 'like', '%test%')
            ->andReturnSelf();
        $commentsQueryBuilder->shouldReceive('count')
            ->andReturn(3);
        $commentsQueryBuilder->shouldReceive('get')
            ->andReturn(collect([new Comment(), new Comment(), new Comment()]));
        $commentsQueryBuilder->shouldReceive('paginate')
            ->andReturn(collect([new Comment(), new Comment(), new Comment()]));
        $commentsQueryBuilder->shouldReceive('limit')
            ->andReturnSelf();

        $request = new Request(['content' => 'test']);
        $result = $this->commentService->getComments($request, $post);

        $this->assertCount(3, $result['result']);
        $this->assertEquals(3, $result['count']);
    }

    public function test_create_comment(): void
    {
        $post = Mockery::mock(Post::class);
        $post->shouldReceive('getAttribute')->with('id')->andReturn(1);

        $comment = Mockery::mock(Comment::class);
        $comment->shouldReceive('where')->with('abbreviation', Mockery::type('string'))->andReturnSelf();
        $comment->shouldReceive('exists')->andReturn(false);
        $comment->shouldReceive('create')->with([
            'content' => 'Test comment',
            'post_id' => 1,
            'abbreviation' => 'tc'
        ])->andReturnSelf();

        $this->commentService = new CommentService($comment);

        $request = new Request([
            'content' => 'Test comment',
        ]);
        $this->commentService->createComment($request, $post->id);

        $comment->shouldHaveReceived('create')->with([
            'content' => 'Test comment',
            'post_id' => 1,
            'abbreviation' => 'tc'
        ])->once();
    }

    public function test_delete_comment(): void
    {
        $post = Post::factory()->create();
        $comment = Comment::factory()->create(['post_id' => $post->id]);

        $this->commentService->deleteComment($comment->id);
        $this->assertDatabaseMissing('comments', ['id' => $comment->id]);
    }
}
