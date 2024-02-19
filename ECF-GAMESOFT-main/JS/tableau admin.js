// script.js

// Fonction pour trier le tableau par colonne
function sortTable(columnIndex) {
    var table, rows, switching, i, x, y, shouldSwitch;
    table = document.querySelector("table");
    switching = true;
    while (switching) {
        switching = false;
        rows = table.getElementsByTagName("tr");
        for (i = 1; i < (rows.length - 1); i++) {
            shouldSwitch = false;
            x = rows[i].getElementsByTagName("td")[columnIndex];
            y = rows[i + 1].getElementsByTagName("td")[columnIndex];
            if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {
                shouldSwitch = true;
                break;
            }
        }
        if (shouldSwitch) {
            rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
            switching = true;
        }
    }
}

// Exemple d'utilisation pour activer le tri lorsqu'un en-tête de colonne est cliqué
document.addEventListener("DOMContentLoaded", function() {
    var headers = document.querySelectorAll("th[data-column]"); // Sélectionnez les en-têtes avec l'attribut data-column
    for (var i = 0; i < headers.length; i++) {
        headers[i].addEventListener("click", function() {
            var columnIndex = this.getAttribute("data-column"); // Obtenez la valeur de l'attribut data-column
            sortTable(columnIndex);
        });
    }
});

