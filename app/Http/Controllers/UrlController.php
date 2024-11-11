<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UrlController extends Controller
{
    public function receiveUrl(Request $request): JsonResponse
    {
        $request->validate([
            'url' => 'required|url',
        ]);
        return response()->json(['message' => 'url recebida'], 200);

    }
}
