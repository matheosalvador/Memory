document.addEventListener("DOMContentLoaded", function () {
    const burger = document.querySelector(".burger");
    const nav = document.querySelector(".nav-container");

    if (burger && nav) {
        burger.addEventListener("click", function () {
            burger.classList.toggle("active");
            nav.classList.toggle("mobile-active");
            document.body.classList.toggle("menu-open");
        });
    }
});
