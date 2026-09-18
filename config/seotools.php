<?php

return [
    'inertia' => env('SEO_TOOLS_INERTIA', false),

    'meta' => [
        'defaults' => [
            'title' => 'Nhà Xe Nhật Dương',
            'titleBefore' => false,
            'description' => 'Nhà Xe Nhật Dương phục vụ tuyến Sài Gòn - Nha Trang với xe giường nằm chất lượng cao.',
            'separator' => ' | ',
            'keywords' => [],
            'canonical' => false,
            'robots' => false,
        ],
        'webmaster_tags' => [
            'google' => null,
            'bing' => null,
            'alexa' => null,
            'pinterest' => null,
            'yandex' => null,
            'norton' => null,
        ],
        'add_notranslate_class' => false,
    ],

    'opengraph' => [
        'defaults' => [
            'title' => 'Nhà Xe Nhật Dương',
            'description' => 'Xe khách giường nằm chất lượng cao tuyến Sài Gòn - Nha Trang.',
            'url' => false,
            'type' => false,
            'site_name' => 'Nhà Xe Nhật Dương',
            'images' => [],
        ],
    ],

    'twitter' => [
        'defaults' => [],
    ],

    'json-ld' => [
        'defaults' => [
            'title' => 'Nhà Xe Nhật Dương',
            'description' => 'Xe khách giường nằm chất lượng cao tuyến Sài Gòn - Nha Trang.',
            'url' => false,
            'type' => 'WebPage',
            'images' => [],
        ],
    ],
];
