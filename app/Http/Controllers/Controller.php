<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\JsonResponse;

class Controller extends BaseController
{
    use  AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function wrapResponse(int $code, string $message, ?array $resource = []): JsonResponse
    {
        $result = [
            'code' => $code,
            'msg' => $message,
        ];

        if (count($resource)) {
            $result = array_merge($result, ['data' => $resource['data']]);

            if (count($resource) > 1)
                $result = array_merge($result, ['pages' => ['links' => $resource['links'], 'meta' => $resource['meta']]]);
        }

        return response()->json($result,  $code);
    }
}
