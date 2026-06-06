<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Symfony\Component\HttpFoundation\Response;

class CacheApiMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        return $next($request);
    }

    public static function fetch(string $endpoint, string $cacheKey, array $params = []): array
    {
        $baseUrl = rtrim(env('DESA_API_URL', 'https://nakulasadewa.com/apisidesa/public/api/desa'), '/');
        $url     = $baseUrl . '/' . ltrim($endpoint, '/');

        $response = Http::timeout(5)->get($url, $params);

        if ($response->successful()) {
            return $response->json();
        }

        throw new \Exception('Gagal mengambil data: ' . $response->status());
    }
}