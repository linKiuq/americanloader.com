@php
    $seoSiteName = config('seo.site_name', 'KONSTRUCTZ');
    $seoSiteUrl = rtrim(config('seo.site_url', url('/')), '/');
    $seoTitle = $title ?? config('seo.default_title');
    $seoDescription = $description ?? config('seo.default_description');
    $seoRobots = $robots ?? 'index, follow, max-image-preview:large, max-snippet:-1, max-video-preview:-1';
    $seoCanonical = $canonical ?? ($seoSiteUrl . (request()->path() === '/' ? '/' : '/' . ltrim(request()->path(), '/')));
    $seoType = $type ?? 'website';
    $seoImage = $image ?? config('seo.default_image');
    $seoKeywords = $keywords ?? config('seo.keywords');
    $seoPublishedTime = $publishedTime ?? null;
    $seoModifiedTime = $modifiedTime ?? $seoPublishedTime;
    $seoGoogleVerification = config('seo.google_site_verification');

    if (! str_starts_with($seoImage, 'http://') && ! str_starts_with($seoImage, 'https://')) {
        $seoImage = $seoSiteUrl . '/' . ltrim($seoImage, '/');
    }

    $seoGraph = [
        [
            '@type' => 'Organization',
            '@id' => $seoSiteUrl . '/#organization',
            'name' => $seoSiteName,
            'url' => $seoSiteUrl . '/',
            'logo' => [
                '@type' => 'ImageObject',
                'url' => $seoSiteUrl . '/power-loader-logo.png',
            ],
            'image' => $seoImage,
            'email' => config('seo.email'),
            'telephone' => config('seo.phone'),
            'address' => [
                '@type' => 'PostalAddress',
                'streetAddress' => config('seo.address.street'),
                'addressLocality' => config('seo.address.city'),
                'addressRegion' => config('seo.address.region'),
                'postalCode' => config('seo.address.postal_code'),
                'addressCountry' => config('seo.address.country'),
            ],
            'contactPoint' => [
                [
                    '@type' => 'ContactPoint',
                    'telephone' => config('seo.phone'),
                    'contactType' => 'sales',
                    'areaServed' => 'US',
                    'availableLanguage' => ['English'],
                ],
            ],
        ],
        [
            '@type' => 'WebSite',
            '@id' => $seoSiteUrl . '/#website',
            'url' => $seoSiteUrl . '/',
            'name' => $seoSiteName,
            'publisher' => ['@id' => $seoSiteUrl . '/#organization'],
            'potentialAction' => [
                '@type' => 'SearchAction',
                'target' => $seoSiteUrl . '/equipment?search={search_term_string}',
                'query-input' => 'required name=search_term_string',
            ],
        ],
        [
            '@type' => $seoType === 'article' ? 'Article' : 'WebPage',
            '@id' => $seoCanonical . '#webpage',
            'url' => $seoCanonical,
            'name' => $seoTitle,
            'description' => $seoDescription,
            'isPartOf' => ['@id' => $seoSiteUrl . '/#website'],
            'about' => ['@id' => $seoSiteUrl . '/#organization'],
            'primaryImageOfPage' => [
                '@type' => 'ImageObject',
                'url' => $seoImage,
            ],
        ],
        [
            '@type' => 'BreadcrumbList',
            '@id' => $seoCanonical . '#breadcrumb',
            'itemListElement' => collect(explode('/', trim(request()->path(), '/')))
                ->filter()
                ->values()
                ->prepend('Home')
                ->map(function (string $segment, int $index) use ($seoSiteUrl) {
                    $pathSegments = collect(explode('/', trim(request()->path(), '/')))->filter()->values();
                    $itemPath = $index === 0 ? '/' : '/' . $pathSegments->take($index)->implode('/');

                    return [
                        '@type' => 'ListItem',
                        'position' => $index + 1,
                        'name' => $index === 0 ? 'Home' : str($segment)->replace('-', ' ')->title()->toString(),
                        'item' => $seoSiteUrl . ($itemPath === '/' ? '/' : $itemPath),
                    ];
                })
                ->values()
                ->all(),
        ],
    ];

    if ($seoPublishedTime) {
        $seoGraph[2]['datePublished'] = $seoPublishedTime;
    }

    if ($seoModifiedTime) {
        $seoGraph[2]['dateModified'] = $seoModifiedTime;
    }

    $seoJsonLd = $jsonLd ?? [];
    $extraGraph = [];

    if (! empty($seoJsonLd)) {
        if (isset($seoJsonLd['@graph'])) {
            $extraGraph = $seoJsonLd['@graph'];
        } elseif (array_is_list($seoJsonLd)) {
            $extraGraph = $seoJsonLd;
        } else {
            unset($seoJsonLd['@context']);
            $extraGraph = [$seoJsonLd];
        }
    }

    $seoSchema = [
        '@context' => 'https://schema.org',
        '@graph' => array_values(array_merge($seoGraph, $extraGraph)),
    ];
@endphp
<title>{{ $seoTitle }}</title>
<meta name="description" content="{{ $seoDescription }}">
<meta name="keywords" content="{{ $seoKeywords }}">
<meta name="robots" content="{{ $seoRobots }}">
@if ($seoGoogleVerification)
<meta name="google-site-verification" content="{{ $seoGoogleVerification }}">
@endif
<link rel="canonical" href="{{ $seoCanonical }}">
<link rel="alternate" href="{{ $seoCanonical }}" hreflang="en-us">
<meta property="og:site_name" content="{{ $seoSiteName }}">
<meta property="og:title" content="{{ $seoTitle }}">
<meta property="og:description" content="{{ $seoDescription }}">
<meta property="og:type" content="{{ $seoType }}">
<meta property="og:url" content="{{ $seoCanonical }}">
<meta property="og:image" content="{{ $seoImage }}">
<meta property="og:locale" content="en_US">
@if ($seoPublishedTime)
<meta property="article:published_time" content="{{ $seoPublishedTime }}">
@endif
@if ($seoModifiedTime)
<meta property="article:modified_time" content="{{ $seoModifiedTime }}">
@endif
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="{{ $seoTitle }}">
<meta name="twitter:description" content="{{ $seoDescription }}">
<meta name="twitter:image" content="{{ $seoImage }}">
<script type="application/ld+json">{!! json_encode($seoSchema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}</script>
