<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Hotel Booking')</title>

    {{-- CSS --}}
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <script src="{{ asset('js/slide.js') }}" defer></script>
</head>
<body>
    {{-- Header --}}
    <header>
        <nav>
            <!-- Dán menu trong index.html vào đây -->
        </nav>
    </header>

    {{-- Nội dung thay đổi từng trang --}}
    <main>
        @yield('content')
    </main>

    {{-- Footer --}}
    <footer>
        <!-- Dán phần footer index.html -->
    </footer>
</body>
</html>
