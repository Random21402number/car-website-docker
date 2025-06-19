document.addEventListener('DOMContentLoaded', function() {
    // =============================================
    // FILTER TOGGLE FUNCTIONALITY
    // =============================================
    const toggleFiltersBtn = document.getElementById('toggleFilters');
    const filterButtonText = document.getElementById('filterButtonText');
    const filterArrow = document.getElementById('filterArrow');
    const searchFilters = document.getElementById('searchFilters');
    
    
    // Initialize toggle state - filters are hidden by default
    let filtersVisible = false;
    
    // Add click event to toggle filters visibility
    toggleFiltersBtn.addEventListener('click', function() {
        // Toggle the state
        filtersVisible = !filtersVisible;
        
        // Update UI based on current state
        if (filtersVisible) {
            // Show filters and update button text/arrow
            searchFilters.style.display = 'block';
            filterButtonText.textContent = 'Hide Filters';
            filterArrow.classList.remove('arrow-down');
            filterArrow.classList.add('arrow-up');
        } else {
            // Hide filters and update button text/arrow
            searchFilters.style.display = 'none';
            filterButtonText.textContent = 'Show Filters';
            filterArrow.classList.remove('arrow-up');
            filterArrow.classList.add('arrow-down');
        }
    });
    
    // =============================================
    // PRICE SLIDER FUNCTIONALITY
    // =============================================
    const minPriceInput = document.getElementById('min-price');
    const maxPriceInput = document.getElementById('max-price');
    const priceMin = document.getElementById('priceMin');
    const priceMax = document.getElementById('priceMax');
    const priceRange = document.getElementById('priceRange');
    
    // Update the price range slider when min/max price inputs change
    minPriceInput.addEventListener('input', updatePriceDisplay);
    maxPriceInput.addEventListener('input', updatePriceDisplay);
    
    /**
     * Updates the price range display and slider based on user input
     * Handles formatting and visual representation of the price range
     */
    function updatePriceDisplay() {
        // Get current min and max values (default to 0/$100k if empty)
        const minVal = minPriceInput.value || 0;
        const maxVal = maxPriceInput.value || 100000;
        
        // Update display values with proper formatting
        priceMin.textContent = `$${parseInt(minVal).toLocaleString()}`;
        
        // Special case for max price over $100k
        if (maxVal >= 100000 || maxVal === '') {
            priceMax.textContent = '$100,000+';
        } else {
            priceMax.textContent = `$${parseInt(maxVal).toLocaleString()}`;
        }
        
        // Update visual slider track position
        const maxPrice = 100000; // Reference maximum price for percentage calculation
        const leftPosition = (minVal / maxPrice) * 100;
        const rightPosition = 100 - ((maxVal || maxPrice) / maxPrice) * 100;
        
        // Apply CSS positioning for the slider track
        priceRange.style.left = `${leftPosition}%`;
        priceRange.style.right = `${rightPosition}%`;
    }
    
    // =============================================
    // MODEL SUGGESTIONS FUNCTIONALITY
    // =============================================
    const modelInput = document.getElementById('model');
    const modelSuggestions = document.getElementById('modelSuggestions');
    const brandSelect = document.getElementById('brand');
    
    // Sample car model data by brand
    // This could be replaced with an API call in a production environment
    const carModels = {
        'toyota': ['Camry', 'Corolla', 'RAV4', 'Highlander', 'Prius'],
        'honda': ['Civic', 'Accord', 'CR-V', 'Pilot', 'HR-V'],
        'ford': ['Mustang', 'F-150', 'Escape', 'Explorer', 'Edge'],
        'nissan': ['Altima', 'Sentra', 'Rogue', 'Pathfinder', 'Maxima'],
        'bmw': ['3 Series', '5 Series', 'X3', 'X5', '7 Series'],
        'audi': ['A4', 'A6', 'Q5', 'Q7', 'e-tron'],
        'mercedes': ['C-Class', 'E-Class', 'GLC', 'GLE', 'S-Class'],
        'hyundai': ['Elantra', 'Sonata', 'Tucson', 'Santa Fe', 'Kona']
    };
    
    // Update model suggestions when brand changes
    brandSelect.addEventListener('change', function() {
        const selectedBrand = this.value;
        // Only show suggestions if brand is selected and models exist for that brand
        if (selectedBrand && carModels[selectedBrand]) {
            createModelSuggestions(carModels[selectedBrand]);
        }
    });
    
    // Filter and show suggestions when typing in model field
    modelInput.addEventListener('input', function() {
        const inputText = this.value.toLowerCase();
        const selectedBrand = brandSelect.value;
        
        // Only show suggestions if brand is selected, models exist, and user has typed something
        if (selectedBrand && carModels[selectedBrand] && inputText.length > 0) {
            // Filter models that match the input text
            const filteredModels = carModels[selectedBrand].filter(model => 
                model.toLowerCase().includes(inputText)
            );
            createModelSuggestions(filteredModels);
        }
    });
    
    /**
     * Creates and displays a list of model suggestions 
     * @param {Array} models - Array of model names to display
     */
    function createModelSuggestions(models) {
        // Clear previous suggestions
        modelSuggestions.innerHTML = '';
        
        if (models.length > 0) {
            // Create a list for suggestions
            const ul = document.createElement('ul');
            
            // Add each model as a clickable list item
            models.forEach(model => {
                const li = document.createElement('li');
                li.textContent = model;
                // Add click event to select this model
                li.addEventListener('click', () => {
                    modelInput.value = model;
                    modelSuggestions.style.display = 'none';
                });
                ul.appendChild(li);
            });
            
            // Add list to the DOM and make it visible
            modelSuggestions.appendChild(ul);
            modelSuggestions.style.display = 'block';
        } else {
            // Hide suggestions if no matches
            modelSuggestions.style.display = 'none';
        }
    }
    
    // Hide suggestions when clicking outside the model input or suggestions
    document.addEventListener('click', function(event) {
        if (event.target !== modelInput && event.target !== modelSuggestions) {
            modelSuggestions.style.display = 'none';
        }
    });
    
    // =============================================
    // FORM RESET HANDLER
    // =============================================
    const searchForm = document.getElementById('searchForm');
    const resetButton = searchForm.querySelector('button[type="reset"]');
    
    // Custom reset button handler to reset form and price slider
    resetButton.addEventListener('click', function(e) {
        e.preventDefault(); // Prevent default reset behavior
        
        // Reset the form fields
        searchForm.reset();
        
        // Reset price display and slider to default values
        priceMin.textContent = '$0';
        priceMax.textContent = '$100,000+';
        priceRange.style.left = '0%';
        priceRange.style.right = '0%';  
    });

    
});

