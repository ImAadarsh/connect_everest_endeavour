document.addEventListener('DOMContentLoaded', function() {
    // Handle all forms with class 'ajax-form'
    const forms = document.querySelectorAll('.ajax-form');
    
    forms.forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const formData = new FormData(this);
            const submitButton = form.querySelector('button[type="submit"]');
            const originalButtonText = submitButton.innerHTML;
            
            // Disable submit button and show loading state
            submitButton.disabled = true;
            submitButton.innerHTML = '<span>Processing...</span>';
            
            fetch(this.action, {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    // Show success alert
                    Swal.fire({
                        title: 'Success!',
                        text: data.message,
                        icon: 'success',
                        confirmButtonText: 'OK'
                    }).then((result) => {
                        // Reset form
                        form.reset();
                        // Scroll to top of the page
                        window.scrollTo({ top: 0, behavior: 'smooth' });
                    });
                } else {
                    // Show error alert
                    Swal.fire({
                        title: 'Error!',
                        text: data.message,
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                }
            })
            .catch(error => {
                Swal.fire({
                    title: 'Error!',
                    text: 'An error occurred. Please try again.',
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
            })
            .finally(() => {
                // Re-enable submit button and restore original text
                submitButton.disabled = false;
                submitButton.innerHTML = originalButtonText;
            });
        });
    });
});

function showMessage(message, type) {
    // Create message element
    const messageDiv = document.createElement('div');
    messageDiv.className = `alert alert-${type === 'success' ? 'success' : 'danger'} mt-3`;
    messageDiv.textContent = message;
    
    // Find the form
    const form = document.querySelector('.ajax-form');
    
    // Remove any existing messages
    const existingMessages = form.querySelectorAll('.alert');
    existingMessages.forEach(msg => msg.remove());
    
    // Add new message
    form.insertBefore(messageDiv, form.firstChild);
    
    // Remove message after 5 seconds
    setTimeout(() => {
        messageDiv.remove();
    }, 5000);
} 