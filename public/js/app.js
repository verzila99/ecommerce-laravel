axios.defaults.withCredentials = true;
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

//add to cart
//     let toCartButton = document.querySelector(".add-to-cart");
//     toCartButton.addEventListener("click", ()=>{
//
//     })
// login
axios.defaults.withCredentials = true;
let registerButton = document.getElementById('register');
    registerButton.addEventListener("click", ev => {
        let name = document.getElementById('register-name').value;
        let email = document.getElementById('register-email').value;
        let password = document.getElementById('register-password').value;
        let passwordconfirmation = document.getElementById('register-confirmation').value;
        axios.get('/sanctum/csrf-cookie').then(response => {
            axios.post('/register', {
                name: name,
                email: email,
                password: password,
                password_confirmation:passwordconfirmation
            }).then(res => console.log(res))
                .catch(error=>{
                    if (error.response) {
                      Object.values(error.response.data.errors).forEach(value => {
                          value.forEach(e => {
                              let i = document.createElement('p');
                              i.classList.add('has-text-danger');
                              i.innerHTML=e;
                              document.getElementById('register-error').appendChild(i);
                          });
                      });

                    }


                // document.getElementById('register-error').innerHTML = error.errors.email[0];
            });
        });
    });
