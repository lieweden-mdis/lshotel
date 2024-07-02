// Function to validate an email address using regex
function isValidEmail(email) {
    // Regular expression pattern for basic email validation
    const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return emailPattern.test(email);
}

// Function to truncate a string to a specified length
function truncateString(str, maxLength) {
    if (str.length > maxLength) {
        return null; // Return null if the input exceeds maxLength
    } else {
        return str;
    }
}

// Get all edit buttons
const editButtons = document.querySelectorAll('.box button');

// Add event listener for each edit button
editButtons.forEach(button => {
    button.addEventListener('click', () => {
        // Get the parent fieldset of the clicked button
        const fieldset = button.parentNode;

        // Find the span element containing the current information
        const span = fieldset.querySelector('span');

        // Set maximum and minimum lengths for each field
        let maxLength, minLength;
        switch (fieldset.querySelector('legend').textContent) {
            case 'Name':
                minLength = 5;
                maxLength = 128;
                break;
            case 'Email':
                minLength = 10;
                maxLength = 128;
                break;
            case 'Phone Number':
                minLength = 8;
                maxLength = 11;
                break;
            case 'Password':
                minLength = 8;
                maxLength = 128;
                break;
            default:
                minLength = 0;
                maxLength = 128; // Default maximum length
        }

        // Check if it's the Name field
        if (fieldset.querySelector('legend').textContent === 'Name') {
            // Get current name and split into First Name and Last Name
            const currentName = span.textContent.trim(); // Get current name and trim extra spaces
            const spaceIndex = currentName.lastIndexOf(' ');
            const lastName = currentName.slice(0, spaceIndex); // Last name is before the last space
            const firstName = currentName.slice(spaceIndex + 1); // First name is after the last space

            // Prompt user to enter new First Name and Last Name separately
            let newFirstName = prompt('Enter new First Name:', firstName);
            let newLastName = prompt('Enter new Last Name:', lastName);

            // Calculate total length of new names
            const totalLength = newFirstName.length + newLastName.length + 1; // Adding 1 for the space between first and last name

            // Check if total length exceeds maximum or is below minimum
            if (totalLength > maxLength || totalLength < minLength) {
                alert(`The total length of First Name and Last Name must be between ${minLength} and ${maxLength} characters.`);
            } else {
                // Update the span content with the new name display
                const newNameDisplay = `${newLastName} ${newFirstName}`.trim();
                span.textContent = newNameDisplay;

                // Log the updated value
                console.log(`Updated Name to: ${newNameDisplay}`);
            }
        } else {
            // Prompt user to enter new information for other fields
            let newValue = prompt(`Enter new ${fieldset.querySelector('legend').textContent}:`, span.textContent);

            // Truncate value if it exceeds maximum length
            newValue = truncateString(newValue, maxLength);

            // Check if value exceeds maximum length or is below minimum
            if (newValue === null || newValue.length < minLength || newValue.length > maxLength) {
                alert(`The ${fieldset.querySelector('legend').textContent} must be between ${minLength} and ${maxLength} characters.`);
            } else if (newValue !== '') {
                // Update the span content with the new value
                span.textContent = newValue;
                // Log the updated value
                console.log(`Updated ${fieldset.querySelector('legend').textContent} to: ${newValue}`);
            } else {
                // Optional: Handle cancel or empty input scenario
                console.log(`User canceled or entered empty value for ${fieldset.querySelector('legend').textContent} update.`);
            }
        }
    });
});
