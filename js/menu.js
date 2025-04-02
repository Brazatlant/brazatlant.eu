document.addEventListener("DOMContentLoaded", () => {
    const menuElement = document.getElementById("menu");

    // Charger le fichier menu.json
    const menuData = {
        "menu": [
            {   
                "title": "Home",
                "submenu": [
                    { "title": "Ciel", "link": "../index.html" },
                    { "title": "Panel admin", "link": "php/admin.php" }
                ],
                "button": true
            },
            {
                "title": "About",
                "submenu": [
                    { "title": "Mon Twitch !", "link": "https://twitch.tv/brazatlant" },
                    { "title": "Mon discord", "link": "#" }
                ],
                "button": true
            },
            {
                "title": "Contact",
                "link": "../html/contact.html",
                "button": true
            },
            {
                "title": "Sign in",
                "link": "../html/login.html",
                "button": true
            }
        ]
    };

    // Vider le contenu existant du menu pour éviter les doublons
    menuElement.innerHTML = "";

    // Générer les éléments du menu principal
    menuData.menu.forEach(item => {
        const li = document.createElement("li");
        const a = document.createElement("a");
        a.href = item.link || "#"; // Utiliser "#" si aucun lien n'est défini
        a.textContent = item.title;

        // Ajouter une classe pour les boutons si nécessaire
        if (item.button) {
            a.classList.add("btn");
        }

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
});