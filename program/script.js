document.addEventListener('DOMContentLoaded', function () {
    const inquiryForm = document.getElementById('partyInquiryForm');
    const responseDiv = document.getElementById('inquiryResponse');
    const programIdInput = document.getElementById('program_id');
    const programNameInput = document.getElementById('program_name');
    const inquireButtons = document.querySelectorAll('.inquire-btn');
    
    // 1. Handle "Inquire Now" button clicks
    inquireButtons.forEach(button => {
        button.addEventListener('click', function () {
            const programId = this.dataset.programId;
            const programName = this.dataset.programName;

            // Populate the form with data from the selected package
            programIdInput.value = programId;
            programNameInput.value = `Inquiry for: ${programName}`;

            // Smoothly scroll down to the form
            inquiryForm.scrollIntoView({ behavior: 'smooth', block: 'center' });
        });
    });

    // 2. Handle the AJAX form submission
    inquiryForm.addEventListener('submit', function (e) {
        e.preventDefault();
        
        // Check if a package has been selected
        if (!programIdInput.value) {
            responseDiv.className = 'alert alert-warning';
            responseDiv.innerHTML = 'Please select a party package from the options above before sending an inquiry.';
            return;
        }

        const submitButton = this.querySelector('button[type="submit"]');
        const formData = new FormData(this);

        submitButton.disabled = true;
        submitButton.textContent = 'Sending...';
        responseDiv.innerHTML = '';

        fetch('process_program_inquiry.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            const messageClass = data.status === 'success' ? 'alert alert-success' : 'alert alert-danger';
            responseDiv.className = messageClass;
            responseDiv.innerHTML = data.message;

            if (data.status === 'success') {
                inquiryForm.reset(); // Clears all form fields
            }
        })
        .catch(error => {
            responseDiv.className = 'alert alert-danger';
            responseDiv.innerHTML = 'A network error occurred. Please try again.';
            console.error('Fetch Error:', error);
        })
        .finally(() => {
            submitButton.disabled = false;
            submitButton.textContent = 'Send Inquiry';
        });
    });
});