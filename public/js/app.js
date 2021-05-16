axios.defaults.withCredentials = true;
let profileButton = document.querySelector(".login"),
    closeModalArea = document.querySelector(".modal-background"),
    closeModalButton = document.querySelector(".delete"),
    loginTab = document.querySelector(".login-tab"),
    registerTab = document.querySelector(".register-tab"),
    loginModal = document.querySelector(".login-modal"),
    registerModal = document.querySelector(".register-modal"),
    modal = document.querySelector(".modal"),
    htmlElement = document.querySelector("html");

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
if(profileButton){
    profileButton.addEventListener("click", () => {
        modal.classList.add("is-active");
        htmlElement.classList.add("is-clipped");
    });
}

closeModalButton.addEventListener("click", () => {
    modal.classList.remove("is-active");
    htmlElement.classList.remove("is-clipped");
});
closeModalArea.addEventListener("click", () => {
    modal.classList.remove("is-active");
    htmlElement.classList.remove("is-clipped");
});

//add to cart
//     let toCartButton = document.querySelector(".add-to-cart");
//     toCartButton.addEventListener("click", ()=>{
//
//     })
// register
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
            password_confirmation: passwordconfirmation
        }).then(response => {
            if (response.status === 200) {
                window.location.reload(true);
            }
        })
            .catch(error => {
                if (error.response) {
                    Object.values(error.response.data.errors).forEach(value => {
                        value.forEach(e => {
                            let i = document.createElement('p');
                            i.classList.add('has-text-danger');
                            i.innerHTML = e;
                            document.getElementById('register-error').appendChild(i);
                        });
                    });
                }
            });
    });
});
//login
let loginButton = document.getElementById('login-button');
loginButton.addEventListener("click", ev => {
    let email = document.getElementById('login-email').value;
    let password = document.getElementById('login-password').value;

    axios.get('/sanctum/csrf-cookie').then(response => {
        axios.post('/login', {
            email: email,
            password: password,
        }).then(response => {
            if (response.status === 200) {
                console.log(response);
                window.location.reload(true);
            }
        })
            .catch(error => {
                if (error.response.status === 422) {
                    Object.values(error.response.data.errors).forEach(value => {
                        value.forEach(e => {
                            let i = document.createElement('p');
                            i.classList.add('has-text-danger');
                            i.innerHTML = e;
                            document.getElementById('login-error').appendChild(i);
                        });
                    });
                } else {
                    document.getElementById('login-error').innerHTML = 'Неправильный Email или пароль';
                }


            });
    });
});
let loginForm = document.querySelector(".login-form");
let inputs = loginForm.querySelectorAll("input");
inputs.forEach((elem=>{
    elem.addEventListener("keyup", function (event) {
        // Число 13 в "Enter" и клавиши на клавиатуре
        if (event.keyCode === 13) {
            // При необходимости отмените действие по умолчанию
            event.preventDefault();
            // Вызов элемента button одним щелчком мыши
            elem.parentNode.parentNode.parentNode.querySelector(".send-form").click();
        }
    });
}));


//favorites
let favorites = document.querySelectorAll('.favorites');
let favoritesLink = document.getElementById('favorites-link');
    if(favoritesLink.dataset.status==='quest'){
        favoritesLink.addEventListener("click", () =>{
            modal.classList.add("is-active");
            htmlElement.classList.add("is-clipped");
        });
    }
favorites.forEach((elem) => {
    elem.addEventListener("click", () => {
            if (elem.getAttribute('id') === 'favorite-guest') {
                modal.classList.add("is-active");
                htmlElement.classList.add("is-clipped");
            } else {
                let category = elem.getAttribute('data-category');
                let productId = elem.getAttribute('data-productId');
                let favoritesStatus = +elem.getAttribute('data-status');
                if (favoritesStatus === 1) {

                    axios.delete('/addtofavorites/' + category + '/'+ productId).then(response => {
                        if (response.status === 200) {
                            console.log(response);
                            let heart = document.createElement('i');
                            heart.classList.add('far');
                            heart.classList.add('fa-heart');
                            let oldChild = elem.querySelector('i');
                            oldChild.replaceWith(heart);
                            elem.querySelector('p').innerHTML = 'В избранноe';
                            elem.dataset.status = '0';
                        }
                    })
                        .catch(error => {
                            console.log(error);
                        } );
                } else if (favoritesStatus === 0) {


                        axios.patch('/addtofavorites', {
                            category: category,
                            productId: productId,
                        }).then(response => {

                            if (response.status === 200) {
                                let heart = document.createElement('i');
                                heart.classList.add('fas');
                                heart.classList.add('fa-heart');
                                let oldChild = elem.querySelector('i');
                                oldChild.replaceWith(heart);

                                elem.querySelector('p').innerHTML = 'В избранном';
                                elem.dataset.status='1';

                            }
                        })


                        .catch(error => {
                            console.log(error);
                            }
                        );
                }
            }

        }
    );
});
