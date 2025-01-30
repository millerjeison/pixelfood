<?php

return [
    'name' => env('APP_NAME', 'FoodAppi'),
    'manifest' => [
        'name' => env('APP_NAME', 'FoodAppi'),
        'short_name' => env('APP_NAME', 'FoodAppi'),
        'start_url' => '/',
        'background_color' => '#ffffff',
        'theme_color' => '#000000',
        'display' => 'standalone',
        'orientation'=> 'Natural',
        'status_bar'=> 'black',
        'icons' => [
            '72x72' => [
                'path' => env('D_72x72', '/images/icons/icon-72x72.png'),
                'purpose' => 'any'
            ],
            '96x96' => [
                'path' => env('D_96x96', '/images/icons/icon-96x96.png'),
                'purpose' => 'any'
            ],
            '128x128' => [
                'path' => env('D_128x128', '/images/icons/icon-128x128.png'),
                'purpose' => 'any'
            ],
            '144x144' => [
                'path' => env('D_144x144','/images/icons/icon-144x144.png'),
                'purpose' => 'any'
            ],
            '152x152' => [
                'path' => env('D_152x152','/images/icons/icon-152x152.png'),
                'purpose' => 'any'
            ],
            '192x192' => [
                'path' => env('D_192x192','/images/icons/icon-192x192.png'),
                'purpose' => 'any'
            ],
            '384x384' => [
                'path' => env('D_384x384','/images/icons/icon-384x384.png'),
                'purpose' => 'any'
            ],
            '512x512' => [
                'path' => env('D_512x512','/images/icons/icon-512x512.png'),
                'purpose' => 'any'
            ],
        ],
        'splash' => [
            '640x1136' => env('D_640x1136','/images/icons/splash-640x1136.png'),
            '750x1334' => env('D_750x1334','/images/icons/splash-750x1334.png'),
            '828x1792' => env('D_828x1792','/images/icons/splash-828x1792.png'),
            '1125x2436' => env('D_1125x2436','/images/icons/splash-1125x2436.png'),
            '1242x2208' => env('D_1242x2208','/images/icons/splash-1242x2208.png'),
            '1242x2688' => env('D_1242x2688','/images/icons/splash-1242x2688.png'),
            '1536x2048' => env('D_1536x2048','/images/icons/splash-1536x2048.png'),
            '1668x2224' => env('D_1668x2224','/images/icons/splash-1668x2224.png'),
            '1668x2388' => env('D_1668x2388','/images/icons/splash-1668x2388.png'),
            '2048x2732' => env('D_2048x2732','/images/icons/splash-2048x2732.png'),
        ],
        'shortcuts' => [
            [
                'name' => env('APP_NAME', 'FoodAppi'),
                'description' => env('APP_NAME', 'FoodAppi'),
                'url' => '/',
                'icons' => [
                    "src" => env('D_72x72', '/images/icons/icon-72x72.png'),
                    "purpose" => "any"
                ]
            ]
        ],
        'custom' => []
    ]
];
