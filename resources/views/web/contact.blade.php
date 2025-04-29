@extends('web.layout.layout')

@section('styles')
    <style>
        .font-serif {
            font-family: 'Playfair Display', serif;
        }

        .font-sans {
            font-family: 'Poppins', sans-serif;
        }

        .text-shadow {
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
        }

        .transition-transform {
            transition: transform 0.3s ease;
        }

        .hover-lift:hover {
            transform: translateY(-5px);
        }

        .contact-input:focus {
            border-color: #000;
            box-shadow: 0 0 0 2px rgba(0, 0, 0, 0.1);
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        [data-animate] {
            animation: fadeInUp 0.6s ease forwards;
        }

        .contact-card {
            transition: all 0.3s ease;
        }

        .contact-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        }
    </style>
@endsection

@section('content')
    <!-- Contact Page Content -->
    <main>
        <!-- Hero Section (Untouched as requested) -->
        <section class="hero-section relative flex items-center justify-center"
            style="background-image: url('https://images.unsplash.com/photo-1414235077428-338989a2e8c0?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=2070&q=80'); height: 50vh;">
            <div class="absolute inset-0 bg-black bg-opacity-60"></div>
            <div class="container mx-auto px-4 z-10 text-center">
                <h1 class="text-4xl md:text-6xl font-bold text-white mb-6 text-shadow" data-animate>
                    Contact Us
                </h1>
                <p class="text-xl md:text-2xl text-white mb-8 max-w-3xl mx-auto text-shadow" data-animate>
                    We'd love to hear from you
                </p>
            </div>
        </section>

        <!-- Contact Information -->
        <section class="py-20 bg-gray-50">
            <div class="container mx-auto px-4">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-16">
                    <!-- Contact Card 1 -->
                    <div class="bg-white p-8 rounded-lg text-center shadow-lg contact-card" data-animate
                        style="animation-delay: 0.1s;">
                        <div
                            class="w-16 h-16 bg-black rounded-full flex items-center justify-center mx-auto mb-6 shadow-md">
                            <i class="fas fa-map-marker-alt text-white text-2xl"></i>
                        </div>
                        <h3 class="text-xl font-bold mb-4 font-serif">Our Location</h3>
                        <p class="text-gray-600">
                            Casa de Familia<br>
                            Falougha Mountain Road<br>
                            Lebanon
                        </p>
                    </div>

                    <!-- Contact Card 2 -->
                    <div class="bg-white p-8 rounded-lg text-center shadow-lg contact-card" data-animate
                        style="animation-delay: 0.2s;">
                        <div
                            class="w-16 h-16 bg-black rounded-full flex items-center justify-center mx-auto mb-6 shadow-md">
                            <i class="fas fa-phone-alt text-white text-2xl"></i>
                        </div>
                        <h3 class="text-xl font-bold mb-4 font-serif">Phone & Email</h3>
                        <p class="text-gray-600 mb-2">
                            +961 1 234 567
                        </p>
                        <p class="text-gray-600">
                            <a href="mailto:info@casadefamilia.com"
                                class="hover:text-black transition-colors">info@casadefamilia.com</a>
                        </p>
                    </div>

                    <!-- Contact Card 3 -->
                    <div class="bg-white p-8 rounded-lg text-center shadow-lg contact-card" data-animate
                        style="animation-delay: 0.3s;">
                        <div
                            class="w-16 h-16 bg-black rounded-full flex items-center justify-center mx-auto mb-6 shadow-md">
                            <i class="fas fa-clock text-white text-2xl"></i>
                        </div>
                        <h3 class="text-xl font-bold mb-4 font-serif">Opening Hours</h3>
                        <p class="text-gray-600 mb-2">
                            Monday - Thursday: 12:00 - 22:00
                        </p>
                        <p class="text-gray-600 mb-2">
                            Friday - Saturday: 12:00 - 23:00
                        </p>
                        <p class="text-gray-600">
                            Sunday: 12:00 - 21:00
                        </p>
                    </div>
                </div>

                <div class="flex flex-col lg:flex-row gap-12 bg-white p-10 rounded-lg shadow-lg">
                    <!-- Contact Form -->
                    <div class="lg:w-1/2" data-animate style="animation-delay: 0.4s;">
                        <h2 class="text-3xl font-bold mb-6 font-serif">Send Us a Message</h2>
                        <div class="w-20 h-1 bg-black mb-6"></div>
                        <p class="text-gray-600 mb-8">
                            Whether you have a question about our menu, want to make a reservation, or are interested in
                            hosting an event, we're here to help.
                        </p>
                        <form class="space-y-6" form-id="unique-form-id" http-request route="{{ route('contact.store') }}"
                            identifier="single-form-post-handler" serialize-as="formdata" feedback
                            on-success="handleFormSuccess">
                            <div>
                                <label for="subject" class="block text-gray-700 mb-2 font-medium">Subject</label>
                                <input type="text" id="subject" name="subject" feedback-id="subject-feedback"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-md focus:outline-none contact-input transition-all duration-300"
                                    placeholder="Reservation Request">
                                <div id="subject-feedback" class="invalid-feedback text-red-500"></div>
                            </div>
                            <div>
                                <label for="message" class="block text-gray-700 mb-2 font-medium">Your Message</label>
                                <textarea id="message" rows="5" name="message" feedback-id="message-feedback"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-md focus:outline-none contact-input transition-all duration-300"
                                    placeholder="Tell us about your inquiry..."></textarea>
                                <div id="message-feedback" class="invalid-feedback text-red-500"></div>
                            </div>
                            <button type="submit" submit-form-id="unique-form-id"
                                class="bg-black text-white px-8 py-3 rounded-md hover:bg-gray-800 transition-all duration-300 font-medium hover:shadow-lg transform hover:scale-105">
                                Send Message <i class="fas fa-paper-plane ml-2"></i>
                            </button>
                        </form>
                    </div>

                    <!-- Map -->
                    <div class="lg:w-1/2" data-animate style="animation-delay: 0.5s;">
                        <h2 class="text-3xl font-bold mb-6 font-serif">Find Us</h2>
                        <div class="w-20 h-1 bg-black mb-6"></div>
                        <p class="text-gray-600 mb-8">
                            Located in the scenic mountains of Falougha, Casa de Familia offers breathtaking views and a
                            peaceful escape from the city.
                        </p>
                        <div class="h-96 rounded-md overflow-hidden shadow-lg">
                            <!-- Replace with actual Google Maps embed code -->
                            <iframe
                                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d13249.978693031444!2d35.75!3d33.85!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x151f17215880a78f%3A0x729182bae99b7405!2sFalougha%2C%20Lebanon!5e0!3m2!1sen!2sus!4v1623456789012!5m2!1sen!2sus"
                                width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Reservation CTA -->
        <section class="py-20 bg-black text-white relative overflow-hidden"
            style="background-image: url('https://images.unsplash.com/photo-1579027989536-b7b1f875659b?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=2070&q=80'); background-size: cover; background-position: center;">
            >
            <div class="absolute inset-0 bg-black opacity-80"></div>
            <div class="container mx-auto px-4 text-center relative z-10">
                <h2 class="text-3xl md:text-4xl font-bold mb-6 font-serif" data-animate>Ready to Experience Casa de Familia?
                </h2>
                <div class="w-20 h-1 bg-white mx-auto mb-6"></div>
                <p class="max-w-2xl mx-auto text-gray-300 mb-8" data-animate>
                    Make a reservation today and enjoy an unforgettable dining experience in the mountains of Falougha.
                </p>
                <div data-animate>
                    <a href="tel:+9611234567"
                        class="inline-block border-2 border-white text-white px-8 py-3 rounded-md hover:bg-white hover:text-black transition-all duration-300 font-medium transform hover:scale-105">
                        <i class="fas fa-phone-alt mr-2"></i> Call for Reservations: +961 1 234 567
                    </a>
                </div>
            </div>
        </section>
    </main>
@endsection


@section('scripts')
    <script src="{{ asset('js/web/main.js') }}"></script>

    <script>
        window.handleFormSuccess = function(data, form, button) {
            // Create toast element
            const toast = document.createElement('div');
            console.log(toast)
            toast.className = 'success-toast';
            toast.innerHTML = 'Message sent successfully';

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

        // Mobile menu toggle
        document.getElementById('mobile-menu-btn').addEventListener('click', function() {
            const mobileMenu = document.getElementById('mobile-menu');
            mobileMenu.classList.toggle('hidden');
        });
    </script>
@endsection
