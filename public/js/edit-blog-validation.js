$(document).ready(function () {
    // Function to validate the form
    function validateForm() {
        var title = $('#title').val();
        var description = $('#description').val();
        var startDate = $('#start_date').val();
        var endDate = $('#end_date').val();
        var imageInput = $('#image');
        var imageFileSize = imageInput[0].files[0] ? imageInput[0].files[0].size : 0;

        // Check if the title field is empty
        if (!title) {
            alert('Title is required.');
            return false;
        }

        // Check if the description field is empty
        if (!description) {
            alert('Description is required.');
            return false;
        }

        // Check if the start date field is empty
        if (!startDate) {
            alert('Start Date is required.');
            return false;
        }

        // Check if the end date is not less than start date
        if (endDate && endDate < startDate) {
            alert('End Date must be greater than or equal to Start Date.');
            return false;
        }

        // Check if an image is selected (optional)
        if (imageInput.val()) {
            // Check if the image size is greater than 2MB
            var maxSize = 2 * 1024 * 1024; // 2MB in bytes
            if (imageFileSize > maxSize) {
                alert('Image size must be 2MB or less.');
                return false;
            }
        }

        return true;
    }

    // Attach a submit event handler to the form
    $('form').on('submit', function (event) {
        // Prevent the default form submission
        event.preventDefault();

        // Validate the form before submission
        if (validateForm()) {
            // If validation passes, submit the form
            this.submit();
        }
    });
});
