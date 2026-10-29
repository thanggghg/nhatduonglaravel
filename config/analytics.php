<?php

return [
    'collector_url' => env('ANALYTICS_COLLECTOR_URL', 'https://ct.xvo.vn/api/analytics/page-views'),
    'site' => env('ANALYTICS_SITE', 'nhaxenhatduong.com'),
    'secret' => env('ANALYTICS_SECRET'),
    'timeout' => (float) env('ANALYTICS_TIMEOUT', 2),
];
