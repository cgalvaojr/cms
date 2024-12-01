<?php

namespace App\Helpers;

class ResponseHelper
{
    public static function formatResponse($data): array
    {
        return [
            'count' => count($data),
            'result' => $data
        ];
    }
}
