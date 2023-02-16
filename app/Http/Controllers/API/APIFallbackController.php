<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class APIFallbackController extends APIBaseController
{
    /**
     * The Fallback controller overrides the 404 Not found error and replaces it with the defined error message
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function error(Request $request): JsonResponse
    {
        return $this->sendError(
            "Page not found. If error persists, contact " . env("APP_CONTACT", "J294862@tafe.wa.edu.au")
        );
    }
}
