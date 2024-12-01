<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseHelper;
use App\Http\Requests\PostsRequest;
use App\Models\Post;
use App\Services\PostService;
use Illuminate\Http\JsonResponse;

class PostsController extends Controller
{
    use ResponseHelper;

    public function __construct(private readonly PostService $service)
    {

    }

    public function get(PostsRequest $request): JsonResponse
    {
        try {
            $posts = $this->service->getPosts($request);
            return response()->json($posts);
        } catch (\Exception $exception) {
            return response()->json($this->errorResponse($exception));
        }
    }

    public function delete(Post $post): JsonResponse
    {
        $post->delete();
        return response()->json(['result' => 'Post deleted']);
    }
}
