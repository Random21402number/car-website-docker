document.addEventListener('DOMContentLoaded', function() {
    // Smooth scrolling for anchor links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            document.querySelector(this.getAttribute('href')).scrollIntoView({
                behavior: 'smooth'
            });
        });
    });
    
    // Profile dropdown functionality
    const profilePic = document.getElementById('profilePic');
    const profileDropdown = document.getElementById('profileDropdown');

    if (profilePic) {
        console.log("Profile pic element found");
        // Toggle dropdown on profile picture click
        profilePic.addEventListener('click', function(event) {
            console.log("Profile pic clicked");
            event.stopPropagation(); // Prevent the click from bubbling to the window
            profileDropdown.classList.toggle('show');
            console.log("Show class toggled:", profileDropdown.classList.contains('show'));
        });
    }    
});