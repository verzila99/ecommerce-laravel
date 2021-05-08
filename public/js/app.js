let loginButton = document.querySelector(".login"),
    closeModalArea = document.querySelector(".modal-background"),
    closeModalButton = document.querySelector(".delete"),
    loginTab = document.querySelector(".login-tab"),
    registerTab = document.querySelector(".register-tab"),
    loginModal = document.querySelector(".login-modal"),
    registerModal = document.querySelector(".register-modal");

loginTab.addEventListener("click", () => {
    registerTab.classList.remove("is-active");
    registerModal.style.display = "none";
    loginTab.classList.add("is-active");
    loginModal.style.display = "flex";
});
registerTab.addEventListener("click", () => {
    loginTab.classList.remove("is-active");
    loginModal.style.display = "none";
    registerTab.classList.add("is-active");
    registerModal.style.display = "flex";
});

loginButton.addEventListener("click", () => {
    document.querySelector(".modal").classList.add("is-active");
    document.querySelector("html").classList.add("is-clipped");
});
closeModalButton.addEventListener("click", () => {
    document.querySelector(".modal").classList.remove("is-active");
    document.querySelector("html").classList.remove("is-clipped");
});
closeModalArea.addEventListener("click", () => {
    document.querySelector(".modal").classList.remove("is-active");
    document.querySelector("html").classList.remove("is-clipped");
});
