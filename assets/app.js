import "./styles/app.css";

import "materialize-css/dist/css/materialize.min.css";

import "materialize-css/dist/js/materialize.js";

document.addEventListener("DOMContentLoaded", function() {
    var elems = document.querySelectorAll(".modal");
    var instances = M.Modal.init(elems);
});
