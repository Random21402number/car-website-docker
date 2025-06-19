document.addEventListener('DOMContentLoaded', function() {
    // Tab switching functionality
    const tabButtons = document.querySelectorAll('.tab-button');
    const tabContents = document.querySelectorAll('.tab-content');
    
    tabButtons.forEach(button => {
        button.addEventListener('click', function() {
            // Remove active class from all buttons and contents
            tabButtons.forEach(btn => btn.classList.remove('active'));
            tabContents.forEach(content => content.classList.remove('active'));
            
            // Add active class to clicked button
            this.classList.add('active');
            
            // Get the tab to activate
            const tabToActivate = this.getAttribute('data-tab');
            
            // Activate the corresponding tab content
            document.getElementById(`${tabToActivate}-tab`).classList.add('active');
        });
    });
    
    // Image gallery functionality
    const thumbnails = document.querySelectorAll('.thumbnail');
    thumbnails.forEach(thumbnail => {
        thumbnail.addEventListener('click', function() {
            // Remove active class from all thumbnails
            thumbnails.forEach(thumb => thumb.classList.remove('active'));
            
            // Add active class to clicked thumbnail
            this.classList.add('active');
        });
    });
    
    // Contact seller modal functionality
    const contactSellerBtn = document.querySelector('.contact-seller-btn');
    const contactModal = document.getElementById('contactSellerModal');
    const closeModal = document.querySelector('.close-modal');
    
    if (contactSellerBtn && contactModal) {
        contactSellerBtn.addEventListener('click', function() {
            contactModal.style.display = 'block';
        });
        
        closeModal.addEventListener('click', function() {
            contactModal.style.display = 'none';
        });
        
        // Close modal when clicking outside
        window.addEventListener('click', function(event) {
            if (event.target === contactModal) {
                contactModal.style.display = 'none';
            }
        });
    }
    
    // Contact form submission
    const contactForm = document.getElementById('contactForm');
    if (contactForm) {
        contactForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Get form data
            const formData = new FormData(contactForm);
            
            // Add car_id to form data (assuming it's available in the URL)
            const urlParams = new URLSearchParams(window.location.search);
            const carId = urlParams.get('id');
            formData.append('car_id', carId);
            
            // Show loading state
            const submitBtn = contactForm.querySelector('button[type="submit"]');
            const originalBtnText = submitBtn.textContent;
            submitBtn.textContent = 'Sent!';
            submitBtn.disabled = true;
            
            // Send AJAX request
            fetch('../PHP/send_email.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                // Reset button state
                submitBtn.textContent = originalBtnText;
                submitBtn.disabled = false;
                
                if (data.success) {
                    // Show success message
                    alert(data.message);
                    contactModal.style.display = 'none';
                    contactForm.reset();
                }
            })
        });
    }
});

// Function to change main car image
function changeMainImage(imagePath) {
    const mainImage = document.getElementById('mainCarImage');
    if (mainImage) {
        mainImage.src = imagePath;
    }
}

