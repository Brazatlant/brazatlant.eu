document.addEventListener("DOMContentLoaded", () => {
    fetch("json/menu.json")
        .then(response => response.json())
        .then(data => {
            const nav = document.querySelector("nav ul");
            nav.innerHTML = ""; // Nettoyer le menu avant d'ajouter les éléments

            data.menu.forEach(item => {
                const li = document.createElement("li");

                if (item.submenu) {
                    li.classList.add("dropdown");
                    const a = document.createElement("a");
                    a.href = "#";
                    a.textContent = item.title;

                    const ul = document.createElement("ul");
                    ul.classList.add("dropdown-menu");

                    item.submenu.forEach(sub => {
                        const subLi = document.createElement("li");
                        const subA = document.createElement("a");
                        subA.href = sub.link;
                        subA.textContent = sub.title;
                        subLi.appendChild(subA);
                        ul.appendChild(subLi);
                    });

                    li.appendChild(a);
                    li.appendChild(ul);
                } else {
                    const a = document.createElement("a");
                    a.href = item.link;
                    a.textContent = item.title;

                    if (item.button) {
                        a.classList.add("btn");
                    }

                    li.appendChild(a);
                }

                nav.appendChild(li);
            });
        })
        .catch(error => console.error("Erreur lors du chargement du menu :", error));
});
