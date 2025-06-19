document.addEventListener('DOMContentLoaded', function() {
    // Car model data similar to CarSearch.js
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

    const brandSelect = document.getElementById('brand');
    const modelInput = document.getElementById('model');
    const modelSuggestions = document.getElementById('modelSuggestions');

    // Model Suggestions Functionality (similar to CarSearch.js)
    brandSelect.addEventListener('change', function() {
        const selectedBrand = this.value;
        modelInput.value = ''; // Reset model input
        if (selectedBrand && carModels[selectedBrand]) {
            createModelSuggestions(carModels[selectedBrand]);
        } else {
            modelSuggestions.innerHTML = '';
            modelSuggestions.style.display = 'none';
        }
    });

    modelInput.addEventListener('input', function() {
        const inputText = this.value.toLowerCase();
        const selectedBrand = brandSelect.value;
        
        if (selectedBrand && carModels[selectedBrand] && inputText.length > 0) {
            const filteredModels = carModels[selectedBrand].filter(model => 
                model.toLowerCase().includes(inputText)
            );
            createModelSuggestions(filteredModels);
        }
    });

    function createModelSuggestions(models) {
        modelSuggestions.innerHTML = '';
        
        if (models.length > 0) {
            const ul = document.createElement('ul');
            
            models.forEach(model => {
                const li = document.createElement('li');
                li.textContent = model;
                li.addEventListener('click', () => {
                    modelInput.value = model;
                    modelSuggestions.style.display = 'none';
                });
                ul.appendChild(li);
            });
            
            modelSuggestions.appendChild(ul);
            modelSuggestions.style.display = 'block';
        } else {
            modelSuggestions.style.display = 'none';
        }
    }

    // Hide suggestions when clicking outside
    document.addEventListener('click', function(event) {
        if (event.target !== modelInput && event.target !== modelSuggestions) {
            modelSuggestions.style.display = 'none';
        }
    });

    // File Upload Handling
    const fileInput = document.getElementById('car-images');
    const fileList = document.getElementById('file-list');

    fileInput.addEventListener('change', function(event) {
        fileList.innerHTML = ''; // Clear previous selections
        
        // Limit to 5 files
        const files = Array.from(this.files).slice(0, 5);
        
        files.forEach(file => {
            const fileItem = document.createElement('div');
            fileItem.classList.add('file-item');
            fileItem.textContent = file.name;
            fileList.appendChild(fileItem);
        });
    });

    // Form Reset Handler
    const addCarForm = document.getElementById('addCarForm');
    const resetButton = addCarForm.querySelector('button[type="reset"]');

    resetButton.addEventListener('click', function(e) {
        e.preventDefault();
        addCarForm.reset();
        fileList.innerHTML = ''; // Clear file list
        modelSuggestions.innerHTML = ''; // Clear model suggestions
        modelSuggestions.style.display = 'none';
    });
});