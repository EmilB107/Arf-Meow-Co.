<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Arf & Meow Co.')</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <script defer src="{{ asset('js/sidenav.js') }}" ></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous">
    <script defer src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-j1CDi7MgGQ12Z7Qab0qlWQ/Qqz24Gc6BM0thvEMVjHnfYGF0rmFCozFSxQBxwHKO" crossorigin="anonymous">
    </script>
</head>

<body>
    <nav class="d-nav navbar navbar-expand-lg">
        <div class="container">
            @include('partials._brand')
            <div class="d-flex align-items-center">
                <form action="{{ route('logout') }}" method="POST" class="d-inline me-4">
                    @csrf
                    <button type="submit" class="btn p-0 border-0 bg-transparent text-white fw-bold">Sign Out</button>
                </form>
                <div class="me-2">
                    <img src="{{ asset('images/pic.png') }}" alt="User Image" width="30">
                    <p class="username text-center fw-bold">PM</p>
                </div>
            </div>
        </div>
    </nav>

    <div class="d-flex">
        <aside class="sidebar">
            <ul class="list-unstyled d-flex flex-column">
                <li class="ms-1 mt-3 mb-4">
                    <button id="menu-toggle">
                        <img src="{{ asset('images/sidenav-01.png') }}" alt="Menu Icon">
                    </button>
                </li>
                <li class="ms-1 mb-3">
                    <a class="d-flex align-items-center" href="{{ route('dashboard') }}">
                        <img src="{{ asset('images/sidenav-02.png') }}" alt="Home Icon">
                        <span class="menu-text">Home</span>
                    </a>
                </li>
                <li class="ms-1 mb-3">
                    <a class="d-flex align-items-center" href="{{ route('products.index') }}">
                        <img src="{{ asset('images/sidenav-03.png') }}" alt="Products Icon">
                        <span class="menu-text">Products</span>
                    </a>
                </li>
                <li class="ms-1 mb-3">
                    <a class="d-flex align-items-center" href="{{ route('categories.index') }}">
                        <img src="{{ asset('images/sidenav-04.png') }}" alt="Categories Icon">
                        <span class="menu-text">Categories</span>
                    </a>
                </li>
                <li class="ms-1 mb-3">
                    <a class="d-flex align-items-center" href="{{ route('inventory.index') }}">
                        <img src="{{ asset('images/sidenav-05.png') }}" alt="Inventory Icon">
                        <span class="menu-text">Inventory</span>
                    </a>
                </li>
                <li class="ms-1 mb-3">
                    <a class="d-flex align-items-center" href="{{ route('prices.index') }}">
                        <img src="{{ asset('images/sidenav-06.png') }}" alt="Prices Icon">
                        <span class="menu-text">Prices</span>
                    </a>
                </li>
            </ul>
        </aside>

        <main class="main-content flex-grow-1 p-4">
            @yield('content') <!-- Page-specific content will be injected here -->
        </main>
    </div>
</body>

</html>
