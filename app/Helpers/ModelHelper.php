<?php

namespace App\Helpers;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

trait ModelHelper
{
    private const int DEFAULT_PAGE_NUMBER = 1;
    private const int DEFAULT_ROWS_LIMIT = 10;

    public function applyLimit(Request $request, Builder $queryBuilder): void
    {
        if($request->has('limit')) {
            $queryBuilder->limit($request->limit);
        }
    }

    public function applyPagination(Request $request, Builder $queryBuilder): void
    {
        if($request->has('page')) {
            $queryBuilder->paginate($request->page);
        }
    }
    public function applyFilters(Request $request, Builder $queryBuilder): Builder
    {
        $queryBuilder->paginate(self::DEFAULT_PAGE_NUMBER);
        $queryBuilder->limit(self::DEFAULT_ROWS_LIMIT);

        if($request->has('id')) {
            $queryBuilder->where('id', $request->id);
        }

        if($request->has('created_at')) {
            $queryBuilder->whereDate('created_at', $request->created_at);
        }

        if($request->has('updated_at')) {
            $queryBuilder->whereDate('updated_at', $request->created_at);
        }

        if($request->has('sort')) {
            $queryBuilder->orderBy($request->sort, $request->direction ?? 'asc');
        }

        if($request->has('with')) {
            $queryBuilder->with($request->with);
        }

        return $queryBuilder;
    }
}
