<?php

namespace App\Helpers;

trait ResponseHelper
{
    public function formatResponse($data): array
    {
        return [
            'count' => count($data),
            'result' => $data
        ];
    }

    public function errorResponse(\Exception $exception): array
    {
        return ['error' => $exception->getMessage()];
    }
}
