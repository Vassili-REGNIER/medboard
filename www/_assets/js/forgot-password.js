// Forgot Password Form Validation
document.addEventListener('DOMContentLoaded', function() {
    const forgotForm = document.querySelector('.signup-form');
    
    if (forgotForm) {
        forgotForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const emailInput = forgotForm.querySelector('input[type="email"]');
            const email = emailInput.value;
            
            if (!email) {
                alert('Veuillez saisir votre adresse email.');
                return;
            }
            
            // Validation basique d'email
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailRegex.test(email)) {
                alert('Veuillez saisir une adresse email valide.');
                return;
            }
            
            // Si tout est valide
            alert('Un lien de réinitialisation a été envoyé à votre adresse email.');
            // Ici vous pouvez ajouter la logique d'envoi au serveur
            
            // Optionnel : rediriger vers la page de connexion après quelques secondes
            // setTimeout(() => {
            //     window.location.href = 'login.html';
            // }, 2000);
        });
    }
});

