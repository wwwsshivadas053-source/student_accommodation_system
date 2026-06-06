// Form Validation
function validateEmail(email) {
    const regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return regex.test(email);
}

function validatePassword(password) {
    return password.length >= 6;
}

function validatePhone(phone) {
    const regex = /^[0-9]{10}$/;
    return regex.test(phone.replace(/[-\s]/g, ''));
}

// Register form validation
document.addEventListener('DOMContentLoaded', function() {
    const registerForm = document.getElementById('registerForm');
    if (registerForm) {
        registerForm.addEventListener('submit', function(e) {
            let errors = [];

            const fullName = document.getElementById('fullName').value.trim();
            const email = document.getElementById('email').value.trim();
            const password = document.getElementById('password').value;
            const confirmPassword = document.getElementById('confirmPassword').value;
            const phone = document.getElementById('phone').value.trim();

            if (!fullName) {
                errors.push('Full name is required');
            }

            if (!email) {
                errors.push('Email is required');
            } else if (!validateEmail(email)) {
                errors.push('Invalid email format');
            }

            if (!password) {
                errors.push('Password is required');
            } else if (!validatePassword(password)) {
                errors.push('Password must be at least 6 characters');
            }

            if (password !== confirmPassword) {
                errors.push('Passwords do not match');
            }

            if (!phone) {
                errors.push('Phone number is required');
            } else if (!validatePhone(phone)) {
                errors.push('Invalid phone number (must be 10 digits)');
            }

            if (errors.length > 0) {
                e.preventDefault();
                alert(errors.join('\n'));
            }
        });
    }

    // Login form validation
    const loginForm = document.getElementById('loginForm');
    if (loginForm) {
        loginForm.addEventListener('submit', function(e) {
            const email = document.getElementById('email').value.trim();
            const password = document.getElementById('password').value;

            if (!email || !password) {
                e.preventDefault();
                alert('Email and password are required');
            }
        });
    }

    // Contact form validation
    const contactForm = document.getElementById('contactForm');
    if (contactForm) {
        contactForm.addEventListener('submit', function(e) {
            let errors = [];

            const name = document.getElementById('name').value.trim();
            const email = document.getElementById('email').value.trim();
            const subject = document.getElementById('subject').value.trim();
            const message = document.getElementById('message').value.trim();

            if (!name) errors.push('Name is required');
            if (!email || !validateEmail(email)) errors.push('Valid email is required');
            if (!subject) errors.push('Subject is required');
            if (!message) errors.push('Message is required');

            if (errors.length > 0) {
                e.preventDefault();
                alert(errors.join('\n'));
            }
        });
    }

    // Property form validation
    const propertyForm = document.getElementById('propertyForm');
    if (propertyForm) {
        propertyForm.addEventListener('submit', function(e) {
            let errors = [];

            const title = document.getElementById('title').value.trim();
            const location = document.getElementById('location').value.trim();
            const price = document.getElementById('price').value;
            const roomType = document.getElementById('roomType').value;

            if (!title) errors.push('Title is required');
            if (!location) errors.push('Location is required');
            if (!price || price <= 0) errors.push('Valid price is required');
            if (!roomType) errors.push('Room type is required');

            if (errors.length > 0) {
                e.preventDefault();
                alert(errors.join('\n'));
            }
        });
    }

    // Application form validation
    const applicationForm = document.getElementById('applicationForm');
    if (applicationForm) {
        applicationForm.addEventListener('submit', function(e) {
            const message = document.getElementById('message').value.trim();
            if (!message) {
                e.preventDefault();
                alert('Please write a message for your application');
            }
        });
    }
});

// Image preview
function previewImage(event) {
    const file = event.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            const preview = document.getElementById('imagePreview');
            if (preview) {
                preview.src = e.target.result;
                preview.style.display = 'block';
            }
        };
        reader.readAsDataURL(file);
    }
}

// Filter properties
function filterProperties() {
    const searchBox = document.getElementById('searchBox');
    const filterBtn = document.getElementById('filterBtn');
    
    if (filterBtn) {
        filterBtn.addEventListener('click', function() {
            const form = document.getElementById('filterForm');
            if (form) {
                form.submit();
            }
        });
    }

    if (searchBox) {
        searchBox.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                const form = document.getElementById('filterForm');
                if (form) {
                    form.submit();
                }
            }
        });
    }
}

filterProperties();

// Confirm delete action
function confirmDelete() {
    return confirm('Are you sure you want to delete this? This action cannot be undone.');
}

// Format currency
function formatCurrency(amount) {
    return '₹' + new Intl.NumberFormat('en-IN').format(amount);
}
