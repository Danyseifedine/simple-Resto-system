@extends('web.layout.layout')

@section('styles')
    <style>
        .nav-link {
            position: relative;
            padding-bottom: 4px;
        }

        .nav-link::after {
            content: '';
            position: absolute;
            width: 0;
            height: 2px;
            bottom: 0;
            left: 0;
            background-color: white;
            transition: width 0.3s ease;
        }

        .nav-link:hover::after {
            width: 100%;
        }

        /* Enhanced buttons */
        .btn-primary {
            position: relative;
            overflow: hidden;
            transition: all 0.3s ease;
            z-index: 1;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .btn-primary::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: rgba(255, 255, 255, 0.1);
            transition: all 0.4s ease;
            z-index: -1;
        }

        .btn-primary:hover::before {
            left: 0;
        }

        .btn-secondary {
            position: relative;
            overflow: hidden;
            transition: all 0.3s ease;
            z-index: 1;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .btn-secondary::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.1);
            transition: all 0.4s ease;
            z-index: -1;
        }

        .btn-secondary:hover::before {
            left: 0;
        }

        /* Enhanced hero section styles */
        .hero-section {
            position: relative;
            background-position: center;
            background-size: cover;
        }

        .hero-overlay {
            background: linear-gradient(to right, rgba(0, 0, 0, 0.8) 0%, rgba(0, 0, 0, 0.6) 100%);
            position: absolute;
            inset: 0;
        }

        .hero-title {
            font-family: 'Playfair Display', serif;
            font-size: 5.5rem;
            line-height: 1.1;
            letter-spacing: 2px;
            text-transform: uppercase;
            font-weight: 700;
            margin-bottom: 2rem;
            background: white;
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
            position: relative;
        }


        .hero-subtitle {
            font-family: 'Poppins', sans-serif;
            font-size: 1.5rem;
            font-weight: 300;
            letter-spacing: 1px;
            line-height: 1.6;
            color: #ffffff;
            max-width: 800px;
            margin: 0 auto 2.5rem auto;
            text-shadow: 1px 1px 3px rgba(0, 0, 0, 0.5);
        }

        .hero-content {
            position: relative;
            z-index: 10;
        }

        .hero-button-group {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 20px;
        }

        .hero-btn {
            position: relative;
            overflow: hidden;
            padding: 16px 32px;
            border-radius: 2px;
            font-weight: 500;
            letter-spacing: 1px;
            text-transform: uppercase;
            transition: all 0.3s ease;
            z-index: 1;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        }

        .hero-primary-btn {
            background: white;
            color: #111;
            border: none;
        }

        .hero-primary-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.25);
        }

        .hero-secondary-btn {
            background: transparent;
            color: #fff;
            border: 2px solid #ffffff;
        }

        .hero-secondary-btn:hover {
            background-color: rgba(255, 255, 255, 0.1);
            transform: translateY(-3px);
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.25);
        }

        @media (max-width: 768px) {
            .hero-title {
                font-size: 3.5rem;
            }

            .hero-subtitle {
                font-size: 1.25rem;
                padding: 0 20px;
            }

            .hero-button-group {
                flex-direction: column;
                align-items: center;
            }

        }

        .hero-title {
            font-family: 'Playfair Display', serif;
            font-size: clamp(2rem, 8vw, 5.5rem);
            line-height: 1.1;
            letter-spacing: 2px;
            text-transform: uppercase;
            font-weight: 700;
            margin-bottom: 2rem;
            padding: 0 1rem;
            background: white;
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
            position: relative;
        }

        .hero-subtitle {
            font-family: 'Poppins', sans-serif;
            font-size: clamp(1rem, 3vw, 1.5rem);
            font-weight: 300;
            letter-spacing: 1px;
            line-height: 1.6;
            color: #ffffff;
            max-width: 800px;
            margin: 0 auto 2.5rem auto;
            padding: 0 1rem;
            text-shadow: 1px 1px 3px rgba(0, 0, 0, 0.5);
        }

        @media (max-width: 768px) {
            .hero-title {
                font-size: clamp(2rem, 6vw, 3.5rem);
                padding: 0 1rem;
            }

            .hero-subtitle {
                font-size: clamp(1rem, 2.5vw, 1.25rem);
                padding: 0 1.5rem;
            }

            .hero-button-group {
                flex-direction: column;
                align-items: center;
                padding: 0 1rem;
            }
        }

        @media (max-width: 480px) {
            .hero-title {
                font-size: clamp(1.75rem, 5vw, 2.5rem);
                padding: 0 0.75rem;
            }

            .hero-subtitle {
                font-size: clamp(0.875rem, 2vw, 1rem);
                padding: 0 1rem;
            }
        }
    </style>
@endsection

