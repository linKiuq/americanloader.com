<?php

return [
    'site_name' => env('SEO_SITE_NAME', 'The Power Loader'),
    'site_url' => rtrim(env('SEO_SITE_URL', 'https://cwqv.com'), '/'),
    'default_title' => env('SEO_DEFAULT_TITLE', 'The Power Loader | Skoop Loader, Wheel Loader & Attachments'),
    'default_description' => env('SEO_DEFAULT_DESCRIPTION', 'Shop The Power Loader at cwqv.com for Skoop loader and wheel loader equipment, skid steer loaders, mini excavators, forklifts, scissor lifts, and jobsite attachments for sale in the USA.'),
    'default_image' => env('SEO_DEFAULT_IMAGE', 'hero-power-loader.png'),
    'keywords' => env('SEO_KEYWORDS', 'The Power Loader, Power Loader equipment, cwqv, cwqv.com, Skoop loader, wheel loader, Skoop wheel loader, wheel loader for sale, compact wheel loader, loader attachments, skid steer loaders, mini excavators'),
    'google_site_verification' => env('GOOGLE_SITE_VERIFICATION', 'google862afbc0daae0b2d.html'),
    'phone' => env('SEO_PHONE', '+1-800-000-0000'),
    'email' => env('SEO_EMAIL', 'sales@cwqv.com'),
    'address' => [
        'street' => env('SEO_STREET_ADDRESS', '2522 S Malt Ave'),
        'city' => env('SEO_CITY', 'Commerce'),
        'region' => env('SEO_REGION', 'CA'),
        'postal_code' => env('SEO_POSTAL_CODE', '90040'),
        'country' => env('SEO_COUNTRY', 'US'),
    ],
];
