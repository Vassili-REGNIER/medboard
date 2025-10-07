// Script spécifique pour la page 404 - Gestion des icônes de thème dynamiques
document.addEventListener('DOMContentLoaded', function() {
    const moonLight = document.querySelector('.moon-light');
    const moonDark = document.querySelector('.moon-dark');
    const sunIcon = document.querySelector('.sun-icon');
    const body = document.body;

    // Fonction pour mettre à jour les icônes selon le thème
    function updateThemeIcons() {
        const isDark = body.classList.contains('dark-theme');

        if (isDark) {
            // Mode sombre : afficher le soleil, masquer les lunes
            if (moonLight) moonLight.style.display = 'none';
            if (moonDark) moonDark.style.display = 'none';
            if (sunIcon) sunIcon.style.display = 'block';
        } else {
            // Mode clair : afficher lune.svg, masquer lune-v2.svg et soleil
            if (moonLight) moonLight.style.display = 'block';
            if (moonDark) moonDark.style.display = 'none';
            if (sunIcon) sunIcon.style.display = 'none';
        }
    }

    // Initialiser les icônes au chargement
    updateThemeIcons();

    // Observer les changements de classe sur le body pour détecter les changements de thème
    const observer = new MutationObserver(function(mutations) {
        mutations.forEach(function(mutation) {
            if (mutation.type === 'attributes' && mutation.attributeName === 'class') {
                updateThemeIcons();
            }
        });
    });

    // Commencer à observer
    observer.observe(body, {
        attributes: true,
        attributeFilter: ['class']
    });
});
