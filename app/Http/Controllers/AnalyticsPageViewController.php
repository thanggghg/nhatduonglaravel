<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Validation\Rule;
use Throwable;

class AnalyticsPageViewController extends Controller
{
    public function __invoke(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'event_uuid' => ['required', 'uuid'],
            'visitor_uuid' => ['required', 'uuid'],
            'session_uuid' => ['required', 'uuid'],
            'route_name' => ['nullable', 'string', 'max:160'],
            'path' => ['required', 'string', 'max:500'],
            'referrer_host' => ['nullable', 'string', 'max:255'],
            'locale' => ['nullable', 'string', 'max:20'],
            'device_type' => ['required', Rule::in(['desktop', 'tablet', 'mobile'])],
        ]);

        $collectorUrl = trim((string) config('analytics.collector_url'));
        $secret = trim((string) config('analytics.secret'));

        if ($collectorUrl === '' || $secret === '') {
            return response()->json(status: 202);
        }

        try {
            $payload = [
                'event_uuid' => $validated['event_uuid'],
                'visitor_hash' => hash_hmac('sha256', $validated['visitor_uuid'], $secret),
                'session_hash' => hash_hmac('sha256', $validated['session_uuid'], $secret),
                'occurred_at' => now()->toISOString(),
                'route_name' => $validated['route_name'] ?? null,
                'path' => $validated['path'],
                'referrer_host' => $validated['referrer_host'] ?? null,
                'locale' => $validated['locale'] ?? null,
                'device_type' => $validated['device_type'],
            ];
            $body = json_encode($payload, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_THROW_ON_ERROR);
            $timestamp = (string) now()->timestamp;
            $timeout = max(0.1, (float) config('analytics.timeout', 2));

            Http::connectTimeout(min(1, $timeout))
                ->timeout($timeout)
                ->withHeaders([
                    'Content-Type' => 'application/json',
                    'X-Analytics-Site' => (string) config('analytics.site'),
                    'X-Analytics-Timestamp' => $timestamp,
                    'X-Analytics-Signature' => hash_hmac('sha256', $timestamp.'.'.$body, $secret),
                ])
                ->withBody($body, 'application/json')
                ->post($collectorUrl);
        } catch (Throwable) {
            // Analytics must never affect the public request.
        }

        return response()->json(status: 202);
    }
}
