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

    // Password Toggle Functionality
    document.querySelectorAll('.password-toggle').forEach(function(button) {
        button.addEventListener('click', function(event) {
            event.preventDefault();

            // Trouver le wrapper parent (password-wrapper ou input-wrapper)
            const wrapper = button.closest('.password-wrapper') || button.closest('.input-wrapper');

            if (wrapper) {
                // Trouver l'input de mot de passe dans le wrapper
                const input = wrapper.querySelector('input[type="password"], input[type="text"]');

                if (input) {
                    // Basculer le type
                    if (input.type === 'password') {
                        input.type = 'text';
                        button.setAttribute('aria-label', 'Masquer le mot de passe');
                    } else {
                        input.type = 'password';
                        button.setAttribute('aria-label', 'Afficher le mot de passe');
                    }
                }
            }
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

