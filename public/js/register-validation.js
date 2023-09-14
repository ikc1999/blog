$(document).ready(function () {

    // Password confirmation validation
    $('#password, #password-confirm').on('keyup', function () {

        var password = $('#password').val();
        var confirmPassword = $('#password-confirm').val();

        if (password === confirmPassword) {
            $('#password-confirm').removeClass('is-invalid');
        } else {
            $('#password-confirm').addClass('is-invalid');
        }
    });

    // Image size validation
    $('#image').on('change', function () {
        var maxSize = 2 * 1024 * 1024; // 2MB in bytes

        if (this.files.length > 0) {
            var fileSize = this.files[0].size;

            if (fileSize > maxSize) {
                $('#image').val(''); // Clear the file input
                alert('Image size must be 2MB or less.');
            }
        }
    });

    // Form submission validation
    $('form').on('submit', function () {
        var password = $('#password').val();
        var confirmPassword = $('#password-confirm').val();
        var maxSize = 2 * 1024 * 1024;

        // Password confirmation validation
        if (password !== confirmPassword) {
            alert("password & confirm password doesn't match");
            $('#password-confirm').addClass('is-invalid');
            return false; // Prevent form submission
        }

        // Image size validation
        if ($('#image')[0].files.length > 0) {
            var fileSize = $('#image')[0].files[0].size;

            if (fileSize > maxSize) {
                $('#image').val(''); // Clear the file input
                alert('Image size must be 2MB or less.');
                return false; // Prevent form submission
            }
        }

        // If all validations pass, allow the form to be submitted
        return true;
    });
});
