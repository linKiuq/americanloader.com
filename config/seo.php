<?php

return [
    'site_name' => env('SEO_SITE_NAME', 'American Loader'),
    'site_url' => rtrim(env('SEO_SITE_URL', 'https://americanloader.com'), '/'),
    'default_title' => env('SEO_DEFAULT_TITLE', 'American Loader | Wheel Loaders, Skid Steers & Mini Excavators'),
    'default_description' => env('SEO_DEFAULT_DESCRIPTION', 'Shop American Loader for TYPHON wheel loaders, skid steer loaders, STORM mini excavators, forklifts, road rollers, scissor lifts, and jobsite attachments in the USA.'),
    'default_image' => env('SEO_DEFAULT_IMAGE', 'hero-power-loader.png'),
    'keywords' => env('SEO_KEYWORDS', 'American Loader, American Loader equipment, American Loader wheel loaders, American Loader skid steer loaders, American Loader mini excavators, American Loader attachments, TYPHON wheel loader, wheel loaders for sale, skid steer loader, STORM mini excavator, mini excavator attachments, skid steer attachments, SKOOP attachments, electric forklift, road roller, scissor lift, compact construction equipment'),
    'equipment_categories' => [
        'Wheel Loaders',
        'Skid Steer Loaders',
        'Mini Excavators',
        'Mini Excavator Attachments',
        'Skid Steer Attachments',
        'SKOOP Attachments',
        'Forklifts',
        'Road Rollers',
        'Scissor Lifts',
    ],
    // The checked-in HTML verification file is the default verification method.
    // Set this only to the token from Google's HTML-tag verification method.
    'google_site_verification' => env('GOOGLE_SITE_VERIFICATION'),
    'phone' => env('SEO_PHONE', '+1-800-000-0000'),
    'email' => env('SEO_EMAIL', 'sales@typhonmachinery.com'),
    'address' => [
        'street' => env('SEO_STREET_ADDRESS', '2522 S Malt Ave'),
        'city' => env('SEO_CITY', 'Commerce'),
        'region' => env('SEO_REGION', 'CA'),
        'postal_code' => env('SEO_POSTAL_CODE', '90040'),
        'country' => env('SEO_COUNTRY', 'US'),
    ],
];
