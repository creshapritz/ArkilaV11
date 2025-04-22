
function togglePassword(fieldId, eyeIcon) {
    var field = document.getElementById(fieldId);
    if (field.type === "password") {
        field.type = "text";
        eyeIcon.innerHTML = '<i class="bx bx-show"></i>';
    } else {
        field.type = "password";
        eyeIcon.innerHTML = '<i class="bx bx-hide"></i>';
    }
}

function validateForm() {
    var firstName = document.getElementById('first_name').value;
    var middleName = document.getElementById('middle_name').value;
    var lastName = document.getElementById('last_name').value;
    var username = document.getElementById('username').value;
    var email = document.getElementById('email').value;
    var password = document.getElementById('password').value;
    var confirmPassword = document.getElementById('confirm_password').value;
    var dob = document.getElementById('dob').value;
    var age = document.getElementById('age').value;
    var contactNumber = document.getElementById('contact_number').value;
    var emergencyContact = document.getElementById('emergency_contact').value;
    var terms = document.getElementById('terms').checked;

    if (firstName && lastName && username && email && password && confirmPassword && dob && age && contactNumber && emergencyContact && terms) {
        if (password !== confirmPassword) {
            alert('Passwords do not match.');
            return false;
        }

        // Validate password strength
        var passwordRegex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/;
        if (!passwordRegex.test(password)) {
            alert('Password must be at least 8 characters long and contain uppercase letters, lowercase letters, numbers, and special characters.');
            return false;
        }

        // Validate age based on date of birth
        var birthDate = new Date(dob);
        var today = new Date();
        var calculatedAge = today.getFullYear() - birthDate.getFullYear();
        var monthDifference = today.getMonth() - birthDate.getMonth();
        if (monthDifference < 0 || (monthDifference === 0 && today.getDate() < birthDate.getDate())) {
            calculatedAge--;
        }

        if (calculatedAge < 18 || age < 18) {
            alert('You must be at least 18 years old to register.');
            return false;
        }

        if (contactNumber === emergencyContact) {
            alert('Contact number and emergency contact number cannot be the same.');
            return false;
        }

        localStorage.setItem('currentStep', 2); // Store the current step in local storage
        window.location.href = '/register2';
        return false; // Prevent form submission
    } else {
        alert('Please fill out all required fields.');
        return false;
    }
}


function highlightStep(step) {
    // Remove active class from all steps and lines
    document.querySelectorAll('.timeline-step').forEach(function (element) {
        element.classList.remove('active');
    });
    document.querySelectorAll('.timeline-line').forEach(function (element) {
        element.classList.remove('active');
    });

    // Highlight based on the current step
    if (step === 1) {
        document.getElementById('step-1').classList.add('active'); // Highlight Step 1
    } else if (step === 2) {
        document.getElementById('step-1').classList.add('active');
        document.getElementById('step-2').classList.add('active'); // Highlight Step 2
        document.getElementById('line-1').classList.add('active'); // Highlight Line 1
    } else if (step === 3) {
        document.getElementById('step-1').classList.add('active');
        document.getElementById('step-2').classList.add('active'); // Highlight Step 2
        document.getElementById('line-1').classList.add('active'); // Highlight Line 1
        document.getElementById('step-3').classList.add('active'); // Highlight Step 3
        document.getElementById('line-2').classList.add('active'); // Highlight Line 2
    }
}

// On page load, determine the current step
document.addEventListener('DOMContentLoaded', function () {
    // Define step mapping based on the page
    const pageSteps = {
        '/register': 1,  // Step 1 for register
        '/register2': 2, // Step 2 for register2
        '/register3': 3, // Step 3 for register3
    };

    // Get the current page path
    const currentPath = window.location.pathname;

    // Get the corresponding step or default to step 1
    const currentStep = pageSteps[currentPath] || 1;

    // Highlight the appropriate step
    highlightStep(currentStep);
});

function goToNext() {
    window.location.href = '/register3';
}

// Navigate back to register Blade
function goToBack() {
    window.location.href = '/register';
}




 // Show/Hide Forms
 document.getElementById('self-drive-button').addEventListener('click', function () {
    document.getElementById('self-drive-form').classList.remove('hidden');
});

document.getElementById('with-driver-button').addEventListener('click', function () {
    document.getElementById('self-drive-form').classList.add('hidden');
});

document.addEventListener("DOMContentLoaded", function () {
    const selfDriveButton = document.getElementById("self-drive-button");
    const withDriverButton = document.getElementById("with-driver-button");
    const selfDriveForm = document.getElementById("self-drive-form");
    const withDriverForm = document.getElementById("with-driver-form");

    selfDriveButton.addEventListener("click", () => {
        selfDriveForm.classList.add("visible");
        selfDriveForm.classList.remove("hidden");
        withDriverForm.classList.add("hidden");
        withDriverForm.classList.remove("visible");
    });

    withDriverButton.addEventListener("click", () => {
        withDriverForm.classList.add("visible");
        withDriverForm.classList.remove("hidden");
        selfDriveForm.classList.add("hidden");
        selfDriveForm.classList.remove("visible");
    });
});


function validateFile(input) {
    const file = input.files[0];
    const allowedExtensions = ['jpeg', 'jpg', 'png', 'pdf'];
    const maxSize = 5 * 1024 * 1024; // 5MB in bytes

    if (file) {
        const fileExtension = file.name.split('.').pop().toLowerCase();
        const fileSize = file.size;

        if (!allowedExtensions.includes(fileExtension)) {
            alert('Invalid file type. Only JPEG, PNG, and PDF files are allowed.');
            input.value = ''; // Clear the input
            return false;
        }

        if (fileSize > maxSize) {
            alert('File size exceeds 5MB. Please upload a smaller file.');
            input.value = ''; // Clear the input
            return false;
        }

        // Display the selected file name
        const fileNameSpan = input.nextElementSibling;
        fileNameSpan.textContent = file.name;
    }
    return true;
}









// Navigation to Previous Page
function goToBack() {
    window.location.href = "{{ route('register2') }}"; // Adjust this route as needed
}



