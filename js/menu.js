document.addEventListener("DOMContentLoaded", () => {
    const menuElement = document.getElementById("menu");

    // Charger le fichier menu.json
    fetch("../json/menu.json") // Assurez-vous que le chemin est correct
        .then(response => {
            if (!response.ok) {
                throw new Error("Erreur lors du chargement du menu.");
            }
            return response.json();
        })
        .then(data => {
            // Vider le contenu existant du menu pour éviter les doublons
            menuElement.innerHTML = "";

            // Générer les éléments du menu principal
            data.menu.forEach(item => {
                const li = document.createElement("li");
                const a = document.createElement("a");
                a.href = item.link || "#"; // Utiliser "#" si aucun lien n'est défini
                a.textContent = item.title;
                li.appendChild(a);

                // Vérifier si l'élément a un sous-menu
                if (item.submenu) {
                    const submenu = document.createElement("ul");
                    submenu.classList.add("dropdown-menu"); // Ajouter la classe pour le style des sous-menus

                    item.submenu.forEach(subitem => {
                        const subLi = document.createElement("li");
                        const subA = document.createElement("a");
                        subA.href = subitem.link || "#";
                        subA.textContent = subitem.title;
                        subLi.appendChild(subA);
                        submenu.appendChild(subLi);
                    });

                    li.classList.add("dropdown"); // Ajouter la classe pour le style des éléments avec sous-menus
                    li.appendChild(submenu);
                }

                menuElement.appendChild(li);
            });
        })
        .catch(error => {
            console.error("Erreur :", error);
        });
});