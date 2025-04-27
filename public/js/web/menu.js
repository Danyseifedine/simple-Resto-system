// Menu filtering functionality
document.addEventListener('DOMContentLoaded', function() {
    // Get all menu tabs
    const menuTabs = document.querySelectorAll('.menu-tab');
    // Get all menu sections
    const menuSections = document.querySelectorAll('.menu-section');

    // Add click event listener to each tab
    menuTabs.forEach(tab => {
        tab.addEventListener('click', function() {
            // Get the category ID from the clicked tab
            const categoryId = this.getAttribute('data-category');

            // Remove active class from all tabs
            menuTabs.forEach(t => {
                t.classList.remove('active');
                t.classList.remove('border-black');
                t.classList.add('border-transparent');
            });

            // Add active class to clicked tab
            this.classList.add('active');
            this.classList.add('border-black');
            this.classList.remove('border-transparent');

            // Hide all menu sections
            menuSections.forEach(section => {
                section.style.display = 'none';
            });

            // Show the menu section that matches the category ID
            const activeSection = document.querySelector(`.menu-section[data-category="${categoryId}"]`);
            if (activeSection) {
                activeSection.style.display = 'block';
            }
        });
    });

    // Initialize with 'all' category
    const allSection = document.querySelector(`.menu-section[data-category="all"]`);
    if (allSection) {
        allSection.style.display = 'block';
    }

    // Add animation to menu items
    const menuItems = document.querySelectorAll('#menu-items .flex');

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('fade-in');
                observer.unobserve(entry.target);
            }
        });
    }, { threshold: 0.1 });

    menuItems.forEach(item => {
        observer.observe(item);
    });
});
