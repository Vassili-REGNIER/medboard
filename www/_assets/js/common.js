// Common functionality for all pages: Theme switcher and Mobile menu
document.addEventListener('DOMContentLoaded', function() {
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
    const passwordToggles = document.querySelectorAll('.password-toggle');
    console.log('Password toggles found:', passwordToggles.length);

    passwordToggles.forEach(function(toggle, index) {
        console.log('Setting up toggle', index, toggle);

        toggle.addEventListener('click', function(e) {
            console.log('Toggle clicked!', e.target);
            e.preventDefault(); // Prevent any default button behavior
            e.stopPropagation(); // Stop event from bubbling

            // Find the wrapper (password-wrapper or input-wrapper)
            const wrapper = toggle.closest('.password-wrapper') || toggle.closest('.input-wrapper');
            console.log('Wrapper found:', wrapper);

            if (!wrapper) {
                console.error('Password toggle: No wrapper found');
                return;
            }

            // Find the password input inside the wrapper
            const passwordInput = wrapper.querySelector('input[type="password"], input[type="text"]');
            console.log('Password input found:', passwordInput);

            if (passwordInput) {
                // Toggle between password and text
                const isPassword = passwordInput.type === 'password';
                console.log('Current type:', passwordInput.type, '-> New type:', isPassword ? 'text' : 'password');
                passwordInput.type = isPassword ? 'text' : 'password';

                // Update aria-label
                toggle.setAttribute('aria-label', isPassword ? 'Masquer le mot de passe' : 'Afficher le mot de passe');
                console.log('Password toggled successfully!');
            } else {
                console.error('Password toggle: No input found in wrapper');
            }
        });
    });
});

