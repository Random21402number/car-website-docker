       // Message expansion functionality
        document.querySelectorAll('.message-item').forEach(item => {
            item.addEventListener('click', function(e) {
                // Don't trigger if clicking on a button or link
                if (e.target.tagName === 'BUTTON' || e.target.tagName === 'A' || e.target.closest('button') || e.target.closest('a')) {
                    return;
                }
                
                const contentId = 'content-' + this.dataset.id;
                const content = document.getElementById(contentId);
                
                // Toggle message content visibility
                if (content.classList.contains('show')) {
                    content.classList.remove('show');
                    this.classList.remove('expanded');
                } else {
                    // Close any other open messages
                    document.querySelectorAll('.message-content.show').forEach(openContent => {
                        openContent.classList.remove('show');
                        openContent.closest('.message-item').classList.remove('expanded');
                    });
                    
                    content.classList.add('show');
                    this.classList.add('expanded');
                }
            });
        });

// Message expansion functionality
document.querySelectorAll('.message-item').forEach(item => {
    item.addEventListener('click', function(e) {
        // Don't trigger if clicking on a button or link
        if (e.target.tagName === 'BUTTON' || e.target.tagName === 'A' || e.target.closest('button') || e.target.closest('a')) {
            return;
        }
        
        const contentId = 'content-' + this.dataset.id;
        const content = document.getElementById(contentId);
        
        // Toggle message content visibility
        if (content.classList.contains('show')) {
            content.classList.remove('show');
            this.classList.remove('expanded');
        } else {
            // Close any other open messages
            document.querySelectorAll('.message-content.show').forEach(openContent => {
                openContent.classList.remove('show');
                openContent.closest('.message-item').classList.remove('expanded');
            });
            
            content.classList.add('show');
            this.classList.add('expanded');
        }
    });
});

// Delete car functionality
document.addEventListener('DOMContentLoaded', function() {
    const modal = document.getElementById('deleteCarModal');
    const closeBtn = document.querySelector('.close-modal');
    const cancelBtn = document.getElementById('cancelDeleteBtn');
    const deleteButtons = document.querySelectorAll('.car-delete-btn');
    const carToDeleteName = document.getElementById('carToDeleteName');
    const carIdToDelete = document.getElementById('carIdToDelete');
    
    // Open modal when delete button is clicked
    deleteButtons.forEach(button => {
        button.addEventListener('click', function() {
            const carId = this.dataset.carId;
            const carName = this.dataset.carName;
            
            carToDeleteName.textContent = carName;
            carIdToDelete.value = carId;
            
            modal.style.display = 'flex';
        });
    });
    
    // Close modal functions
    function closeModal() {
        modal.style.display = 'none';
    }
    
    closeBtn.addEventListener('click', closeModal);
    cancelBtn.addEventListener('click', closeModal);
    
    // Close modal when clicking outside of it
    window.addEventListener('click', function(event) {
        if (event.target === modal) {
            closeModal();
        }
    });
});