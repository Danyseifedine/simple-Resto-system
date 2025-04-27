    <!-- Footer -->
    <footer class="bg-black text-white py-12">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                <!-- Logo and About -->
                <div>
                    <h3 class="text-2xl font-bold mb-4">Casa de Familia</h3>
                    <p class="text-gray-400 mb-6">
                        Elegant mountain dining with breathtaking views of Falougha.
                    </p>
                    <div class="flex space-x-4">
                        <a href="#" class="text-white hover:text-gray-300 transition-colors">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a href="#" class="text-white hover:text-gray-300 transition-colors">
                            <i class="fab fa-instagram"></i>
                        </a>
                        <a href="#" class="text-white hover:text-gray-300 transition-colors">
                            <i class="fab fa-twitter"></i>
                        </a>
                    </div>
                </div>

                <!-- Contact Info -->
                <div>
                    <h4 class="text-lg font-bold mb-4">Contact Us</h4>
                    <ul class="space-y-3 text-gray-400">
                        <li class="flex items-start">
                            <i class="fas fa-map-marker-alt mt-1 mr-3"></i>
                            <span>Falougha Mountain Road, Lebanon</span>
                        </li>
                        <li class="flex items-start">
                            <i class="fas fa-phone-alt mt-1 mr-3"></i>
                            <span>+961 1 234 567</span>
                        </li>
                        <li class="flex items-start">
                            <i class="fas fa-envelope mt-1 mr-3"></i>
                            <span>info@casadefamilia.com</span>
                        </li>
                    </ul>
                </div>

                <!-- Opening Hours -->
                <div>
                    <h4 class="text-lg font-bold mb-4">Opening Hours</h4>
                    <ul class="space-y-3 text-gray-400">
                        <li class="flex justify-between">
                            <span>Monday - Thursday</span>
                            <span>12:00 - 22:00</span>
                        </li>
                        <li class="flex justify-between">
                            <span>Friday - Saturday</span>
                            <span>12:00 - 23:00</span>
                        </li>
                        <li class="flex justify-between">
                            <span>Sunday</span>
                            <span>12:00 - 21:00</span>
                        </li>
                    </ul>
                </div>

                <!-- Quick Links -->
                <div>
                    <h4 class="text-lg font-bold mb-4">Quick Links</h4>
                    <ul class="space-y-2 text-gray-400">
                        <li><a href="{{ route('welcome') }}" class="hover:text-white transition-colors">Home</a></li>
                        @if (auth()->check())
                            <li><a href="{{ route('menu') }}" class="hover:text-white transition-colors">Menu</a></li>
                            <li><a href="{{ route('events') }}" class="hover:text-white transition-colors">Events</a>
                            </li>
                        @endif
                        <li><a href="{{ route('about') }}" class="hover:text-white transition-colors">About Us</a></li>
                        <li><a href="{{ route('contact') }}" class="hover:text-white transition-colors">Contact</a></li>
                        <li><a href="{{ route('faq') }}" class="hover:text-white transition-colors">FAQ</a></li>
                    </ul>
                </div>
            </div>

            <div class="border-t border-gray-800 mt-12 pt-8 text-center text-gray-500">
                <p>&copy; 2023 Casa de Familia. All rights reserved.</p>
            </div>
        </div>
    </footer>
