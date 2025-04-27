// Main JavaScript file

// Navbar scroll effect
document.addEventListener('DOMContentLoaded', function() {
    const header = document.getElementById('header');
    const mobileMenuBtn = document.getElementById('mobile-menu-btn');
    const mobileMenu = document.getElementById('mobile-menu');
    
    // Scroll effect for navbar
    window.addEventListener('scroll', function() {
        if (window.scrollY > 50) {
            header.classList.add('bg-black', 'text-white', 'shadow-md');
            header.classList.remove('bg-transparent');
        } else {
            header.classList.add('bg-transparent');
            header.classList.remove('bg-black', 'text-white', 'shadow-md');
        }
    });
    
    // Mobile menu toggle
    if (mobileMenuBtn) {
        mobileMenuBtn.addEventListener('click', function() {
            mobileMenu.classList.toggle('hidden');
        });
    }
    
    // Initialize animations for elements with data-animate attribute
    const animatedElements = document.querySelectorAll('[data-animate]');
    
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('fade-in');
                observer.unobserve(entry.target);
            }
        });
    }, { threshold: 0.1 });
    
    animatedElements.forEach(el => {
        observer.observe(el);
    });
}); 