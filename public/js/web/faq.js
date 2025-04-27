// FAQ page functionality
document.addEventListener('DOMContentLoaded', function() {
    const faqTabs = document.querySelectorAll('.faq-tab');
    const faqSections = document.querySelectorAll('.faq-section');
    const faqQuestions = document.querySelectorAll('.faq-question');
    
    // Function to filter FAQ categories
    function filterFAQs(category) {
        // First remove active class from all tabs
        faqTabs.forEach(tab => {
            tab.classList.remove('active', 'border-black');
            tab.classList.add('border-transparent');
        });
        
        // Add active class to clicked tab
        const activeTab = document.querySelector(`.faq-tab[data-category="${category}"]`);
        if (activeTab) {
            activeTab.classList.add('active', 'border-black');
            activeTab.classList.remove('border-transparent');
        }
        
        // Show/hide FAQ sections based on category
        if (category === 'all') {
            faqSections.forEach(section => {
                section.style.display = 'block';
            });
        } else {
            faqSections.forEach(section => {
                if (section.getAttribute('data-category') === category) {
                    section.style.display = 'block';
                } else {
                    section.style.display = 'none';
                }
            });
        }
    }
    
    // Add click event to FAQ tabs
    faqTabs.forEach(tab => {
        tab.addEventListener('click', function() {
            const category = this.getAttribute('data-category');
            filterFAQs(category);
        });
    });
    
    // Initialize with 'all' category
    filterFAQs('all');
    
    // Accordion functionality for FAQ items
    faqQuestions.forEach(question => {
        question.addEventListener('click', function() {
            const answer = this.nextElementSibling;
            const icon = this.querySelector('i');
            
            // Toggle answer visibility
            if (answer.classList.contains('hidden')) {
                answer.classList.remove('hidden');
                icon.classList.add('fa-minus');
                icon.classList.remove('fa-plus');
                icon.style.transform = 'rotate(180deg)';
            } else {
                answer.classList.add('hidden');
                icon.classList.add('fa-plus');
                icon.classList.remove('fa-minus');
                icon.style.transform = 'rotate(0deg)';
            }
        });
    });
    
    // Add animation to FAQ items
    const faqItems = document.querySelectorAll('.faq-item');
    
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('fade-in');
                observer.unobserve(entry.target);
            }
        });
    }, { threshold: 0.1 });
    
    faqItems.forEach(item => {
        observer.observe(item);
    });
}); 