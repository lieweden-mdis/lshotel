function editField(fieldId) {
    const field = document.getElementById(fieldId);
    field.disabled = !field.disabled;
    field.focus();
}

function saveProfile() {
    // Logic to save the profile information
    // This could involve making an AJAX request to update the information in the database

    alert('Profile saved successfully!');

    // Disable all input fields after saving
    const inputs = document.querySelectorAll('.profile-container input');
    inputs.forEach(input => input.disabled = true);
}
