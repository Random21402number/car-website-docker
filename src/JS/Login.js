document.addEventListener('DOMContentLoaded', function() {
    const loginForm = document.getElementById('login-form');
    const usernameInput = document.getElementById('username');
    const passwordInput = document.getElementById('password');
    const usernameError = document.getElementById('usernameError');
    const passwordError = document.getElementById('passwordError');
    
    // Add visual feedback for form fields
    const formInputs = [usernameInput, passwordInput];
    
    formInputs.forEach(input => {
        // Add focus effects
        input.addEventListener('focus', function() {
            this.parentElement.classList.add('input-focused');
            if (this === usernameInput) {
                usernameError.style.display = 'none';
            } else if (this === passwordInput) {
                passwordError.style.display = 'none';
            }
        });
        
        input.addEventListener('blur', function() {
            this.parentElement.classList.remove('input-focused');
        });
    });
    
    loginForm.addEventListener('submit', async function(event) {
        event.preventDefault(); // Prevent form submission

        let isValid = true;
        
        // Clear previous errors
        usernameError.textContent = '';
        passwordError.textContent = '';
        usernameError.style.display = 'none';
        passwordError.style.display = 'none';
        
        // Basic validation
        if (usernameInput.value.trim() === '') {
            usernameError.textContent = 'Please enter your username';
            usernameError.style.display = 'block';
            usernameInput.parentElement.classList.add('input-error');
            isValid = false;
        }
        
        if (passwordInput.value.trim() === '') {
            passwordError.textContent = 'Please enter your password';
            passwordError.style.display = 'block';
            passwordInput.parentElement.classList.add('input-error');
            isValid = false;
        }
        
        if (!isValid) {
            // Add shake animation to form on invalid submission
            loginForm.classList.add('shake');
            setTimeout(() => {
                loginForm.classList.remove('shake');
            }, 500);
            return;
        }
        
        // Add loading state to button
        const submitButton = loginForm.querySelector('button');
        const originalButtonText = submitButton.textContent;
        submitButton.innerHTML = '<span class="spinner"></span> Signing In...';
        submitButton.disabled = true;
        
        try {
            // Create FormData object (better for PHP $_POST)
            const formData = new FormData();
            formData.append('username', usernameInput.value);
            formData.append('password', passwordInput.value);
            
            // Send credentials to the PHP backend
            const response = await fetch("../PHP/Login.php", {
                method: "POST",
                body: formData
            });
            
            // Add console logging for debugging
            console.log('Response status:', response.status);
            
            // Check if the response is OK (status 200)
            if (!response.ok) {
                throw new Error(`HTTP error! Status: ${response.status}`);
            }
            
            const responseText = await response.text();
            console.log('Raw response:', responseText);
            console.log('Response length:', responseText.length);
            console.log('Character at position 45:', responseText.charAt(45))
            console.log('Characters around position 45:', responseText.substring(40, 50));
            
            let result;
            try {
                result = JSON.parse(responseText);
            } catch (e) {
                console.error('JSON parse error:', e);
                throw new Error('Invalid response format');
            }
            
            console.log('Parsed result:', result);
            
            if (result.success) {
                // Redirect to the dashboard or home page
                console.log('Login successful, redirecting...');
                window.location.href = "../WebPages/index.php";
            } else {
                // Display error message
                passwordError.textContent = result.message || 'Invalid username or password';
                passwordError.style.display = 'block';
                
                // Reset button state
                submitButton.innerHTML = originalButtonText;
                submitButton.disabled = false;
                
                // Add shake animation
                loginForm.classList.add('shake');
                setTimeout(() => {
                    loginForm.classList.remove('shake');
                }, 500);
            }
        } catch (error) {
            // Handle network errors or fetch errors
            console.error('Fetch error: ', error);
            passwordError.textContent = 'Connection error. Please try again.';
            passwordError.style.display = 'block';
            
            // Reset button state
            submitButton.innerHTML = originalButtonText;
            submitButton.disabled = false;
        }
    });
});