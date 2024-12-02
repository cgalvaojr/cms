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
        $this->filterDates($request, $queryBuilder);

        if($request->has('id')) {
            $queryBuilder->where('id', $request->id);
        }

        if($request->has('sort')) {
            $queryBuilder->orderBy($request->sort, $request->direction ?? 'asc');
        }

        if($request->has('with')) {
            $queryBuilder->with($request->with);
        }

        return $queryBuilder;
    }

    private function filterDates($request, $queryBuilder)
    {
        $dateFilters = ['created_at', 'updated_at'];

        foreach ($dateFilters as $filter) {
            if ($request->has($filter)) {
                $date = $request->$filter;

                if (strlen($date) === 4) {
                    $queryBuilder->whereYear($filter, $date);
                } elseif (strlen($date) === 7) {
                    [$year, $month] = explode('-', $date);
                    $queryBuilder->whereYear($filter, $year)
                        ->whereMonth($filter, $month);
                } else {
                    $queryBuilder->whereDate($filter, $date);
                }
            }
        }
    }
}
