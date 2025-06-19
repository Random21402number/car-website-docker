document.addEventListener('DOMContentLoaded', function() {
    // Add smooth scrolling for anchor links
    const anchorLinks = document.querySelectorAll('a[href^="#"]');
    
    anchorLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            
            const targetId = this.getAttribute('href');
            if (targetId === '#') return;
            
            const targetElement = document.querySelector(targetId);
            if (targetElement) {
                targetElement.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });
    
    // Animation for process steps on scroll
    const processSteps = document.querySelectorAll('.process-step');
    const toolCards = document.querySelectorAll('.tool-card');
    const testimonialCards = document.querySelectorAll('.testimonial-card');
    
    // Simple function to check if element is in viewport
    function isInViewport(element) {
        const rect = element.getBoundingClientRect();
        return (
            rect.top >= 0 &&
            rect.left >= 0 &&
            rect.bottom <= (window.innerHeight || document.documentElement.clientHeight) &&
            rect.right <= (window.innerWidth || document.documentElement.clientWidth)
        );
    }
    
    // Function to add animation class when element is in viewport
    function checkVisibility() {
        processSteps.forEach(step => {
            if (isInViewport(step)) {
                step.classList.add('animate-step');
            }
        });
        
        toolCards.forEach(card => {
            if (isInViewport(card)) {
                card.classList.add('animate-card');
            }
        });
        
        testimonialCards.forEach(card => {
            if (isInViewport(card)) {
                card.classList.add('animate-card');
            }
        });
    }
    
    // Check visibility on page load and scroll
    window.addEventListener('load', checkVisibility);
    window.addEventListener('scroll', checkVisibility);
    
    // Handle inquiry form if added in the future
    const inquiryForm = document.getElementById('inquiryForm');
    if (inquiryForm) {
        inquiryForm.addEventListener('submit', function(e) {
            e.preventDefault();
            // Form submission logic would go here
            alert('Thank you for your inquiry! A representative will contact you shortly.');
            inquiryForm.reset();
        });
    }
});