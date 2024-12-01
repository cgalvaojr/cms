<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseHelper;
use App\Models\Post;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PostsController extends Controller
{
    public function get(Request $request): JsonResponse
    {
        return response()->json(ResponseHelper::formatResponse(Post::all()));
    }

    public function delete(Post $post): JsonResponse
    {
        $post->delete();
        return response()->json(['result' => 'Post deleted']);
    }
}
