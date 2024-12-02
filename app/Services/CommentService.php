<?php

namespace App\Services;

use App\Helpers\CommentsHelper;
use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;
use App\Helpers\ModelHelper;

class CommentService
{
    use ModelHelper;
    use CommentsHelper;

    public function __construct(private readonly Comment $model)
    {
    }

    public function getComments(Request $request, Post $post): array
    {
        $commentsQueryBuilder = $post->comments()->getQuery();

        if ($request->has('content')) {
            $commentsQueryBuilder->where('content', 'like', '%' . $request->input('content') . '%');
        }

        $this->applyFilters($request, $commentsQueryBuilder);
        $count = $commentsQueryBuilder->count();

        $this->applyLimit($request, $commentsQueryBuilder);
        $this->applyPagination($request, $commentsQueryBuilder);

        return [
            'result' => $commentsQueryBuilder->get(),
            'count' => $count
        ];
    }

    public function createComment(Request $request, int $postId): void
    {
        $content = $request->input('content');
        $abbreviation = $this->generateAbbreviation($content);

        if ($this->model->where('abbreviation', $abbreviation)->exists()) {
            throw new \RuntimeException('Abbreviation already exists');
        }

        $this->model->create([
            'content' => $content,
            'post_id' => $postId,
            'abbreviation' => $abbreviation
        ]);
    }

    public function deleteComment(int $comment): void
    {
        $comment = $this->model->find($comment);

        if(!$comment) {
            throw new \RuntimeException('Comment not found');
        }
        $comment->delete();
    }
}
