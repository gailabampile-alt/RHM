// script.js
function showDiv(divNumber) {
    // Cacher toutes les divs
    var divs = document.querySelectorAll('.boite');
    divs.forEach(function(div) {
        div.classList.remove('active');
    });

    // Afficher la div sélectionnée
    var activeDiv = document.getElementById('div' + divNumber);
    activeDiv.classList.add('active');
}