<header id="header"
    class="fixed w-full z-50 transition-all duration-300 {{ request()->routeIs('allergies') ? 'bg-black' : 'bg-transparent' }}">
    <div class="container mx-auto px-4 py-4 flex justify-between items-center">
        <a href="index.html" class="text-2xl md:text-3xl font-bold font-serif">
            <img src="/images/Casa.png" alt="Casa de Familia Logo" class="w-30 h-20">
        </a>

        <!-- Desktop Navigation -->
        <nav class="hidden md:flex space-x-8">
            <a href="{{ route('welcome') }}" class="text-white hover:text-white transition-colors nav-link">Home</a>
            @if (auth()->check())
                <a href="{{ route('menu') }}" class="text-white hover:text-white transition-colors nav-link">Menu</a>
                <a href="{{ route('events') }}"
                    class="text-white hover:text-white transition-colors nav-link">Events</a>
            @endif
            <a href="{{ route('about') }}" class="text-white hover:text-white transition-colors nav-link">About</a>
            <a href="{{ route('contact') }}" class="text-white hover:text-white transition-colors nav-link">Contact</a>
            <a href="{{ route('faq') }}" class="text-white hover:text-white transition-colors nav-link">FAQ</a>
            <a href="{{ route('allergies') }}"
                class="text-white hover:text-white transition-colors nav-link">Allergies</a>
            @if (auth()->check())
                <a href="{{ route('logout') }}"
                    class="text-white hover:text-white transition-colors nav-link">Logout</a>
            @else
                <a href="{{ route('login') }}" class="text-white hover:text-white transition-colors nav-link">Login /
                    Register</a>
            @endif

            @role('admin')
                <a href="{{ route('dashboard.index') }}"
                    class="text-white hover:text-white transition-colors nav-link">Dashboard</a>
            @endrole
        </nav>

        <!-- Mobile Menu Button -->
        <button id="mobile-menu-btn" class="md:hidden text-white focus:outline-none">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16">
                </path>
            </svg>
        </button>
    </div>

    <!-- Mobile Navigation -->
    <div id="mobile-menu"
        class="md:hidden hidden bg-black bg-opacity-95 w-full absolute top-full left-0 py-4 shadow-lg">
        <div class="container mx-auto px-4 flex flex-col space-y-4">
            <a href="{{ route('welcome') }}"
                class="text-white hover:text-gray-300 transition-colors py-2 border-b border-gray-800">Home</a>
            <a href="{{ route('menu') }}"
                class="text-white hover:text-gray-300 transition-colors py-2 border-b border-gray-800">Menu</a>
            <a href="{{ route('events') }}"
                class="text-white hover:text-gray-300 transition-colors py-2 border-b border-gray-800">Events</a>
            <a href="{{ route('about') }}"
                class="text-white hover:text-gray-300 transition-colors py-2 border-b border-gray-800">About</a>
            <a href="{{ route('contact') }}"
                class="text-white hover:text-gray-300 transition-colors py-2 border-b border-gray-800">Contact</a>
            <a href="{{ route('faq') }}" class="text-white hover:text-gray-300 transition-colors py-2">FAQ</a>
            <a href="{{ route('allergies') }}"
                class="text-white hover:text-gray-300 transition-colors py-2 border-b border-gray-800">Allergies</a>
            @if (auth()->check())
                <a href="{{ route('logout') }}"
                    class="text-white hover:text-gray-300 transition-colors py-2 border-b border-gray-800">Logout</a>
            @else
                <a href="{{ route('login') }}" class="text-white hover:text-gray-300 transition-colors py-2">Login /
                    Register</a>
            @endif

            @role('admin')
                <a href="{{ route('dashboard.index') }}"
                    class="text-white hover:text-gray-300 transition-colors py-2 border-b border-gray-800">Dashboard</a>
            @endrole
        </div>
    </div>
</header>

