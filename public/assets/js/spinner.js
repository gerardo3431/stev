var pre = document.createElement("div");
pre.innerHTML = '<div class="loader-wrapper"><div class="loader">Loading...</div></div>';
document.body.insertBefore(pre, document.body.firstChild);

document.addEventListener("DOMContentLoaded", function(event) {
    document.body.className += " loaded"
});

function mostrarLoader(){
    var loader = document.querySelector(".sidebar-dark");
    // document.querySelector('.load-wrapper').style.backgroundColor = '#acb2b78a;';
    document.querySelector('.loader-wrapper').style.backgroundColor = '#ffffffb0';
    if (loader) {
        loader.classList.remove("loaded");
    }
}

function quitarLoader(){
    var loader = document.querySelector(".sidebar-dark");
    if (loader) {
        loader.className += " loaded";

    }
}