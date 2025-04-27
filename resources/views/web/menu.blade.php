@extends('web.layout.layout')

@section('styles')
    <style>
        .menu-card {
            display: flex;
            flex-direction: column;
            gap: 1rem;
            padding: 1.5rem;
            margin-bottom: 1.5rem;
            transition: all 0.3s ease;
            border: 1px solid transparent;
            border-radius: 0.25rem;
            background-color: #fafafa;
        }

        .menu-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
            border-color: #e5e5e5;
        }

        .menu-image {
            width: 100%;
            height: 180px;
            object-fit: cover;
            border-radius: 0.25rem;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .menu-content {
            flex: 1;
            width: 100%;
        }

        .menu-header {
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
            margin-bottom: 0.75rem;
            border-bottom: 1px dashed #e5e5e5;
            padding-bottom: 0.75rem;
        }

        .menu-title {
            font-family: 'Playfair Display', serif;
            font-weight: 600;
            font-size: 1.25rem;
        }

        .menu-price {
            font-weight: 600;
            color: #000;
            background-color: #f3f3f3;
            padding: 0.25rem 0.75rem;
            border-radius: 0.25rem;
            align-self: flex-start;
        }

        .menu-description {
            color: #666;
            font-size: 0.95rem;
            line-height: 1.6;
        }

        /* Responsive styles */
        @media (min-width: 426px) {
            .menu-header {
                flex-direction: row;
                justify-content: space-between;
                align-items: center;
            }

            .menu-price {
                align-self: center;
            }
        }

        @media (min-width: 768px) {
            .menu-card {
                flex-direction: row;
                gap: 1.5rem;
            }

            .menu-image {
                width: 150px;
                height: 150px;
            }

            .grid {
                grid-template-columns: repeat(1, 1fr);
            }
        }

        @media (min-width: 1024px) {
            .grid {
                grid-template-columns: repeat(2, 1fr);
                gap: 2rem;
            }
        }
    </style>
@endsection


@section('content')
    <main>
        <!-- Updated Hero Section with real image and reduced height -->
        <section class="hero-section relative flex items-center justify-center"
            style="background-image: url('https://images.unsplash.com/photo-1592861956120-e524fc739696?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=2070&q=80'); height: 50vh;">
            <div class="absolute inset-0 bg-black bg-opacity-60"></div>
            <div class="container mx-auto px-4 z-10 text-center">
                <h1 class="text-4xl md:text-6xl font-bold text-white mb-6 text-shadow" data-animate>
                    Our Menu
                </h1>
                <p class="text-xl md:text-2xl text-white mb-8 max-w-3xl mx-auto text-shadow" data-animate>
                    Exquisite flavors crafted with passion and tradition
                </p>
            </div>
        </section>

        <!-- Menu Navigation -->
        <section class="py-12 bg-white">
            <div class="container mx-auto px-4">
                <div class="flex flex-wrap justify-center gap-4 mb-12" data-animate>
                    @foreach ($categories as $category)
                        <button
                            class="menu-tab px-6 py-2 border-b-2 border-transparent font-medium hover:border-gray-400 transition-all duration-300 {{ $loop->first ? 'active border-black' : '' }}"
                            data-category="{{ $category->id }}">
                            {{ $category->name }}
                        </button>
                    @endforeach
                </div>

                <!-- Menu Items -->
                <div id="menu-items">
                    @foreach ($categories as $category)
                        <div class="menu-section mb-16" data-category="{{ $category->id }}"
                            style="{{ $loop->first ? '' : 'display: none;' }}">
                            <h2 class="text-3xl font-bold mb-8 text-center">{{ $category->name }}</h2>
                            <div class="grid grid-cols-1 gap-4">
                                @php
                                    $categoryMenus = $menus->where('category_id', $category->id);
                                @endphp

                                @if ($categoryMenus->count() > 0)
                                    @foreach ($categoryMenus as $menu)
                                        <div class="menu-card">
                                            <img src="{{ $menu->image }}" alt="{{ $menu->name }}" class="menu-image">
                                            <div class="menu-content">
                                                <div class="menu-header">
                                                    <h3 class="menu-title">{{ $menu->name }}</h3>
                                                    <span class="menu-price">{{ $menu->price }}</span>
                                                </div>
                                                <p class="menu-description">
                                                    {{ $menu->description }}
                                                </p>
                                            </div>
                                        </div>
                                    @endforeach
                                @else
                                    <div class="text-center text-gray-500 py-8">
                                        No menu items available for this category.
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    </main>
@endsection

@section('scripts')
    <script src="{{ asset('js/web/menu.js') }}"></script>
    <script src="{{ asset('js/web/main.js') }}"></script>
@endsection
