// Common functionality for all pages: Theme switcher and Mobile menu
function initCommon() {
    // Theme Switcher
    const themeToggle = document.getElementById('themeToggle');
    const mobileThemeToggle = document.getElementById('mobileThemeToggle');
    const body = document.body;
    const moonIcon = document.querySelector('.moon-icon');
    const sunIcon = document.querySelector('.sun-icon');
    const mobileMoonIcon = document.querySelector('.mobile-moon-icon');
    const mobileSunIcon = document.querySelector('.mobile-sun-icon');
    const mobileThemeText = document.querySelector('.mobile-theme-text');
    
    // Appliquer le thème sauvegardé ou thème par défaut
    const savedTheme = localStorage.getItem('theme') || 'light';
    
    function updateThemeIcons(isDark) {
        if (isDark) {
            if (moonIcon) moonIcon.style.display = 'none';
            if (sunIcon) sunIcon.style.display = 'block';
            if (mobileMoonIcon) mobileMoonIcon.style.display = 'none';
            if (mobileSunIcon) mobileSunIcon.style.display = 'block';
            if (mobileThemeText) mobileThemeText.textContent = 'Sombre';
        } else {
            if (moonIcon) moonIcon.style.display = 'block';
            if (sunIcon) sunIcon.style.display = 'none';
            if (mobileMoonIcon) mobileMoonIcon.style.display = 'block';
            if (mobileSunIcon) mobileSunIcon.style.display = 'none';
            if (mobileThemeText) mobileThemeText.textContent = 'Sombre';
        }
    }
    
    if (savedTheme === 'dark') {
        body.classList.replace('light-theme', 'dark-theme');
        updateThemeIcons(true);
    }
    
    // Fonction pour basculer le thème
    function toggleTheme() {
        const isDark = body.classList.contains('dark-theme');
        
        if (isDark) {
            body.classList.replace('dark-theme', 'light-theme');
            updateThemeIcons(false);
            localStorage.setItem('theme', 'light');
        } else {
            body.classList.replace('light-theme', 'dark-theme');
            updateThemeIcons(true);
            localStorage.setItem('theme', 'dark');
        }
    }
    
    // Basculer entre thèmes (desktop)
    if (themeToggle) {
        themeToggle.addEventListener('click', toggleTheme);
    }
    
    // Basculer entre thèmes (mobile)
    if (mobileThemeToggle) {
        mobileThemeToggle.addEventListener('click', toggleTheme);
    }

    // Mobile Menu
    const mobileMenuToggle = document.getElementById('mobileMenuToggle');
    const mobileMenu = document.getElementById('mobileMenu');
    const mobileMenuClose = document.getElementById('mobileMenuClose');

    if (mobileMenuToggle && mobileMenu && mobileMenuClose) {
        // Ouvrir le menu mobile
        mobileMenuToggle.addEventListener('click', function() {
            mobileMenu.classList.add('active');
            document.body.style.overflow = 'hidden';
        });

        // Fermer le menu mobile
        mobileMenuClose.addEventListener('click', function() {
            mobileMenu.classList.remove('active');
            document.body.style.overflow = '';
        });

        // Fermer le menu en cliquant sur un lien
        const mobileMenuLinks = mobileMenu.querySelectorAll('.mobile-menu-link, .mobile-menu-actions a');
        mobileMenuLinks.forEach(link => {
            link.addEventListener('click', function() {
                mobileMenu.classList.remove('active');
                document.body.style.overflow = '';
            });
        });
    }

    // Terms Checkbox Validation (Register Page)
    const registerForm = document.querySelector('form[action*="register"]');
    if (registerForm) {
        const termsCheckbox = document.getElementById('terms');
        if (termsCheckbox) {
            registerForm.addEventListener('submit', function(event) {
                if (!termsCheckbox.checked) {
                    event.preventDefault();
                    alert('Vous devez accepter les conditions d\'utilisation et la politique de confidentialité pour créer un compte.');
                    termsCheckbox.focus();
                }
            });
        }
    }

    // Password Toggle Functionality
    document.querySelectorAll('.password-toggle').forEach(function(button) {
        button.addEventListener('click', function(event) {
            event.preventDefault();

            // Chercher tous les wrappers de mot de passe
            const allPasswordWrappers = document.querySelectorAll('.password-wrapper, .input-wrapper');
            const allPasswordInputs = [];

            // Collecter tous les inputs de mot de passe
            allPasswordWrappers.forEach(function(wrapper) {
                const input = wrapper.querySelector('input[type="password"]') ||
                              wrapper.querySelector('input[type="text"][id*="assword"]') ||
                              wrapper.querySelector('input[type="text"][name*="password"]');
                if (input) {
                    allPasswordInputs.push(input);
                }
            });

            if (allPasswordInputs.length === 0) return;

            // Vérifier l'état actuel du premier input
            const shouldShow = allPasswordInputs[0].type === 'password';

            // Appliquer le changement à tous les inputs de mot de passe
            allPasswordInputs.forEach(function(input) {
                if (shouldShow) {
                    input.type = 'text';
                } else {
                    input.type = 'password';
                }
            });

            // Mettre à jour tous les boutons toggle
            document.querySelectorAll('.password-toggle').forEach(function(btn) {
                if (shouldShow) {
                    btn.setAttribute('aria-label', 'Masquer le mot de passe');
                } else {
                    btn.setAttribute('aria-label', 'Afficher le mot de passe');
                }
            });
        });
    });
}

// Appeler l'initialisation quand le DOM est prêt
if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initCommon);
} else {
    // Le DOM est déjà chargé
    initCommon();
}

