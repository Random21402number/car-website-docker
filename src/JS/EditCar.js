document.addEventListener('DOMContentLoaded', function() {
    // Image preview functionality
    const imagePathInput = document.getElementById('image_path');
    if (imagePathInput) {
        imagePathInput.addEventListener('input', updateImagePreview);
        
        function updateImagePreview() {
            const imageUrl = imagePathInput.value.trim();
            const previewContainer = document.querySelector('.car-image-preview');
            
            if (imageUrl) {
                // Create a new image element
                const img = new Image();
                img.onload = function() {
                    // Replace the preview container content with the new image
                    previewContainer.innerHTML = '';
                    previewContainer.appendChild(img);
                };
                
                img.onerror = function() {
                    // Show error placeholder if image fails to load
                    previewContainer.innerHTML = `
                        <div class="no-image">
                            <svg xmlns="http://www.w3.org/2000/svg" width="60" height="60" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="12" cy="12" r="10"></circle>
                                <line x1="12" y1="8" x2="12" y2="12"></line>
                                <line x1="12" y1="16" x2="12.01" y2="16"></line>
                            </svg>
                            <p>Invalid image URL</p>
                        </div>
                    `;
                };
                
                img.src = imageUrl;
            } else {
                // Show placeholder if no URL provided
                previewContainer.innerHTML = `
                    <div class="no-image">
                        <svg xmlns="http://www.w3.org/2000/svg" width="60" height="60" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round">
                            <rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect>
                            <circle cx="8.5" cy="8.5" r="1.5"></circle>
                            <polyline points="21 15 16 10 5 21"></polyline>
                        </svg>
                        <p>No image available</p>
                    </div>
                `;
            }
        }
    }
    
    // Form validation
    const editCarForm = document.querySelector('.edit-car-form');
    if (editCarForm) {
        editCarForm.addEventListener('submit', function(e) {
            let valid = true;
            const maker = document.getElementById('maker').value.trim();
            const model = document.getElementById('model').value.trim();
            const year = document.getElementById('year').value.trim();
            const price = document.getElementById('price').value.trim();
            const mileage = document.getElementById('mileage').value.trim();
            
            // Basic validation
            if (!maker || !model || !year || !price || !mileage) {
                valid = false;
                alert('Please fill in all required fields.');
            }
            
            // Validate year
            const currentYear = new Date().getFullYear();
            if (year < 1900 || year > currentYear + 1) {
                valid = false;
                alert('Please enter a valid year between 1900 and ' + (currentYear + 1));
            }
            
            // Validate price
            if (price <= 0) {
                valid = false;
                alert('Price must be greater than 0.');
            }
            
            // Validate mileage
            if (mileage < 0) {
                valid = false;
                alert('Mileage cannot be negative.');
            }
            
            if (!valid) {
                e.preventDefault();
            }
        });
    }
    
    // Auto-hide flash messages
    const flashMessages = document.querySelectorAll('.flash-message');
    flashMessages.forEach(function(message) {
        setTimeout(function() {
            message.style.opacity = '0';
            setTimeout(function() {
                message.style.display = 'none';
            }, 600);
        }, 5000);
    });
});