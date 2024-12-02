<?php

namespace App\Http\Controllers;

use App\Http\Requests\CommentsRequest;
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
        $comments = $this->service->getComments($request, $post);
        return response()->json($comments);
    }

    public function delete(Post $post, int $comment): JsonResponse
    {
        try {
            $this->service->deleteComment($comment);
            return response()->json([true]);
        } catch (\Exception $exception) {
            return response()->json(['error' => $exception->getMessage()], 400);
        }
    }

    public function create(CommentsRequest $request, Post $post): JsonResponse
    {
        try {
            $this->service->createComment($request, $post->id);
            return response()->json(['result' => 'Created comment in post id ' . $post->id]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }
}
