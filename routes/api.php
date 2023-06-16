<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Cache;

Route::middleware('api')->match(['get', 'post'], '/api/postcodenl', function (Request $request) {
    $request->merge([
        'postcode' => strtoupper(str_replace(' ', '', $request->json('postcode'))),
    ])->validate([
        'postcode' => 'required|string|max:6',
        'house_number' => 'required',
    ]);

    $cacheKey = 'postcodenl-'.$request->json('postcode').'-'.$request->json('house_number');

    return Cache::rememberForever($cacheKey, function () use ($request) {
        return Http::postcodenl()->get(
            '/nl/v1/addresses/postcode/' . $request->json('postcode') . '/' . $request->json('house_number') . '/' . $request->json('house_number_addition')
        )->throw()->json();
    });
});
