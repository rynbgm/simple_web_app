function validateYear(input) {
    var year = (input.value);
    var currentYear = new Date().getFullYear();

    // Check if the input is a valid number and within an acceptable range
    if (isNaN(year) || year < 1000 || year > currentYear + 10) {
        alert("Please enter a valid year.");
        input.value = ''; // Clear the input field
    }
}