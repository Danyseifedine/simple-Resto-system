<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Casa de Familia | Elegant Mountain Dining</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700&family=Poppins:wght@300;400;500&display=swap"
        rel="stylesheet">

    @yield('styles')
</head>

<body>
    @include('web.components.navbar')

    @yield('content')

    @include('web.components.footer')

    @yield('scripts')

    <script src="{{ asset('core/packages/iziToast/iziToast.min.js') }}"></script>
    <script src="{{ url('core/vendor/js/plugins.bundle.js') }}"></script>
    <script src="{{ url('core/vendor/js/scripts.bundle.js') }}"></script>
    <script src="{{ url('core/vendor/js/datatables.bundle.js') }}"></script>
    <script src="{{ asset('core/global/Launcher.js') }}" type="module"></script>
</body>