document.addEventListener('DOMContentLoaded', function() {
    // ... (previous code remains the same)

    // =============================================
    // MILEAGE SLIDER FUNCTIONALITY
    // =============================================
    const minMileageInput = document.getElementById('min-mileage');
    const maxMileageInput = document.getElementById('max-mileage');
    const mileageMin = document.getElementById('mileageMin');
    const mileageMax = document.getElementById('mileageMax');
    const mileageRange = document.getElementById('mileageRange');
    
    // Update the mileage range slider when min/max mileage inputs change
    minMileageInput.addEventListener('input', updateMileageDisplay);
    maxMileageInput.addEventListener('input', updateMileageDisplay);
    
    /**
     * Updates the mileage range display and slider based on user input
     * Handles formatting and visual representation of the mileage range
     */
    function updateMileageDisplay() {
        // Get current min and max values (default to 0/100k if empty)
        const minVal = minMileageInput.value || 0;
        const maxVal = maxMileageInput.value || 100000;
        
        // Update display values with proper formatting
        mileageMin.textContent = `${parseInt(minVal).toLocaleString()} miles`;
        
        // Special case for max mileage over 100k
        if (maxVal >= 100000 || maxVal === '') {
            mileageMax.textContent = '100,000+ miles';
        } else {
            mileageMax.textContent = `${parseInt(maxVal).toLocaleString()} miles`;
        }
        
        // Update visual slider track position
        const maxMileage = 100000; // Reference maximum mileage for percentage calculation
        const leftPosition = (minVal / maxMileage) * 100;
        const rightPosition = 100 - ((maxVal || maxMileage) / maxMileage) * 100;
        
        // Apply CSS positioning for the slider track
        mileageRange.style.left = `${leftPosition}%`;
        mileageRange.style.right = `${rightPosition}%`;
    }

    // Update the existing reset button handler to include mileage reset
    const resetButton = searchForm.querySelector('button[type="reset"]');
    
    // Custom reset button handler to reset form, price slider, and mileage slider
    resetButton.addEventListener('click', function(e) {
        e.preventDefault(); // Prevent default reset behavior
        
        // Reset the form fields
        searchForm.reset();
        
        // Reset price display and slider to default values
        priceMin.textContent = '$0';
        priceMax.textContent = '$100,000+';
        priceRange.style.left = '0%';
        priceRange.style.right = '0%';
        
        // Reset mileage display and slider to default values
        mileageMin.textContent = '0 miles';
        mileageMax.textContent = '100,000+ miles';
        mileageRange.style.left = '0%';
        mileageRange.style.right = '0%';
    });
});