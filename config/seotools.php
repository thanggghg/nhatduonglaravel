<?php

return [
    'inertia' => env('SEO_TOOLS_INERTIA', false),

    'meta' => [
        'defaults' => [
            'title' => false,
            'titleBefore' => false,
            'description' => false,
            'separator' => ' - ',
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
            'title' => 'Nha Xe Nhat Duong',
            'description' => 'Reliable sleeper-bus travel in southern Vietnam.',
            'url' => false,
            'type' => false,
            'site_name' => 'Nha Xe Nhat Duong',
            'images' => [],
        ],
    ],

    'twitter' => [
        'defaults' => [],
    ],

    'json-ld' => [
        'defaults' => [
            'title' => 'Nha Xe Nhat Duong',
            'description' => 'Reliable sleeper-bus travel in southern Vietnam.',
            'url' => false,
            'type' => 'WebPage',
            'images' => [],
        ],
    ],
];
