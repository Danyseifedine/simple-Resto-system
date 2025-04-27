@extends('web.layout.layout')

@section('content')
    <main>
        <!-- Updated Hero Section with real image and reduced height -->
        <section class="hero-section relative flex items-center justify-center"
            style="background-image: url('https://images.unsplash.com/photo-1600565193348-f74bd3c7ccdf?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=2070&q=80'); height: 50vh;">
            <div class="absolute inset-0 bg-black bg-opacity-60"></div>
            <div class="container mx-auto px-4 z-10 text-center">
                <h1 class="text-4xl md:text-6xl font-bold text-white mb-6 text-shadow" data-animate>
                    Frequently Asked Questions
                </h1>
                <p class="text-xl md:text-2xl text-white mb-8 max-w-3xl mx-auto text-shadow" data-animate>
                    Everything you need to know about Casa de Familia
                </p>
            </div>
        </section>

        <!-- FAQ Categories -->
        <section class="py-20 bg-white">
            <div class="container mx-auto px-4">
                <div class="flex flex-wrap justify-center gap-4 mb-16" data-animate>
                    <button class="faq-tab active px-6 py-2 border-b-2 border-black font-medium" data-category="all">
                        All Questions
                    </button>
                    <button class="faq-tab px-6 py-2 border-b-2 border-transparent hover:border-gray-300 font-medium"
                        data-category="reservations">
                        Reservations
                    </button>
                    <button class="faq-tab px-6 py-2 border-b-2 border-transparent hover:border-gray-300 font-medium"
                        data-category="menu">
                        Menu & Dining
                    </button>
                    <button class="faq-tab px-6 py-2 border-b-2 border-transparent hover:border-gray-300 font-medium"
                        data-category="events">
                        Events
                    </button>
                    <button class="faq-tab px-6 py-2 border-b-2 border-transparent hover:border-gray-300 font-medium"
                        data-category="location">
                        Location & Hours
                    </button>
                </div>

                <!-- FAQ Accordion -->
                <div class="max-w-3xl mx-auto" id="faq-content">
                    <!-- Reservations FAQs -->
                    <div class="faq-section mb-8" data-category="reservations">
                        <h2 class="text-2xl font-bold mb-6">Reservations</h2>

                        <!-- FAQ Item -->
                        <div class="faq-item mb-4 border-b border-gray-200 pb-4">
                            <button
                                class="faq-question w-full flex justify-between items-center text-left font-medium focus:outline-none">
                                <span>Do I need a reservation?</span>
                                <i class="fas fa-plus text-sm transition-transform duration-300"></i>
                            </button>
                            <div class="faq-answer hidden mt-4 text-gray-600">
                                <p>While walk-ins are welcome, we highly recommend making a reservation, especially for
                                    dinner service and weekends. This ensures we can provide you with the best possible
                                    dining experience and seating preference.</p>
                            </div>
                        </div>

                        <!-- FAQ Item -->
                        <div class="faq-item mb-4 border-b border-gray-200 pb-4">
                            <button
                                class="faq-question w-full flex justify-between items-center text-left font-medium focus:outline-none">
                                <span>How can I make a reservation?</span>
                                <i class="fas fa-plus text-sm transition-transform duration-300"></i>
                            </button>
                            <div class="faq-answer hidden mt-4 text-gray-600">
                                <p>Reservations can be made by phone at +961 1 234 567, through our website's contact form,
                                    or via email at reservations@casadefamilia.com. Please provide your name, contact
                                    information, preferred date and time, and the number of guests in your party.</p>
                            </div>
                        </div>

                        <!-- FAQ Item -->
                        <div class="faq-item mb-4 border-b border-gray-200 pb-4">
                            <button
                                class="faq-question w-full flex justify-between items-center text-left font-medium focus:outline-none">
                                <span>What is your cancellation policy?</span>
                                <i class="fas fa-plus text-sm transition-transform duration-300"></i>
                            </button>
                            <div class="faq-answer hidden mt-4 text-gray-600">
                                <p>We appreciate at least 24 hours' notice for cancellations or changes to your reservation.
                                    For groups of 6 or more, we require 48 hours' notice. This allows us to accommodate
                                    other guests who may be waiting for a table.</p>
                            </div>
                        </div>
                    </div>

                    <!-- Menu & Dining FAQs -->
                    <div class="faq-section mb-8" data-category="menu">
                        <h2 class="text-2xl font-bold mb-6">Menu & Dining</h2>

                        <!-- FAQ Item -->
                        <div class="faq-item mb-4 border-b border-gray-200 pb-4">
                            <button
                                class="faq-question w-full flex justify-between items-center text-left font-medium focus:outline-none">
                                <span>Do you accommodate dietary restrictions?</span>
                                <i class="fas fa-plus text-sm transition-transform duration-300"></i>
                            </button>
                            <div class="faq-answer hidden mt-4 text-gray-600">
                                <p>Yes, we are happy to accommodate various dietary needs including vegetarian, vegan,
                                    gluten-free, and allergies. Please inform us of any dietary restrictions when making
                                    your reservation, and our chefs will prepare suitable options for you.</p>
                            </div>
                        </div>

                        <!-- FAQ Item -->
                        <div class="faq-item mb-4 border-b border-gray-200 pb-4">
                            <button
                                class="faq-question w-full flex justify-between items-center text-left font-medium focus:outline-none">
                                <span>Does your menu change seasonally?</span>
                                <i class="fas fa-plus text-sm transition-transform duration-300"></i>
                            </button>
                            <div class="faq-answer hidden mt-4 text-gray-600">
                                <p>Yes, while we maintain our signature dishes year-round, we also offer seasonal specials
                                    that highlight the freshest local ingredients available. Our chef creates new dishes
                                    based on what's in season to provide the best dining experience.</p>
                            </div>
                        </div>

                        <!-- FAQ Item -->
                        <div class="faq-item mb-4 border-b border-gray-200 pb-4">
                            <button
                                class="faq-question w-full flex justify-between items-center text-left font-medium focus:outline-none">
                                <span>Do you have a dress code?</span>
                                <i class="fas fa-plus text-sm transition-transform duration-300"></i>
                            </button>
                            <div class="faq-answer hidden mt-4 text-gray-600">
                                <p>We suggest smart casual attire. While we don't enforce a strict dress code, we appreciate
                                    guests dressing appropriately for an upscale dining experience. We ask that guests
                                    refrain from wearing beachwear, athletic attire, or flip-flops in the evening.</p>
                            </div>
                        </div>
                    </div>

                    <!-- Events FAQs -->
                    <div class="faq-section mb-8" data-category="events">
                        <h2 class="text-2xl font-bold mb-6">Events</h2>

                        <!-- FAQ Item -->
                        <div class="faq-item mb-4 border-b border-gray-200 pb-4">
                            <button
                                class="faq-question w-full flex justify-between items-center text-left font-medium focus:outline-none">
                                <span>Can I host a private event at Casa de Familia?</span>
                                <i class="fas fa-plus text-sm transition-transform duration-300"></i>
                            </button>
                            <div class="faq-answer hidden mt-4 text-gray-600">
                                <p>Yes, we offer private event spaces for various occasions including weddings, corporate
                                    events, birthdays, and family celebrations. Our events team will work with you to create
                                    a customized experience that meets your specific needs and preferences.</p>
                            </div>
                        </div>

                        <!-- FAQ Item -->
                        <div class="faq-item mb-4 border-b border-gray-200 pb-4">
                            <button
                                class="faq-question w-full flex justify-between items-center text-left font-medium focus:outline-none">
                                <span>What types of live music do you feature?</span>
                                <i class="fas fa-plus text-sm transition-transform duration-300"></i>
                            </button>
                            <div class="faq-answer hidden mt-4 text-gray-600">
                                <p>We feature a variety of musical styles including jazz, acoustic, and traditional Lebanese
                                    music. Our live music events typically take place on Friday and Saturday evenings. Check
                                    our Events page for the current schedule and featured artists.</p>
                            </div>
                        </div>

                        <!-- FAQ Item -->
                        <div class="faq-item mb-4 border-b border-gray-200 pb-4">
                            <button
                                class="faq-question w-full flex justify-between items-center text-left font-medium focus:outline-none">
                                <span>Do you offer catering services?</span>
                                <i class="fas fa-plus text-sm transition-transform duration-300"></i>
                            </button>
                            <div class="faq-answer hidden mt-4 text-gray-600">
                                <p>Yes, we offer catering services for events both at our venue and at external locations.
                                    Our catering menu can be customized to suit your event's needs, from casual buffets to
                                    elegant plated dinners. Please contact our events team for more information.</p>
                            </div>
                        </div>
                    </div>

                    <!-- Location & Hours FAQs -->
                    <div class="faq-section mb-8" data-category="location">
                        <h2 class="text-2xl font-bold mb-6">Location & Hours</h2>

                        <!-- FAQ Item -->
                        <div class="faq-item mb-4 border-b border-gray-200 pb-4">
                            <button
                                class="faq-question w-full flex justify-between items-center text-left font-medium focus:outline-none">
                                <span>Where exactly is Casa de Familia located?</span>
                                <i class="fas fa-plus text-sm transition-transform duration-300"></i>
                            </button>
                            <div class="faq-answer hidden mt-4 text-gray-600">
                                <p>Casa de Familia is located on Falougha Mountain Road, Lebanon. Our restaurant offers
                                    panoramic views of the surrounding mountains and valleys. Detailed directions can be
                                    found on our Contact page.</p>
                            </div>
                        </div>

                        <!-- FAQ Item -->
                        <div class="faq-item mb-4 border-b border-gray-200 pb-4">
                            <button
                                class="faq-question w-full flex justify-between items-center text-left font-medium focus:outline-none">
                                <span>Is there parking available?</span>
                                <i class="fas fa-plus text-sm transition-transform duration-300"></i>
                            </button>
                            <div class="faq-answer hidden mt-4 text-gray-600">
                                <p>Yes, we offer complimentary valet parking for all our guests. Our parking area is secure
                                    and well-lit. During peak hours and special events, we recommend arriving a bit earlier
                                    to ensure smooth service.</p>
                            </div>
                        </div>

                        <!-- FAQ Item -->
                        <div class="faq-item mb-4 border-b border-gray-200 pb-4">
                            <button
                                class="faq-question w-full flex justify-between items-center text-left font-medium focus:outline-none">
                                <span>Are you open year-round?</span>
                                <i class="fas fa-plus text-sm transition-transform duration-300"></i>
                            </button>
                            <div class="faq-answer hidden mt-4 text-gray-600">
                                <p>Yes, we are open year-round. During winter months, our indoor dining areas feature cozy
                                    fireplaces, while in summer, our terrace offers al fresco dining with mountain breezes.
                                    Our hours remain consistent throughout the year, but we may have special holiday hours
                                    which will be posted on our website.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Still Have Questions -->
                <div class="mt-16 text-center" data-animate>
                    <h2 class="text-2xl font-bold mb-4">Still Have Questions?</h2>
                    <p class="text-gray-600 mb-8 max-w-2xl mx-auto">
                        If you couldn't find the answer to your question, please don't hesitate to contact us directly. Our
                        team is always happy to help.
                    </p>
                    <a href="contact.html"
                        class="inline-block bg-black text-white px-8 py-3 rounded-sm hover:bg-gray-800 transition-colors font-medium">
                        Contact Us
                    </a>
                </div>
            </div>
        </section>
    </main>
@endsection


@section('scripts')
    <script src="{{ asset('js/web/faq.js') }}"></script>
    <script src="{{ asset('js/web/main.js') }}"></script>
@endsection