@section('content')
    <!-- Main Content -->
    <main>
        <!-- Enhanced Hero Section -->
        <section class="hero-section relative flex items-center justify-center"
            style="background-image: url('/images/hero.jpg'); height: 100vh;">
            <!-- Background overlay with gradient -->
            <div class="hero-overlay"></div>

            <!-- Main content -->
            <div class="container mx-auto px-4 z-10 text-center hero-content">
                <h1 class="hero-title">
                    Each Family has a Story… Welcome to Ours
                </h1>

                <p class="hero-subtitle">
                    Experience extraordinary mountain dining with breathtaking panoramic views of Falougha's majestic
                    landscape
                </p>

                <div class="hero-button-group">
                    @if (auth()->check())
                        <a href="{{ route('menu') }}" class="hero-btn hero-primary-btn">
                            Explore Our Menu
                        </a>
                    @endif
                    <a href="{{ route('contact') }}" class="hero-btn hero-secondary-btn">
                        Make a Reservation
                    </a>
                </div>
            </div>
        </section>

        <!-- Welcome Section -->
        <section class="py-20 bg-white">
            <div class="container mx-auto px-4">
                <div class="flex flex-col md:flex-row items-center gap-12">
                    <div class="md:w-1/2" data-animate>
                        <img src="https://images.unsplash.com/photo-1555396273-367ea4eb4db5?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1974&q=80"
                            alt="Casa de Familia Interior" class="w-full h-auto shadow-xl rounded-sm">
                    </div>
                    <div class="md:w-1/2" data-animate>
                        <h2 class="text-3xl md:text-4xl font-bold mb-6">Welcome to Casa de Familia</h2>
                        <div class="w-20 h-1 bg-black mb-6"></div>
                        <p class="text-gray-700 mb-6 leading-relaxed">
                            Nestled in the mountains of Falougha, Casa de Familia offers an elegant dining experience with
                            breathtaking panoramic views. Our restaurant combines traditional Lebanese flavors with modern
                            culinary techniques to create unforgettable dishes.
                        </p>
                        <p class="text-gray-700 mb-8 leading-relaxed">
                            Whether you're joining us for a romantic dinner, family celebration, or special event, our
                            dedicated team ensures every visit is exceptional. Enjoy the serene mountain atmosphere while
                            savoring our carefully crafted menu featuring locally sourced ingredients.
                        </p>
                        <a href="{{ route('about') }}"
                            class="inline-block bg-black text-white px-6 py-3 rounded-sm hover:bg-gray-800 transition-colors font-medium">
                            Our Story
                        </a>
                    </div>
                </div>
            </div>
        </section>

        @if (auth()->check())
            <!-- Featured Events Section -->
            <section class="py-20 bg-black text-white">
                <div class="container mx-auto px-4">
                    <div class="text-center mb-16" data-animate>
                        <h2 class="text-3xl md:text-4xl font-bold mb-6">Upcoming Events</h2>
                        <div class="w-20 h-1 bg-white mx-auto mb-6"></div>
                        <p class="max-w-2xl mx-auto text-gray-300">
                            Experience the perfect blend of exquisite cuisine and live entertainment at Casa de Familia.
                        </p>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                        <!-- Event Card 1 -->
                        <div class="bg-gray-900 p-6 rounded-sm transition-transform hover:-translate-y-2 duration-300"
                            data-animate>
                            <div class="mb-4">
                                <span class="text-sm font-medium bg-white text-black px-3 py-1 rounded-sm">THIS
                                    FRIDAY</span>
                            </div>
                            <h3 class="text-xl font-bold mb-2">Live Jazz Night</h3>
                            <p class="text-gray-400 mb-4">Join us for an evening of smooth jazz and delicious cuisine under
                                the
                                stars.</p>
                            <div class="flex items-center text-gray-300 text-sm mb-6">
                                <span class="mr-4"><i class="far fa-calendar mr-2"></i> June 24, 2023</span>
                                <span><i class="far fa-clock mr-2"></i> 8:00 PM</span>
                            </div>
                        </div>

                        <!-- Event Card 2 -->
                        <div class="bg-gray-900 p-6 rounded-sm transition-transform hover:-translate-y-2 duration-300"
                            data-animate>
                            <div class="mb-4">
                                <span class="text-sm font-medium bg-white text-black px-3 py-1 rounded-sm">NEXT WEEK</span>
                            </div>
                            <h3 class="text-xl font-bold mb-2">Wine Tasting Evening</h3>
                            <p class="text-gray-400 mb-4">Sample our exclusive selection of local and international wines
                                paired
                                with gourmet appetizers.</p>
                            <div class="flex items-center text-gray-300 text-sm mb-6">
                                <span class="mr-4"><i class="far fa-calendar mr-2"></i> July 2, 2023</span>
                                <span><i class="far fa-clock mr-2"></i> 7:00 PM</span>
                            </div>

                        </div>

                        <!-- Event Card 3 -->
                        <div class="bg-gray-900 p-6 rounded-sm transition-transform hover:-translate-y-2 duration-300"
                            data-animate>
                            <div class="mb-4">
                                <span class="text-sm font-medium bg-white text-black px-3 py-1 rounded-sm">SPECIAL
                                    EVENT</span>
                            </div>
                            <h3 class="text-xl font-bold mb-2">Chef's Special Dinner</h3>
                            <p class="text-gray-400 mb-4">A five-course tasting menu showcasing our chef's innovative
                                culinary
                                creations.</p>
                            <div class="flex items-center text-gray-300 text-sm mb-6">
                                <span class="mr-4"><i class="far fa-calendar mr-2"></i> July 15, 2023</span>
                                <span><i class="far fa-clock mr-2"></i> 6:30 PM</span>
                            </div>

                        </div>
                    </div>

                    <div class="text-center mt-12" data-animate>
                        <a href="events.html"
                            class="inline-block border-2 border-white text-white px-8 py-3 rounded-sm hover:bg-white hover:text-black transition-colors font-medium">
                            View All Events
                        </a>
                    </div>
                </div>
            </section>
        @endif

        <!-- Newsletter Section -->
        <section class="py-20 bg-white">
            <div class="container mx-auto px-4">
                <div class="max-w-3xl mx-auto text-center" data-animate>
                    <h2 class="text-3xl md:text-4xl font-bold mb-6">Stay Updated</h2>
                    <div class="w-20 h-1 bg-black mx-auto mb-6"></div>
                    <p class="text-gray-700 mb-8">
                        Subscribe to our newsletter to receive updates on special events, seasonal menus, and exclusive
                        offers.
                    </p>
                    <form form-id="newsletter-form" on-success="handleFormSuccess" http-request
                        route="{{ route('newsletter.store') }}" identifier="single-form-post-handler"
                        serialize-as="formdata" feedback class="flex flex-col sm:flex-row gap-4 max-w-lg mx-auto">
                        <input type="email" placeholder="Your email address" name="email" feedback-id="email-feedback"
                            class="flex-grow px-4 py-3 border border-gray-300 focus:border-black focus:outline-none">
                        <button type="submit" submit-form-id="newsletter-form"
                            class="bg-black text-white px-6 py-3 font-medium hover:bg-gray-800 transition-colors">
                            Subscribe
                        </button>
                    </form>
                    <div id="email-feedback" class="invalid-feedback text-red-500"></div>
                </div>
            </div>
        </section>
    </main>
