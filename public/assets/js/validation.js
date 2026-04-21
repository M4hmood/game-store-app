document.addEventListener("DOMContentLoaded", () => {
    // Helper to show error
    const showError = (input, message) => {
        let errorDiv = input.parentElement.querySelector('.error-message');
        if (!errorDiv) {
            errorDiv = document.createElement('div');
            errorDiv.className = 'error-message';
            errorDiv.style.color = '#ff4444';
            errorDiv.style.fontSize = '0.85rem';
            errorDiv.style.marginTop = '5px';
            input.parentElement.appendChild(errorDiv);
        }
        errorDiv.textContent = message;
        input.style.borderColor = '#ff4444';
    };

    // Helper to clear error
    const clearError = (input) => {
        const errorDiv = input.parentElement.querySelector('.error-message');
        if (errorDiv) errorDiv.remove();
        input.style.borderColor = '';
    };

    // 1. Sign Up Validation
    const signupForm = document.querySelector('form[action="/signup"]');
    if (signupForm) {
        signupForm.addEventListener('submit', (e) => {
            let isValid = true;
            
            const fname = document.getElementById('firstname');
            if (fname && !/^[A-Za-z\- ]+$/.test(fname.value)) {
                showError(fname, 'First name should contain only letters.');
                isValid = false;
            } else if (fname) clearError(fname);

            const lname = document.getElementById('lastname');
            if (lname && !/^[A-Za-z\- ]+$/.test(lname.value)) {
                showError(lname, 'Last name should contain only letters.');
                isValid = false;
            } else if (lname) clearError(lname);

            const email = document.getElementById('email');
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (email && !emailRegex.test(email.value)) {
                showError(email, 'Please enter a valid email address.');
                isValid = false;
            } else if (email) clearError(email);

            const pwd = document.getElementById('password');
            if (pwd && pwd.value.length < 8) {
                showError(pwd, 'Password must be at least 8 characters.');
                isValid = false;
            } else if (pwd) clearError(pwd);

            const confirmPwd = document.getElementById('confirm-password');
            if (confirmPwd && confirmPwd.value !== pwd.value) {
                showError(confirmPwd, 'Passwords do not match.');
                isValid = false;
            } else if (confirmPwd) clearError(confirmPwd);

            if (!isValid) e.preventDefault();
        });
    }

    // 2. Admin Add Game Validation
    const adminForm = document.querySelector('form[action="/admin/games/add"]');
    if (adminForm) {
        adminForm.addEventListener('submit', (e) => {
            let isValid = true;
            
            const title = adminForm.querySelector('input[name="title"]');
            if (title && title.value.trim() === '') {
                showError(title, 'Title cannot be empty.');
                isValid = false;
            } else if (title) clearError(title);

            const price = adminForm.querySelector('input[name="price"]');
            if (price && parseFloat(price.value) <= 0 && price.value !== '0.00' && price.value !== '0') {
                showError(price, 'Price cannot be negative.');
                isValid = false;
            } else if (price) clearError(price);

            const file = adminForm.querySelector('input[name="cover_image"]');
            if (file && file.files.length > 0) {
                const allowedTypes = ['image/jpeg', 'image/png', 'image/jpg'];
                if (!allowedTypes.includes(file.files[0].type)) {
                    showError(file, 'Must be a JPG or PNG image.');
                    isValid = false;
                } else {
                    clearError(file);
                }
            } else if (file) {
                 showError(file, 'Please upload a cover image.');
                 isValid = false;
            }

            if (!isValid) e.preventDefault();
        });
    }
});
