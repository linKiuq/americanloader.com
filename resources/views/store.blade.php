<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Store - Typhon Machinery</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen bg-white text-gray-950">
    @include('partials.header')

    <main class="py-10 px-4 sm:px-6 lg:px-8">
        <div class="max-w-7xl mx-auto">
            <div id="my-store-80100025"></div>
            <script data-cfasync="false" type="text/javascript" src="https://app.ecwid.com/script.js?80100025&data_platform=code&data_date=2026-02-23" charset="utf-8"></script>
            <script type="text/javascript">xProductBrowser("categoriesPerRow=3","views=grid(20,3) list(60) table(60)","categoryView=grid","searchView=list","id=my-store-80100025");</script>
        </div>
    </main>

    @include('partials.footer')
</body>
</html>
