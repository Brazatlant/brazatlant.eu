document.addEventListener("DOMContentLoaded", () => {
    const menuElement = document.getElementById("menu");

    if (!menuElement) {
        console.error("Menu element with ID 'menu' not found");
        return;
    }

    // Simuler une variable PHP injectée dans le HTML pour indiquer si l'utilisateur est connecté
    const isLoggedIn = window.isLoggedIn || false; // Remplacez par une variable PHP injectée
    const username = window.username || "Utilisateur"; // Remplacez par une variable PHP injectée

    // Charger le fichier JSON
    fetch('../js/json/menu.json')
        .then(response => {
            if (!response.ok) {
                throw new Error('Erreur réseau ou fichier introuvable');
            }
            return response.json(); // Convertir la réponse en objet JS
        })
        .then(data => {
            const menuItems = data.menu;

            if (!Array.isArray(menuItems)) {
                console.error("Erreur : menuItems n'est pas un tableau. Valeur reçue :", menuItems);
                return;
            }

            menuElement.innerHTML = ""; // Réinitialiser le contenu du menu

            // Construire les éléments du menu
            menuItems.forEach(item => {
                if (!item) return;

                // Vérifier si l'élément doit être affiché en fonction de l'état de connexion
                if (item.requiresLogin && !isLoggedIn) return;
                if (!item.requiresLogin && isLoggedIn && item.title === "Sign in") return;

                const li = document.createElement("li");
                const a = document.createElement("a");

                // Définir les propriétés du lien
                a.href = item.link || "#";
                a.textContent = item.title || "Sans titre";

                // Remplacer "Sign in" par le nom d'utilisateur si connecté
                if (isLoggedIn && item.title === "Menu") {
                    a.textContent = username;
                }

                // Ajouter une classe pour les boutons si nécessaire
                if (item.button) {
                    a.classList.add("btn");
                }

                li.appendChild(a);

                // Gérer les sous-menus si présents
                if (Array.isArray(item.submenu) && item.submenu.length > 0) {
                    const submenu = document.createElement("ul");
                    submenu.classList.add("dropdown-menu");

                    item.submenu.forEach(subitem => {
                        if (!subitem) return;

                        const subLi = document.createElement("li");
                        const subA = document.createElement("a");
                        subA.href = subitem.link || "#";
                        subA.textContent = subitem.title || "Sans titre";
                        subLi.appendChild(subA);
                        submenu.appendChild(subLi);
                    });

                    li.classList.add("dropdown");
                    li.appendChild(submenu);
                }

                menuElement.appendChild(li);
            });
        })
        .catch(error => {
            console.error("Erreur lors du chargement du menu :", error);
        });
});