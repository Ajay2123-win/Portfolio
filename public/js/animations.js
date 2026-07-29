document.addEventListener('DOMContentLoaded', () => {

    // Retire le mode "sans transition" une fois la page chargée,
    // pour éviter un flash d'animation au premier rendu
    requestAnimationFrame(() => {
        document.body.classList.remove('preload');
    });

    // ---------- Thème clair / sombre ----------
    const toggle = document.getElementById('themeToggle');
    const body = document.body;
    const label = toggle.querySelector('.theme-label');
    const icon = toggle.querySelector('.theme-icon i');

    const appliquerTheme = (clair) => {
        body.classList.toggle('light-mode', clair);
        label.textContent = clair ? 'Mode clair' : 'Mode sombre';
        icon.className = clair ? 'bi bi-sun' : 'bi bi-moon-stars';
    };

    appliquerTheme(localStorage.getItem('theme') === 'light');

    toggle.addEventListener('click', () => {
        toggle.classList.add('switching');
        const estClair = !body.classList.contains('light-mode');
        appliquerTheme(estClair);
        localStorage.setItem('theme', estClair ? 'light' : 'dark');
        setTimeout(() => toggle.classList.remove('switching'), 400);
    });

    // ---------- Effet ripple sur les boutons ----------
    document.querySelectorAll('.btn, .ripple-btn').forEach((btn) => {
        btn.addEventListener('click', function (e) {
            const rect = this.getBoundingClientRect();
            const ripple = document.createElement('span');
            const taille = Math.max(rect.width, rect.height);

            ripple.className = 'ripple';
            ripple.style.width = ripple.style.height = `${taille}px`;
            ripple.style.left = `${e.clientX - rect.left - taille / 2}px`;
            ripple.style.top = `${e.clientY - rect.top - taille / 2}px`;

            this.appendChild(ripple);
            ripple.addEventListener('animationend', () => ripple.remove());
        });
    });

    // ---------- Comptage progressif des chiffres (dashboard) ----------
    const compteurs = document.querySelectorAll('[data-compteur]');

    const reduitMouvement = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

    const lancerCompteur = (el) => {
        const cible = parseInt(el.getAttribute('data-compteur'), 10) || 0;

        if (reduitMouvement) {
            el.textContent = cible.toLocaleString('fr-FR');
            return;
        }

        const duree = 900;
        const debut = performance.now();

        const etape = (maintenant) => {
            const avancement = Math.min((maintenant - debut) / duree, 1);
            const facile = 1 - Math.pow(1 - avancement, 3);
            el.textContent = Math.round(cible * facile).toLocaleString('fr-FR');
            if (avancement < 1) {
                requestAnimationFrame(etape);
            }
        };

        requestAnimationFrame(etape);
    };

    if ('IntersectionObserver' in window && compteurs.length) {
        const observateurCompteurs = new IntersectionObserver((entrees) => {
            entrees.forEach((entree) => {
                if (entree.isIntersecting) {
                    lancerCompteur(entree.target);
                    observateurCompteurs.unobserve(entree.target);
                }
            });
        }, { threshold: 0.4 });

        compteurs.forEach((el) => observateurCompteurs.observe(el));
    } else {
        compteurs.forEach((el) => { el.textContent = el.getAttribute('data-compteur'); });
    }

    // ---------- Apparition progressive au scroll ----------
    const elementsAAnimer = document.querySelectorAll('.page-content .reveal');

    if ('IntersectionObserver' in window && elementsAAnimer.length) {
        const observateur = new IntersectionObserver((entrees) => {
            entrees.forEach((entree) => {
                if (entree.isIntersecting) {
                    entree.target.classList.add('en-vue');
                    observateur.unobserve(entree.target);
                }
            });
        }, { threshold: 0.15 });

        elementsAAnimer.forEach((el) => observateur.observe(el));
    } else {
        elementsAAnimer.forEach((el) => el.classList.add('en-vue'));
    }
});