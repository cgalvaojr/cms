<?php

namespace App\Services;

use App\Models\Post;
use App\Helpers\ModelHelper;
use Illuminate\Http\Request;

class PostService
{
    use ModelHelper;
    public function __construct(private readonly Post $model)
    {
    }

    public function getPosts(Request $request): array
    {
        $queryBuilder = $this->model->query();

        if($request->has('topic')) {
            $queryBuilder->where('topic', 'like', '%'.$request->topic.'%');
        }

        $this->applyFilters($request, $queryBuilder);
        $count = $queryBuilder->count();

        $this->applyLimit($request, $queryBuilder);
        $this->applyPagination($request, $queryBuilder);

        return [
            'result' => $queryBuilder->get(),
            'count' => $count
        ];
    }
}
