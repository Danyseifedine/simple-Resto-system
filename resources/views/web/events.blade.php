@extends('web.layout.layout')

@section('content')
    <main>
        <!-- Updated Hero Section with real image and reduced height -->
        <section class="hero-section relative flex items-center justify-center"
            style="background-image: url('https://images.unsplash.com/photo-1519671482749-fd09be7ccebf?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=2070&q=80'); height: 50vh;">
            <div class="absolute inset-0 bg-black bg-opacity-60"></div>
            <div class="container mx-auto px-4 z-10 text-center">
                <h1 class="text-4xl md:text-6xl font-bold text-white mb-6 text-shadow" data-animate>
                    Events & Entertainment
                </h1>
                <p class="text-xl md:text-2xl text-white mb-8 max-w-3xl mx-auto text-shadow" data-animate>
                    Experience unforgettable moments at Casa de Familia
                </p>
            </div>
        </section>

        <!-- Upcoming Events Section (Simplified without images and Learn More buttons) -->
        <section class="py-20 bg-white">
            <div class="container mx-auto px-4">
                <div class="text-center mb-16" data-animate>
                    <h2 class="text-3xl md:text-4xl font-bold mb-6">Upcoming Events</h2>
                    <div class="w-20 h-1 bg-black mx-auto mb-6"></div>
                    <p class="text-gray-700 max-w-3xl mx-auto">
                        Join us for special evenings of exceptional food, music, and entertainment.
                    </p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    @if (count($events) > 0)
                        @foreach ($events as $event)
                            <div class="bg-gray-50 p-8 rounded-sm shadow-sm transition-all duration-300 hover:shadow-md"
                                data-animate>
                                <div class="mb-4">
                                    <span class="inline-block bg-black text-white text-sm px-3 py-1 rounded-sm">
                                        {{ \Carbon\Carbon::parse($event->start_date)->format('F d, Y') }}
                                    </span>
                                </div>
                                <h3 class="text-xl font-bold mb-3">{{ $event->title }}</h3>
                                <p class="text-gray-600 mb-4">
                                    {{ $event->description }}
                                </p>
                                <div class="flex items-center text-sm text-gray-500">
                                    <span class="flex items-center mr-4">
                                        <i class="far fa-clock mr-2"></i>
                                        {{ \Carbon\Carbon::parse($event->start_date)->format('g:i A') }} -
                                        {{ \Carbon\Carbon::parse($event->end_date)->format('g:i A') }}
                                    </span>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <!-- Fallback static events if no events in database -->
                        <!-- Event Card 1 -->
                        <div class="bg-gray-50 p-8 rounded-sm shadow-sm transition-all duration-300 hover:shadow-md"
                            data-animate>
                            <div class="mb-4">
                                <span class="inline-block bg-black text-white text-sm px-3 py-1 rounded-sm">June 24,
                                    2023</span>
                            </div>
                            <h3 class="text-xl font-bold mb-3">Jazz Night with Elena Marin Quartet</h3>
                            <p class="text-gray-600 mb-4">
                                Enjoy an evening of sophisticated jazz with the renowned Elena Marin Quartet. The perfect
                                backdrop to our special dinner menu featuring Mediterranean fusion dishes.
                            </p>
                            <div class="flex items-center text-sm text-gray-500">
                                <span class="flex items-center mr-4">
                                    <i class="far fa-clock mr-2"></i> 7:00 PM - 10:00 PM
                                </span>
                            </div>
                        </div>

                        <!-- Event Card 2 -->
                        <div class="bg-gray-50 p-8 rounded-sm shadow-sm transition-all duration-300 hover:shadow-md"
                            data-animate>
                            <div class="mb-4">
                                <span class="inline-block bg-black text-white text-sm px-3 py-1 rounded-sm">July 8,
                                    2023</span>
                            </div>
                            <h3 class="text-xl font-bold mb-3">Lebanese Wine Tasting Evening</h3>
                            <p class="text-gray-600 mb-4">
                                Discover the rich flavors of Lebanese wines with our sommelier-guided tasting event. Sample
                                five
                                premium wines paired with specially crafted appetizers.
                            </p>
                            <div class="flex items-center text-sm text-gray-500">
                                <span class="flex items-center mr-4">
                                    <i class="far fa-clock mr-2"></i> 6:30 PM - 9:00 PM
                                </span>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </section>

        <!-- Private Events Section with real image -->
        <section class="py-20 bg-gray-50">
            <div class="container mx-auto px-4">
                <div class="flex flex-col md:flex-row items-center gap-12">
                    <div class="md:w-1/2" data-animate>
                        <img src="https://images.unsplash.com/photo-1519671482749-fd09be7ccebf?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=2070&q=80"
                            alt="Private Events at Casa de Familia" class="w-full h-auto shadow-xl rounded-sm">
                    </div>
                    <div class="md:w-1/2" data-animate>
                        <h2 class="text-3xl md:text-4xl font-bold mb-6">Host Your Private Event</h2>
                        <div class="w-20 h-1 bg-black mb-6"></div>
                        <p class="text-gray-700 mb-6 leading-relaxed">
                            Casa de Familia offers elegant spaces for private events of all kinds, from intimate gatherings
                            to grand celebrations. Our dedicated events team will work with you to create a memorable
                            experience tailored to your needs.
                        </p>
                        <p class="text-gray-700 mb-8 leading-relaxed">
                            Whether you're planning a wedding reception, corporate event, birthday celebration, or family
                            gathering, our stunning mountain venue provides the perfect backdrop for your special occasion.
                        </p>
                        <a href="{{ route('contact') }}"
                            class="inline-block bg-black text-white px-8 py-3 rounded-sm hover:bg-gray-800 transition-colors font-medium">
                            Inquire About Events
                        </a>
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection

@section('scripts')
    <script src="{{ asset('js/web/main.js') }}"></script>
@endsection
