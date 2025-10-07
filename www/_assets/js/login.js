// Password Toggle Functionality for Login Page
document.addEventListener('DOMContentLoaded', function() {
    const passwordInput = document.getElementById('loginPassword');
    const toggleButton = document.getElementById('toggleLoginPassword');
    let isVisible = false;

    // Toggle password visibility
    if (toggleButton && passwordInput) {
        toggleButton.addEventListener('click', function() {
            isVisible = !isVisible;
            const type = isVisible ? 'text' : 'password';
            passwordInput.setAttribute('type', type);
            
            // Toggle icon opacity
            const eyeLight = toggleButton.querySelector('.eye-light');
            const eyeDark = toggleButton.querySelector('.eye-dark');
            if (isVisible) {
                eyeLight.style.opacity = '0.4';
                eyeDark.style.opacity = '0.4';
            } else {
                eyeLight.style.opacity = '1';
                eyeDark.style.opacity = '1';
            }
        });
    }

    // Form validation
    const loginForm = document.querySelector('.signup-form');
    if (loginForm) {
        loginForm.addEventListener('submit', function(e) {
            e.preventDefault();

            // Récupère l'identifiant (email ou login)
            const identifier = document.getElementById('loginIdentifier').value.trim();
            const password = passwordInput.value;

            if (!identifier || !password) {
                alert('Veuillez remplir tous les champs.');
                return;
            }

            // Détecte si c'est un email ou un login
            const isEmail = identifier.includes('@');

            console.log('Type d\'identifiant:', isEmail ? 'Email' : 'Login');
            console.log('Identifiant:', identifier);

            // Si tout est valide
            alert('Connexion en cours...');
            // Ici vous pouvez ajouter la logique de connexion au serveur
            // Le backend devra vérifier si identifier est un email ou un login
        });
    }
});

