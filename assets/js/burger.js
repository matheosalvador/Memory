// /assets/js/burger.js
document.addEventListener("DOMContentLoaded", () => {
    const burger = document.querySelector(".burger");
    const nav = document.querySelector(".nav-container");

    if (!burger || !nav) return; // sécurité si une page n’a pas ces éléments

    burger.addEventListener("click", () => {
        burger.classList.toggle("active");
        nav.classList.toggle("mobile-active");
        document.body.classList.toggle("menu-open");
    });
});
