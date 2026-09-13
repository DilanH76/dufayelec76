const hamburger = document.getElementById('burger-menu');
const navLinks = document.querySelector('.nav-links');
const links = document.querySelectorAll('.nav-links li a');

// 1. Ouvre/Ferme le menu quand on clique sur le hamburger
hamburger.addEventListener('click', () => {
    navLinks.classList.toggle('active');
});

// 2. Ferme le menu automatiquement quand on clique sur un lien
links.forEach(link => {
    link.addEventListener('click', () => {
        navLinks.classList.remove('active');
    });
});

// --- FORMATAGE EN DIRECT DU CHAMP TÉLÉPHONE ---
const telInput = document.getElementById('telephone');

if (telInput) {
    telInput.addEventListener('input', function (e) {
        // On remplace instantanément tout ce qui n'est pas un chiffre, un espace, un point, un tiret ou un "+" par "rien"
        this.value = this.value.replace(/[^0-9\s\-\+\.]/g, '');
    });
}


document.getElementById('photos').addEventListener('change', function() {
    const info = document.getElementById('upload-info');
    
    // Vérification du nombre de fichiers
    if (this.files.length > 3) {
        info.textContent = 'Maximum 3 photos autorisées !';
        info.style.color = '#e74c3c';
        this.value = ''; // Vide la sélection
        return;
    }

    // Vérification de la taille de chaque fichier
    let tailleDépassée = false;
    for (let i = 0; i < this.files.length; i++) {
        if (this.files[i].size > 5 * 1024 * 1024) { // 5Mo
            tailleDépassée = true;
            break;
        }
    }

    if (tailleDépassée) {
        info.textContent = 'Une photo dépasse 5Mo !';
        info.style.color = '#e74c3c';
        this.value = ''; // Vide la sélection
        return;
    }

    // Tout est ok
    if (this.files.length > 0) {
        info.textContent = this.files.length + ' photo(s) sélectionnée(s)';
        info.style.color = 'var(--vert-eco)';
    } else {
        info.textContent = 'Aucune photo sélectionnée';
        info.style.color = '#888';
    }
});