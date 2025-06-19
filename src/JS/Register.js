document.addEventListener('DOMContentLoaded', function() {
    
    const registerForm = document.getElementById('registerForm');
    const usernameInput = document.getElementById('username');
    const passwordInput = document.getElementById('password');
    const emailInput = document.getElementById('email');
    const promotionalEmails = document.getElementById('promotionalEmails');
    
    const usernameError = document.getElementById('usernameError');
    const passwordError = document.getElementById('passwordError');
    const emailError = document.getElementById('emailError');
    
    

    const toggleSwitch = document.getElementById("ButtonID");
    const toggleCheckbox = document.getElementById("temp");
    
    toggleSwitch.addEventListener('click', function() {
        // Simply toggle the checked property (not attribute)
        toggleCheckbox.checked = !toggleCheckbox.checked;
    });

    function getCookie(name) {
        const value = `; ${document.cookie}`;
        const parts = value.split(`; ${name}=`);
        if (parts.length === 2) {
            return decodeURIComponent(parts.pop().split(';').shift());
        }
        return null;
    }
    
    // Check for registration error cookie and display alert
    const errorMessage = getCookie('registration_error');
    if (errorMessage) {
        alert(errorMessage);
        
        // Delete the cookie by setting expiration in the past
        document.cookie = 'registration_error=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;';
    }
    
    // Add visual feedback for form fields
    const formInputs = [usernameInput, passwordInput, emailInput];
    
    formInputs.forEach(input => {
        // Add focus effects
        input.addEventListener('focus', function() {
            this.parentElement.classList.add('input-focused');
        });
        
        input.addEventListener('blur', function() {
            this.parentElement.classList.remove('input-focused');
        });
    });
    
    // Validate username on blur
    usernameInput.addEventListener('blur', function() {
        if (this.value.length < 3) {
            usernameError.textContent = 'Username must be at least 3 characters long';
            usernameError.style.display = 'block';
            this.parentElement.classList.add('input-error');
        } else {
            usernameError.style.display = 'none';
            this.parentElement.classList.remove('input-error');
        }
    });
    
    // Validate password on blur
    passwordInput.addEventListener('blur', function() {
        if (this.value.length < 6) {
            passwordError.textContent = 'Password must be at least 6 characters long';
            passwordError.style.display = 'block';
            this.parentElement.classList.add('input-error');
        } else {
            passwordError.style.display = 'none';
            this.parentElement.classList.remove('input-error');
        }
    });
    
    // Validate email on blur
    emailInput.addEventListener('blur', function() {
        if (!validateEmail(this.value)) {
            emailError.textContent = 'Please enter a valid email address';
            emailError.style.display = 'block';
            this.parentElement.classList.add('input-error');
        } else {
            emailError.style.display = 'none';
            this.parentElement.classList.remove('input-error');
        }
    });
    
    // Clear error messages when input is focused
    usernameInput.addEventListener('focus', () => {
        usernameError.style.display = 'none';
        usernameInput.parentElement.classList.remove('input-error');
    });
    
    passwordInput.addEventListener('focus', () => {
        passwordError.style.display = 'none';
        passwordInput.parentElement.classList.remove('input-error');
    });
    
    emailInput.addEventListener('focus', () => {
        emailError.style.display = 'none';
        emailInput.parentElement.classList.remove('input-error');
    });
    
    // Form submission validation
    registerForm.addEventListener('submit', function(event) {
        let isValid = true;
        
        // Validate username
        if (usernameInput.value.length < 3) {
            usernameError.textContent = 'Username must be at least 3 characters long';
            usernameError.style.display = 'block';
            usernameInput.parentElement.classList.add('input-error');
            isValid = false;
        }
        
        // Validate password
        if (passwordInput.value.length < 6) {
            passwordError.textContent = 'Password must be at least 6 characters long';
            passwordError.style.display = 'block';
            passwordInput.parentElement.classList.add('input-error');
            isValid = false;
        }
        
        // Validate email
        if (!validateEmail(emailInput.value)) {
            emailError.textContent = 'Please enter a valid email address';
            emailError.style.display = 'block';
            emailInput.parentElement.classList.add('input-error');
            isValid = false;
        }
        
        if (!isValid) {
            event.preventDefault();
            
            // Add shake animation to form on invalid submission
            registerForm.classList.add('shake');
            setTimeout(() => {
                registerForm.classList.remove('shake');
            }, 500);
        } else {
            // Add loading state to button
            const submitButton = document.querySelector('.primary-button');
            submitButton.innerHTML = '<span class="spinner"></span> Registering...';
            submitButton.disabled = true;
        }
    });
    
    // Email validation function
    function validateEmail(email) {
        const re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
        return re.test(String(email).toLowerCase());
    }
});