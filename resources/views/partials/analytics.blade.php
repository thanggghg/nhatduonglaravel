@php
    $analyticsCollectorUrl = trim((string) config('analytics.collector_url'));
    $analyticsSecret = trim((string) config('analytics.secret'));
    $analyticsRoute = request()->route();
    $analyticsRouteName = $analyticsRoute?->getName();
    $analyticsRouteUri = $analyticsRoute?->uri() ?? '/';
    $analyticsPath = $analyticsRouteUri === '/' ? '/' : '/'.ltrim($analyticsRouteUri, '/');
@endphp
@if($analyticsCollectorUrl !== '' && $analyticsSecret !== '')
<script>
(() => {
    if (navigator.doNotTrack === '1') return;

    const uuid = () => {
        if (crypto.randomUUID) return crypto.randomUUID();
        const bytes = crypto.getRandomValues(new Uint8Array(16));
        bytes[6] = (bytes[6] & 15) | 64;
        bytes[8] = (bytes[8] & 63) | 128;
        const hex = Array.from(bytes, byte => byte.toString(16).padStart(2, '0')).join('');
        return `${hex.slice(0, 8)}-${hex.slice(8, 12)}-${hex.slice(12, 16)}-${hex.slice(16, 20)}-${hex.slice(20)}`;
    };
    const storedUuid = (storage, key) => {
        try {
            let value = storage.getItem(key);
            if (!value) {
                value = uuid();
                storage.setItem(key, value);
            }
            return value;
        } catch {
            return null;
        }
    };
    const visitorUuid = storedUuid(localStorage, 'analytics_visitor_uuid');
    const sessionUuid = storedUuid(sessionStorage, 'analytics_session_uuid');
    if (!visitorUuid || !sessionUuid) return;

    let referrerHost = null;
    try {
        referrerHost = document.referrer ? new URL(document.referrer).hostname || null : null;
    } catch {}

    const width = Math.max(document.documentElement.clientWidth, innerWidth || 0);
    const payload = JSON.stringify({
        _token: @json(csrf_token()),
        event_uuid: uuid(),
        visitor_uuid: visitorUuid,
        session_uuid: sessionUuid,
        route_name: @json($analyticsRouteName),
        path: @json($analyticsPath),
        referrer_host: referrerHost,
        locale: @json(app()->getLocale()),
        device_type: width <= 767 ? 'mobile' : (width <= 1024 ? 'tablet' : 'desktop'),
    });
    const endpoint = '/api/analytics/page-view';
    const fallback = () => fetch(endpoint, {
        method: 'POST',
        headers: {'Content-Type': 'application/json'},
        body: payload,
        keepalive: true,
        credentials: 'same-origin',
    }).catch(() => {});

    try {
        if (!navigator.sendBeacon(endpoint, new Blob([payload], {type: 'application/json'}))) fallback();
    } catch {
        fallback();
    }
})();
</script>
@endif
