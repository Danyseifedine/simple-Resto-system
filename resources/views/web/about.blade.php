@extends('web.layout.layout')

@section('content')
    <main>
        <!-- Updated Hero Section with real image and reduced height -->
        <section class="hero-section relative flex items-center justify-center"
            style="background-image: url('https://images.unsplash.com/photo-1559339352-11d035aa65de?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=2074&q=80'); height: 50vh;">
            <div class="absolute inset-0 bg-black bg-opacity-60"></div>
            <div class="container mx-auto px-4 z-10 text-center">
                <h1 class="text-4xl md:text-6xl font-bold text-white mb-6 text-shadow" data-animate>
                    Our Story
                </h1>
                <p class="text-xl md:text-2xl text-white mb-8 max-w-3xl mx-auto text-shadow" data-animate>
                    The journey behind Casa de Familia
                </p>
            </div>
        </section>

        <!-- Our History with real image -->
        <section class="py-20 bg-white">
            <div class="container mx-auto px-4">
                <div class="flex flex-col md:flex-row items-center gap-12">
                    <div class="md:w-1/2" data-animate>
                        <img src="https://images.unsplash.com/photo-1514933651103-005eec06c04b?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1974&q=80"
                            alt="Casa de Familia History" class="w-full h-auto shadow-xl rounded-sm">
                    </div>
                    <div class="md:w-1/2" data-animate>
                        <h2 class="text-3xl md:text-4xl font-bold mb-6">Our History</h2>
                        <div class="w-20 h-1 bg-black mb-6"></div>
                        <p class="text-gray-700 mb-6 leading-relaxed">
                            Casa de Familia was founded in 1985 by the Khoury family, who sought to bring the rich culinary
                            traditions of Lebanon to the serene mountains of Falougha. What began as a small family
                            restaurant has evolved into one of the region's most celebrated dining destinations.
                        </p>
                        <p class="text-gray-700 mb-6 leading-relaxed">
                            For over three decades, we have remained true to our roots while embracing innovation. Our
                            recipes have been passed down through generations, preserving authentic flavors while
                            incorporating contemporary techniques.
                        </p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Our Philosophy with real image -->
        <section class="py-20 bg-gray-50">
            <div class="container mx-auto px-4">
                <div class="flex flex-col md:flex-row-reverse items-center gap-12">
                    <div class="md:w-1/2" data-animate>
                        <img src="https://images.unsplash.com/photo-1556911220-e15b29be8c8f?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=2070&q=80"
                            alt="Our Philosophy" class="w-full h-auto shadow-xl rounded-sm">
                    </div>
                    <div class="md:w-1/2" data-animate>
                        <h2 class="text-3xl md:text-4xl font-bold mb-6">Our Philosophy</h2>
                        <div class="w-20 h-1 bg-black mb-6"></div>
                        <p class="text-gray-700 mb-6 leading-relaxed">
                            At Casa de Familia, we believe that exceptional dining is about more than just food—it's about
                            creating memorable experiences. Our philosophy centers on three core principles: quality
                            ingredients, authentic flavors, and warm hospitality.
                        </p>
                        <p class="text-gray-700 mb-6 leading-relaxed">
                            We source the finest local and imported ingredients, working closely with farmers and producers
                            who share our commitment to quality. Our chefs honor traditional Lebanese cooking methods while
                            adding their own creative touches to each dish.
                        </p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Testimonials with real images -->
        <section class="py-20 bg-gray-900 text-white">
            <div class="container mx-auto px-4">
                <div class="text-center mb-16" data-animate>
                    <h2 class="text-3xl md:text-4xl font-bold mb-6">What Our Guests Say</h2>
                    <div class="w-20 h-1 bg-white mx-auto mb-6"></div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <!-- Testimonial 1 -->
                    <div class="bg-gray-800 p-8 rounded-sm" data-animate>
                        <div class="flex justify-center mb-6">
                            <i class="fas fa-quote-left text-3xl text-gray-600"></i>
                        </div>
                        <p class="text-gray-300 mb-6 text-center">
                            "Casa de Familia offers not just a meal, but an unforgettable experience. The food is
                            exceptional, the views are breathtaking, and the staff makes you feel like part of the family."
                        </p>
                        <div class="flex items-center justify-center">
                            <img src="https://images.unsplash.com/photo-1494790108377-be9c29b29330?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1974&q=80"
                                alt="Sarah M." class="w-12 h-12 rounded-full mr-4 object-cover">
                            <div>
                                <h4 class="font-bold">Sarah M.</h4>
                                <p class="text-gray-400 text-sm">Beirut, Lebanon</p>
                            </div>
                        </div>
                    </div>

                    <!-- Testimonial 2 -->
                    <div class="bg-gray-800 p-8 rounded-sm" data-animate>
                        <div class="flex justify-center mb-6">
                            <i class="fas fa-quote-left text-3xl text-gray-600"></i>
                        </div>
                        <p class="text-gray-300 mb-6 text-center">
                            "The perfect escape from the city. We celebrated our anniversary here and it was magical. The
                            mountain setting, the delicious food, and the attentive service made it a night to remember."
                        </p>
                        <div class="flex items-center justify-center">
                            <img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1974&q=80"
                                alt="Robert K." class="w-12 h-12 rounded-full mr-4 object-cover">
                            <div>
                                <h4 class="font-bold">Robert & Julia K.</h4>
                                <p class="text-gray-400 text-sm">Paris, France</p>
                            </div>
                        </div>
                    </div>

                    <!-- Testimonial 3 -->
                    <div class="bg-gray-800 p-8 rounded-sm" data-animate>
                        <div class="flex justify-center mb-6">
                            <i class="fas fa-quote-left text-3xl text-gray-600"></i>
                        </div>
                        <p class="text-gray-300 mb-6 text-center">
                            "As a food critic, I've dined at restaurants worldwide, but Casa de Familia stands out for its
                            authentic flavors, innovative presentation, and genuine hospitality. A true gem in Lebanon."
                        </p>
                        <div class="flex items-center justify-center">
                            <img src="https://images.unsplash.com/photo-1506794778202-cad84cf45f1d?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1974&q=80"
                                alt="Ahmed T." class="w-12 h-12 rounded-full mr-4 object-cover">
                            <div>
                                <h4 class="font-bold">Ahmed T.</h4>
                                <p class="text-gray-400 text-sm">Food Critic, Dubai</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Meet Our Team with real images -->
        <section class="py-20 bg-white">
            <div class="container mx-auto px-4">
                <div class="text-center mb-16" data-animate>
                    <h2 class="text-3xl md:text-4xl font-bold mb-6">Meet Our Team</h2>
                    <div class="w-20 h-1 bg-black mx-auto mb-6"></div>
                    <p class="text-gray-700 max-w-3xl mx-auto">
                        The passionate individuals who bring Casa de Familia to life every day.
                    </p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <!-- Team Member 1 -->
                    <div class="text-center" data-animate>
                        <img src="https://images.unsplash.com/photo-1566554273541-37a9ca77b91f?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1974&q=80"
                            alt="Michel Khoury" class="w-48 h-48 object-cover rounded-full mx-auto mb-6 shadow-lg">
                        <h3 class="text-xl font-bold mb-2">Michel Khoury</h3>
                        <p class="text-gray-600 mb-4">Executive Chef & Owner</p>
                        <p class="text-gray-700 max-w-sm mx-auto">
                            With over 30 years of culinary experience, Michel brings his passion for Lebanese cuisine and
                            innovation to every dish at Casa de Familia.
                        </p>
                    </div>

                    <!-- Team Member 2 -->
                    <div class="text-center" data-animate>
                        <img src="https://images.unsplash.com/photo-1580489944761-15a19d654956?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1961&q=80"
                            alt="Nadia Khoury" class="w-48 h-48 object-cover rounded-full mx-auto mb-6 shadow-lg">
                        <h3 class="text-xl font-bold mb-2">Nadia Khoury</h3>
                        <p class="text-gray-600 mb-4">General Manager</p>
                        <p class="text-gray-700 max-w-sm mx-auto">
                            Nadia ensures that every guest receives exceptional service and leaves with unforgettable
                            memories of their dining experience.
                        </p>
                    </div>

                    <!-- Team Member 3 -->
                    <div class="text-center" data-animate>
                        <img src="https://images.unsplash.com/photo-1583394838336-acd977736f90?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1968&q=80"
                            alt="Antoine Rizk" class="w-48 h-48 object-cover rounded-full mx-auto mb-6 shadow-lg">
                        <h3 class="text-xl font-bold mb-2">Antoine Rizk</h3>
                        <p class="text-gray-600 mb-4">Head Sommelier</p>
                        <p class="text-gray-700 max-w-sm mx-auto">
                            Antoine's expertise in Lebanese and international wines helps create perfect pairings that
                            enhance our culinary offerings.
                        </p>
                    </div>
                </div>
            </div>
        </section>

    </main>
@endsection

@section('scripts')
    <script src="{{ asset('js/web/main.js') }}"></script>
@endsection
