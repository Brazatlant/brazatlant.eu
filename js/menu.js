document.addEventListener("DOMContentLoaded", () => {
    const menuElement = document.getElementById("menu");

    if (!menuElement) {
        console.error("Menu element with ID 'menu' not found");
        return;
    }

    fetch('../json/menu.json')
    .then(response => {
        if (!response.ok) {
            throw new Error('Erreur réseau ou fichier introuvable');
        }
        return response.json();
    })
    .then(data => {
        console.log('Données reçues :', data); // Debugging

        const menuItems = Array.isArray(data.menu) ? data.menu : []; // Vérification et fallback

        if (menuItems.length === 0) {
            console.warn("Attention : le menu est vide ou mal formaté.");
        }

        menuElement.innerHTML = ""; // Reset du menu

        menuItems.forEach(item => {
            if (!item) return;
            const li = document.createElement("li");
            const a = document.createElement("a");

            a.href = item.link || "#";
            a.textContent = item.title || "Sans titre";

            if (item.button) {
                a.classList.add("btn");
            }

            li.appendChild(a);

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