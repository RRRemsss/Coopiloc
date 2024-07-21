function initBurgerMenuToggle() {
    const burgerMenu = document.querySelector(".toggle-btn");
    const sidebar = document.querySelector("#sidebar");
    const mainContent = document.querySelector("main");

    if (burgerMenu) {
        burgerMenu.addEventListener("click", () => {
            sidebar.classList.toggle("expand");
            mainContent.classList.toggle("expand");
        });
    }
}

// Function calls when init page
document.addEventListener("DOMContentLoaded", initBurgerMenuToggle);

// Function calls when reload page with turbo Function
document.addEventListener('turbo:load', initBurgerMenuToggle);

