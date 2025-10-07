// Password Toggle Functionality
document.addEventListener('DOMContentLoaded', function() {
    const passwordInput = document.getElementById('password');
    const confirmPasswordInput = document.getElementById('confirmPassword');
    const toggleButtons = document.querySelectorAll('.password-toggle');
    let isVisible = false;

    // Toggle password visibility globally
    toggleButtons.forEach(btn => {
        btn.addEventListener('click', function() {
            isVisible = !isVisible;
            const type = isVisible ? 'text' : 'password';
            passwordInput.setAttribute('type', type);
            confirmPasswordInput.setAttribute('type', type);
            // Toggle icons for all buttons
            toggleButtons.forEach(b => {
                const eyeLight = b.querySelector('.eye-light');
                const eyeDark = b.querySelector('.eye-dark');
                if (isVisible) {
                    eyeLight.style.opacity = '0.4';
                    eyeDark.style.opacity = '0.4';
                } else {
                    eyeLight.style.opacity = '1';
                    eyeDark.style.opacity = '1';
                }
            });
        });
    });

    // Form validation
    const signupForm = document.querySelector('.signup-form');
    if (signupForm) {
        signupForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const password = passwordInput.value;
            const confirmPassword = confirmPasswordInput.value;
            
            if (password !== confirmPassword) {
                alert('Les mots de passe ne correspondent pas.');
                return;
            }
            
            if (password.length < 8) {
                alert('Le mot de passe doit contenir au moins 8 caractères.');
                return;
            }
            
            // Si tout est valide
            alert('Compte créé avec succès !');
            // Ici vous pouvez ajouter la logique d'envoi au serveur
        });
    }
});

