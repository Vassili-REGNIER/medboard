// Password visibility toggle - synchronized for both fields
const passwordToggles = document.querySelectorAll('.password-toggle');
const newPasswordInput = document.getElementById('newPassword');
const confirmPasswordInput = document.getElementById('confirmPassword');
let passwordsVisible = false;

passwordToggles.forEach(toggle => {
    toggle.addEventListener('click', function() {
        // Toggle visibility state
        passwordsVisible = !passwordsVisible;
        const newType = passwordsVisible ? 'text' : 'password';

        // Apply to both password fields
        newPasswordInput.setAttribute('type', newType);
        confirmPasswordInput.setAttribute('type', newType);

        // Update all toggle button icons
        passwordToggles.forEach(btn => {
            const eyeLight = btn.querySelector('.eye-light');
            const eyeDark = btn.querySelector('.eye-dark');

            if (passwordsVisible) {
                if (eyeLight) eyeLight.style.opacity = '0.4';
                if (eyeDark) eyeDark.style.opacity = '0.4';
            } else {
                if (eyeLight) eyeLight.style.opacity = '1';
                if (eyeDark) eyeDark.style.opacity = '1';
            }
        });
    });
});

// Password validation
const submitBtn = document.getElementById('submitBtn');
const strengthFill = document.getElementById('strengthFill');
const strengthLabel = document.getElementById('strengthLabel');

const requirements = {
    length: { element: document.getElementById('req-length'), regex: /.{8,}/ },
    uppercase: { element: document.getElementById('req-uppercase'), regex: /[A-Z]/ },
    lowercase: { element: document.getElementById('req-lowercase'), regex: /[a-z]/ },
    number: { element: document.getElementById('req-number'), regex: /[0-9]/ },
    special: { element: document.getElementById('req-special'), regex: /[!@#$%^&*(),.?":{}|<>]/ }
};

function checkRequirements(password) {
    let validCount = 0;
    
    for (const key in requirements) {
        const req = requirements[key];
        const isValid = req.regex.test(password);
        
        if (isValid) {
            req.element.classList.add('valid');
            validCount++;
        } else {
            req.element.classList.remove('valid');
        }
    }
    
    return validCount;
}

function updateStrengthBar(validCount) {
    const percentage = (validCount / 5) * 100;
    strengthFill.style.width = percentage + '%';
    
    if (validCount === 0) {
        strengthFill.className = 'password-strength-fill';
        strengthLabel.textContent = 'Faible';
        strengthLabel.className = 'password-strength-label weak';
    } else if (validCount <= 2) {
        strengthFill.className = 'password-strength-fill weak';
        strengthLabel.textContent = 'Faible';
        strengthLabel.className = 'password-strength-label weak';
    } else if (validCount <= 4) {
        strengthFill.className = 'password-strength-fill medium';
        strengthLabel.textContent = 'Moyen';
        strengthLabel.className = 'password-strength-label medium';
    } else {
        strengthFill.className = 'password-strength-fill strong';
        strengthLabel.textContent = 'Fort';
        strengthLabel.className = 'password-strength-label strong';
    }
}

function validateForm() {
    const password = newPasswordInput.value;
    const confirmPassword = confirmPasswordInput.value;
    const validCount = checkRequirements(password);
    
    updateStrengthBar(validCount);
    
    const allValid = validCount === 5;
    const passwordsMatch = password === confirmPassword && password.length > 0;
    
    submitBtn.disabled = !(allValid && passwordsMatch);
}

newPasswordInput.addEventListener('input', validateForm);
confirmPasswordInput.addEventListener('input', validateForm);

// Form submission
document.getElementById('changePasswordForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const password = newPasswordInput.value;
    const confirmPassword = confirmPasswordInput.value;
    
    if (password === confirmPassword) {
        alert('Mot de passe modifié avec succès !');
        window.location.href = 'login.html';
    }
});