@endsection

@section('scripts')
    <script src="{{ asset('js/web/main.js') }}"></script>
    <script>
        window.handleFormSuccess = function(data, form, button) {
            console.log(button)
            console.log(form)
            console.log(data)
            // Create toast element
            const toast = document.createElement('div');
            console.log(toast)
            toast.className = 'success-toast';
            toast.innerHTML = 'Your account has been added to newsletter';

            // Style the toast
            toast.style.position = 'fixed';
            toast.style.bottom = '20px';
            toast.style.right = '20px';
            toast.style.backgroundColor = '#4CAF50';
            toast.style.color = 'white';
            toast.style.padding = '15px 25px';
            toast.style.borderRadius = '4px';
            toast.style.boxShadow = '0 2px 10px rgba(0,0,0,0.2)';
            toast.style.zIndex = '9999';
            toast.style.opacity = '0';
            toast.style.transition = 'opacity 0.3s ease-in-out';

            // Add to document
            document.body.appendChild(toast);

            // Show the toast with animation
            setTimeout(() => {
                toast.style.opacity = '1';
            }, 100);

            // Hide and remove toast after 5 seconds
            setTimeout(() => {
                toast.style.opacity = '0';
                setTimeout(() => {
                    document.body.removeChild(toast);
                }, 300); // Wait for fade-out animation to complete
            }, 5000);
        };
        // Header background change on scroll
        window.addEventListener('scroll', function() {
            const header = document.getElementById('header');
            if (window.scrollY > 50) {
                header.classList.add('bg-black');
                header.classList.remove('bg-transparent');
            } else {
                header.classList.add('bg-transparent');
                header.classList.remove('bg-black');
            }
        });

        document.addEventListener('DOMContentLoaded', function() {
            const mobileMenuButton = document.getElementById('mobile-menu-button');
            const mobileMenu = document.getElementById('mobile-menu');

            mobileMenuButton.addEventListener('click', function() {
                mobileMenu.classList.toggle('hidden');
            });
        });
    </script>
@endsection
