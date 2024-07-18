/************************************SIDEBAR DYNAMIC********************************************/

function initBurgerMenuToggle() {
    const burgerMenu = document.querySelector(".toggle-btn");
    if (burgerMenu) {
        burgerMenu.addEventListener("click", () => {
            document.querySelector("#sidebar").classList.toggle("expand");
            // document.querySelector("#sidebar").classList.toggle("col-md-1");
            // document.querySelector("#sidebar").classList.toggle("col-md-2");
        });
    }
}

// Function calls when init page
document.addEventListener("DOMContentLoaded", initBurgerMenuToggle);

// Function calls when reload page with turbo Function
document.addEventListener('turbo:load', initBurgerMenuToggle);
