async function submitApply() {
    const submitButton = document.querySelector('button[type="submit"]');
    let isSubmitting = false; // Flag to prevent multiple submissions

    submitButton.addEventListener('click', async function(e) {
        e.preventDefault();

        if (isSubmitting) {
            return; // Prevent submission if already submitting
        }

        isSubmitting = true;

        const form = document.querySelector('form:not(#logout-form)');
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

async function ajaxFormButton(formId, buttonId) {
    const submitButton = document.querySelector(`#${buttonId}`);
    let isSubmitting = false; // Flag to prevent multiple submissions

    submitButton.addEventListener('click', async function(e) {
        e.preventDefault();

        if (isSubmitting) {
            return; // Prevent submission if already submitting
        }

        isSubmitting = true;

        const form = document.querySelector(`#${formId}`);
        console.log(form);
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
        console.log("hello");
    });
}


async function ajaxForm(formId) {
    const form = document.querySelector(`#${formId}`);
    let isSubmitting = false; // Flag to prevent multiple submissions

    form.addEventListener('submit', async function(e) {
        e.preventDefault();

        if (isSubmitting) {
            return; // Prevent submission if already submitting
        }

        isSubmitting = true;

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

async function ajaxData(url, data, callback) {
    let isSubmitting = false; // Flag to prevent multiple submissions

    try {
        const response = await fetch(url, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json', // Specify JSON content type
            },
            body: JSON.stringify(data), // Convert data to JSON and send
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
                if (callback) {
                    callback(responseData); // Pass response data to the callback
                }
                isSubmitting = false; // Allow submission after response
            });
    } catch (error) {
        console.error('An error occurred:', error);
        isSubmitting = false; // Allow submission after error
    }
}

// Usage example:
// const dataToSend = {
//     operation: "update",
//     quote: "Your quote data here"
// };

// ajaxData("/path/to/your/php/script.php", dataToSend);