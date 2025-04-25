// Navbar
const bars = document.querySelector('.bars');
const menu = document.querySelector('.nav-items');

bars.addEventListener('click', () => {
    menu.classList.toggle('show-menu');
});

document.addEventListener('mouseup', (e) => {
    if (!menu.contains(e.target) && !bars.contains(e.target)) {
        menu.classList.remove('show-menu');
    }
});

// Main Section
document.addEventListener("DOMContentLoaded", function () {
    const params = new URLSearchParams(window.location.search);
    const categoryId = parseInt(params.get('recetteCategory')) || 0;

    function regrouperToutesLesRecettes(data) {
        const toutesLesRecettes = [];
        data.categories.forEach(categorie => {
            categorie.recettes.forEach(recette => {
                toutesLesRecettes.push(recette);
            });
        });
        return toutesLesRecettes;
    }

    let recettesAfficher = [];
    let pageTitle = "Toutes les Recettes";

    if (categoryId === 0) {
        recettesAfficher = regrouperToutesLesRecettes(recettesData);
    } else {
        const category = recettesData.categories.find(c => c.id === categoryId);

        if (category && category.recettes && Array.isArray(category.recettes)) {
            recettesAfficher = category.recettes;
            pageTitle = category.titre;
        } else {
            document.querySelector('.recipe-container').innerHTML = `<p>Pas de recettes disponibles pour cette catégorie.</p>`;
            return;
        }
    }

    document.title = `Tea Spoon - ${pageTitle}`;

    if (recettesAfficher.length > 0) {
        const container = document.querySelector('.recipe-container');
        container.innerHTML = `
            <div class="recipes-header">
                <h2>${pageTitle}</h2>
                <p>${categoryId === 0 ? "Explorez toutes nos recettes, réunies en un seul endroit." : recettesData.categories.find(c => c.id === categoryId).description}</p>
            </div>
            <div class="recipe-grid">
                ${recettesAfficher.map(recette => `
                    <a href="recette.html?recette=${recette.id}&recetteCategory=${categoryId}">
                        <div class="recipe-card">
                            <div class="image" style="background-image: url('${recette.image}');"></div>
                            <p>${recette.titre}</p>
                        </div>
                    </a>
                `).join('')}
            </div>
        `;
    } else {
        document.querySelector('.recipe-container').innerHTML = `<p>Pas de recettes disponibles.</p>`;
    }
});