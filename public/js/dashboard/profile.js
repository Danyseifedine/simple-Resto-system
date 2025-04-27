// Profile and Password Update Handling
document.addEventListener('DOMContentLoaded', function() {
    // Profile Form Submission
    const profileForm = document.getElementById('profile_form');
    if (profileForm) {
        profileForm.addEventListener('submit', function(e) {
            e.preventDefault();

            const formData = new FormData(profileForm);

            fetch(profileForm.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Show success message
                    Swal.fire({
                        text: data.message,
                        icon: "success",
                        buttonsStyling: false,
                        confirmButtonText: "Ok, got it!",
                        customClass: {
                            confirmButton: "btn btn-primary"
                        }
                    }).then(function() {
                        // Reload page to reflect changes
                        location.reload();
                    });
                } else {
                    // Show error message
                    Swal.fire({
                        text: data.message || "An error occurred. Please try again.",
                        icon: "error",
                        buttonsStyling: false,
                        confirmButtonText: "Ok, got it!",
                        customClass: {
                            confirmButton: "btn btn-primary"
                        }
                    });
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
        });
    }

    // Password Form Submission
    const passwordForm = document.getElementById('password_form');
    if (passwordForm) {
        passwordForm.addEventListener('submit', function(e) {
            e.preventDefault();

            const formData = new FormData(passwordForm);

            fetch(passwordForm.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Show success message
                    Swal.fire({
                        text: data.message,
                        icon: "success",
                        buttonsStyling: false,
                        confirmButtonText: "Ok, got it!",
                        customClass: {
                            confirmButton: "btn btn-primary"
                        }
                    }).then(function() {
                        // Clear password fields
                        passwordForm.reset();
                    });
                } else {
                    // Show error message
                    Swal.fire({
                        text: data.message || "An error occurred. Please try again.",
                        icon: "error",
                        buttonsStyling: false,
                        confirmButtonText: "Ok, got it!",
                        customClass: {
                            confirmButton: "btn btn-primary"
                        }
                    });
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
        });
    }
});
