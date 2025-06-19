// Add this to a new file in your JS folder
document.addEventListener('DOMContentLoaded', function() {
    // Create a debug element
    const debugElement = document.createElement('div');
    debugElement.style.position = 'fixed';
    debugElement.style.bottom = '10px';
    debugElement.style.right = '10px';
    debugElement.style.backgroundColor = 'rgba(0, 0, 0, 0.7)';
    debugElement.style.color = 'white';
    debugElement.style.padding = '10px';
    debugElement.style.borderRadius = '5px';
    debugElement.style.zIndex = '9999';
    debugElement.style.fontSize = '12px';
    debugElement.style.maxWidth = '300px';
    debugElement.style.maxHeight = '200px';
    debugElement.style.overflow = 'auto';
    
    // Add a title
    debugElement.innerHTML = '<h3 style="margin: 0 0 5px 0;">Session Debug</h3>';
    
    // Add a button to fetch session info
    const debugButton = document.createElement('button');
    debugButton.textContent = 'Check Session';
    debugButton.style.marginBottom = '5px';
    debugButton.style.padding = '3px 8px';
    debugElement.appendChild(debugButton);
    
    // Add content container
    const debugContent = document.createElement('div');
    debugElement.appendChild(debugContent);
    
    // Add to document
    document.body.appendChild(debugElement);
    
    // Session check function
    function checkSession() {
        fetch('../PHP/check-session.php')
            .then(response => response.json())
            .then(data => {
                let content = '';
                if (data.isLoggedIn) {
                    content += `<p>✅ Logged in as: ${data.username}</p>`;
                    content += `<p>User ID: ${data.user_id}</p>`;
                    content += `<p>Profile pic: ${data.profile_pic}</p>`;
                    content += `<p>Session ID: ${data.session_id}</p>`;
                } else {
                    content += '<p>❌ Not logged in</p>';
                    content += `<p>Session ID: ${data.session_id || 'None'}</p>`;
                }
                debugContent.innerHTML = content;
            })
            .catch(error => {
                debugContent.innerHTML = `<p>Error: ${error.message}</p>`;
            });
    }
    
    // Check on button click
    debugButton.addEventListener('click', checkSession);
    
    // Initial check
    checkSession();
});