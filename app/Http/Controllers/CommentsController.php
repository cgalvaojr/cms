<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseHelper;
use App\Models\Comment;
use App\Models\Post;
use App\Services\CommentService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CommentsController extends Controller
{
    public function __construct(private readonly CommentService $service)
    {
    }

    public function get(Request $request, Post $post): JsonResponse
    {
        $post->load('comments');
        $comments =  $post->comments()->get();
        return response()->json(ResponseHelper::formatResponse($comments));
    }

    public function delete(Post $post, Comment $comment): JsonResponse
    {
        $comment->delete();
        return response()->json(['result' => 'Comment deleted']);
    }

    public function create(Request $request, Post $post): JsonResponse
    {
        $comment = new Comment();
        $content = $request->input('content');
        $comment->content = $content;
        $comment->post_id = $post->id;
        $comment->abbreviation = $this->service->generateAbbreviation($content);
        $comment->save();

        return response()->json(['result' => 'Create comment in post ' . $post->id]);
    }
}
