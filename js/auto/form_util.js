async function submitApply() {
    const submitButton = document.querySelector('button[type="submit"]');
    let isSubmitting = false; // Flag to prevent multiple submissions

    submitButton.addEventListener('click', async function(e) {
        e.preventDefault();

        if (isSubmitting) {
            return; // Prevent submission if already submitting
        }

        isSubmitting = true;

        const form = document.querySelector('form');
        const formData = new FormData(form);

        try {
            const response = await fetch(form.action, {
                method: 'POST',
                body: formData
            });

            const responseData = await response.json();
            const status = responseData.status || 'error'; // Default to 'error' if no status

            const icons = {
                success: 'success',
                error: 'error',
                warning: 'warning'
            };

            const icon = icons[status] || 'error'; // Default to 'error' icon if status not recognized

            swal.fire(status.charAt(0).toUpperCase() + status.slice(1), responseData.message, icon)
                .then(() => {
                    if (responseData.callback) {
                        eval(responseData.callback);
                    }
                    isSubmitting = false; // Allow submission after response
                });
        } catch (error) {
            console.error('An error occurred:', error);
            isSubmitting = false; // Allow submission after error
        }
    });
}
