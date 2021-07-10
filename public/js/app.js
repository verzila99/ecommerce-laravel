axios.defaults.withCredentials = true;

renderCartButton();

//login modal
let profileButton = document.querySelectorAll(".login"),
    closeModalArea = document.querySelector(".modal-background"),
    closeModalButton = document.querySelector(".delete"),
    loginTab = document.querySelector(".login-tab"),
    registerTab = document.querySelector(".register-tab"),
    loginModal = document.querySelector(".login-modal"),
    registerModal = document.querySelector(".register-modal"),
    modal = document.querySelector(".modal"),
    htmlElement = document.querySelector("html");

if (loginTab) {
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
}
if (profileButton) {
    profileButton.forEach((el) => {
        el.addEventListener("click", () => {
            modal.classList.add("is-active");
            htmlElement.classList.add("is-clipped");
        });
    });
}
if (closeModalButton) {
    closeModalButton.addEventListener("click", () => {
        modal.classList.remove("is-active");
        htmlElement.classList.remove("is-clipped");
    });
    closeModalArea.addEventListener("click", () => {
        modal.classList.remove("is-active");
        htmlElement.classList.remove("is-clipped");
    });
}

// register
axios.defaults.withCredentials = true;
let registerButton = document.getElementById('register');
if (registerButton) {
    registerButton.addEventListener("click", () => {
        let name = document.getElementById('register-name').value;
        let email = document.getElementById('register-email').value;
        let password = document.getElementById('register-password').value;
        let passwordConfirmation = document.getElementById('register-confirmation').value;

        if (document.querySelector('.register-error-message')) {
            document.querySelector('.register-error-message').remove();
        }

        axios.get('/sanctum/csrf-cookie').then(() => {
            axios.post('/register', {
                name: name,
                email: email,
                password: password,
                password_confirmation: passwordConfirmation
            }).then(response => {

                if (response.status === 200) {
                    window.location.href = '/email/verify';
                }
            })
                 .catch(error => {
                     console.log(error);
                     if (error.response) {
                         Object.values(error.response.data.errors).forEach(value => {
                             value.forEach(e => {
                                 let i = document.createElement('p');
                                 i.classList.add('has-text-danger');
                                 i.classList.add('register-error-message');
                                 i.innerHTML = e;
                                 document.getElementById('register-error').appendChild(i);
                             });
                         });
                     }
                 });
        });
    });
}
//login
let loginButton = document.getElementById('login-button');
if (loginButton) {
    loginButton.addEventListener("click", () => {
        let email = document.getElementById('login-email').value;
        let password = document.getElementById('login-password').value;
        let rememberToken = document.getElementById('login-remember').value;

        if (document.querySelector('.login-error-message')) {
            document.querySelector('.login-error-message').remove();
        }

        axios.get('/sanctum/csrf-cookie').then(() => {
            axios.post('/login', {
                email: email,
                password: password,
                remember_token: rememberToken,
            }).then(response => {
                if (response.status === 200) {
                    window.location.reload(true);
                }
            })
                 .catch(error => {

                     let i = document.createElement('p');
                     i.classList.add('has-text-danger');
                     i.classList.add('login-error-message');
                     i.innerHTML = String(error.response.data);
                     document.getElementById('login-error').appendChild(i);

                 });
        });
    });
}
let loginForm = document.querySelector(".login-form");
if (loginForm) {
    let inputs = loginForm.querySelectorAll("input");
    inputs.forEach((elem => {
        elem.addEventListener("keyup", function (event) {
            // Число 13 в "Enter" и клавиши на клавиатуре
            if (event.key === 'Enter') {
                // При необходимости отмените действие по умолчанию
                event.preventDefault();
                // Вызов элемента button одним щелчком мыши
                elem.parentNode.parentNode.parentNode.querySelector(".send-form").click();
            }
        });
    }));
}

//favorites
let favorites = document.querySelectorAll('.favorites');
let favoritesLink = document.getElementById('favorites-link');
if (favoritesLink.dataset.status === 'quest') {
    favoritesLink.addEventListener("click", () => {
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

                                      axios.delete('/removefromfavorites/', {data: {productId: productId}}).then(response => {
                                          if (response.status === 200) {
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
                                           });
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

                                              elem.querySelector('p').innerHTML = 'In favorite';
                                              elem.dataset.status = '1';

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

// Cart logic
let addToCartButtons = document.querySelectorAll('.add-to-cart');

addToCartButtons.forEach(elem => {

    let id = elem.dataset.id;

    if (checkCookie(id)) {
        changeAddToCartButton(elem);
    }


    elem.addEventListener('click', () => {
        let productId = elem.dataset.id;
        if (document.cookie.includes('cart') && document.cookie.match(/cart=[0-9,]+/g)) {

            if (!checkCookie(productId)) {
                let productString = document.cookie.match(/cart=[0-9,]+/g)[0];
                document.cookie = productString + ',' + productId + ';max-age=5000000;SameSite=Lax;path=/';
                changeAddToCartButton(elem);
                renderCartButton();

            }
        } else {
            document.cookie = 'cart=' + productId + ';max-age=5000000;SameSite=Lax;path=/';
            changeAddToCartButton(elem);
            renderCartButton();
        }
    });
});

function changeAddToCartButton(elem) {
    elem.innerHTML = 'Go to cart';
    elem.classList.add('in-cart-button');
    setTimeout(() => elem.setAttribute('href', '/cart'), 100);
}

function checkCookie(value) {
    if (document.cookie.includes('cart') && document.cookie.match(/cart=[0-9,]+/g)) {
        let productsArray = document.cookie
                                    .match(/cart=[0-9,]+/g)[0]
            .replace(/cart=/g, '')
            .split(',');
        return productsArray.indexOf(value) !== -1;

    }
}

function renderCartButton() {
    let cartNavbar = document.querySelectorAll('.cart-navbar');
    cartNavbar.forEach((elem) => {

        let cartNavbarText = elem.querySelector('.cart-text');

        if (window.location.pathname === '/order/confirm') {

            axios.get('/api/cart/sum-of-order')
                 .then(res => {
                     if (res.status === 200 && res.data === 0) {
                         cartNavbarText.style.fontWeight = '400';
                         cartNavbarText.innerText = 'Cart';
                     } else {
                         cartNavbarText.style.fontWeight = '700';
                         cartNavbarText.innerText = '$ ' + res.data / 100;
                     }

                 }).catch(error => {
                console.log(error);
            });
        } else {

            axios.get('/api/cart/sum-of-products')
                 .then(res => {
                     if (res.status === 200 && res.data === 0) {
                         cartNavbarText.style.fontWeight = '400';
                         cartNavbarText.innerText = 'Cart';
                     } else {
                         cartNavbarText.style.fontWeight = '700';
                         cartNavbarText.innerText = '$ ' + res.data / 100;
                     }

                 }).catch(error => {
                console.log(error);
            });
        }


    })
    ;

}

//Searching

let searchInput = document.getElementById('main-search');
let closeModal = document.getElementById('close-modal');
let searchParent = document.querySelector('.search-results');
let html = document.querySelector('html');
let searchTimeout;
let searchString = '';
searchInput.addEventListener('keyup', (elem) => {

    searchString = elem.target.value;

    if (searchTimeout) {
        clearInterval(searchTimeout);

    }

    if (searchString) {
        searchTimeout = setTimeout(getSearchResult, 800);
    } else {
        closeModals();
    }

    function getSearchResult() {

        axios.get('/api/search?search_string=' + encodeURIComponent(searchString))
             .then(response => {

                 if (response.status === 200) {

                     if (response.data.length === 0) {

                         while (searchParent.lastChild) {
                             searchParent.lastChild.remove();
                         }

                         let div = document.createElement('div');
                         div.classList.add('search-item');
                         div.innerHTML = 'No items found';
                         searchParent.appendChild(div);


                     } else {

                         while (searchParent.lastChild) {
                             searchParent.lastChild.remove();
                         }

                         response.data.forEach((el) => {
                             let div = document.createElement('a');

                             div.classList.add('search-item');

                             div.innerHTML = `<p>${el.title}</p> <b>$ ${el.price}</b>`;

                             div.setAttribute('href', `/${el.category}/${el.id}`);
                             searchParent.appendChild(div);

                         });
                     }
                     openSearchResults();
                 }
             }).catch(error => {
            console.log(error);
        });

    }
});
closeModal.addEventListener('click', () => {
    closeModals();
});

function openSearchResults() {
    html.classList.add('is-clipped');
    searchParent.style.display = 'block';
    closeModal.style.display = 'block';
}

function closeModals() {
    html.classList.remove('is-clipped');
    closeModal.style.display = 'none';
    searchParent.style.display = 'none';
    catalogTrigger.parentElement.classList.remove('is-active');
    document.querySelector('.category-list__sorting')?.classList.remove('showing');
    document.querySelector('.category-filter')?.classList.remove('show-sidebar');
    closeModal.classList.remove('filter-active');
}

//news subscription

let emailNewsSubscription = document.querySelector('#email-news-subscription');
let submitNewsSubscription = document.querySelector('#submit-news-subscription');

if (submitNewsSubscription) {
    submitNewsSubscription.addEventListener('click', (e) => {
        e.preventDefault();

        axios.get('/sanctum/csrf-cookie').then(() => {
            axios.post('/subscribe', {email: emailNewsSubscription.value}).then((res) => {

                if (res.status === 200) {

                    submitNewsSubscription.parentNode.parentNode.parentElement.remove();

                    document.querySelector('.subscription').innerHTML = `<h3 class="is-size-3 has-text-success">Subscribed!</h3>`;
                }
            }).catch(err => {

                submitNewsSubscription.parentNode.innerHTML = `<p class="has-text-danger is-size-4">${err.response.data}</p>`;
                console.log(err.response);
            });
        });
    });
}
// catalog trigger
let catalogTrigger = document.querySelector('.catalog-trigger');
if (catalogTrigger) {
    catalogTrigger.addEventListener('click', () => {
        if (catalogTrigger.classList.contains('is-active')) {
            catalogTrigger.parentElement.classList.remove('is-active');
            closeModal.style.display = 'none';
        } else {
            catalogTrigger.parentElement.classList.add('is-active');
            closeModal.style.display = 'block';
        }
    });
}

//sorting trigger
let sortingTouchButton = document.querySelector('.sorting-button-touch');
if (sortingTouchButton) {
    sortingTouchButton.addEventListener('click', () => {
        document.querySelector('.category-list__sorting').classList.add('showing');
        html.classList.add('is-clipped');
        closeModal.style.display = 'block';
    });

}

//filter trigger
let filterShowButton = document.querySelector('.sidebar-trigger');
if (filterShowButton) {

    filterShowButton.addEventListener('click', () => {
        document.querySelector('.category-filter').classList.add('show-sidebar');
        html.classList.add('is-clipped');
        closeModal.style.display = 'block';
        closeModal.classList.add('filter-active');
    });
}
// Sticky Navbar
let navbar = document.querySelector('.navbar');

window.addEventListener('scroll', function () {
    if (pageYOffset > 100) {
        navbar.classList.remove('normBar');
        navbar.classList.add('sticky');
    } else {
        navbar.classList.remove('sticky');
        navbar.classList.add('normBar');
    }
});

//Orders accordion
let accordionButtons = document.querySelectorAll('.order-title');
if (accordionButtons.length > 0) {
    accordionButtons.forEach((el) => {
        let orderHeight = el.parentElement.clientHeight;
        el.addEventListener('click', (e) => {
            if (el.classList.contains('active-order-tab')) {
                el.classList.remove('active-order-tab');
                el.parentElement.parentElement.style.height = orderHeight + 60 + 'px';
                el.querySelector('.category-filter__arrow').classList.add('reverse');
            } else {
                el.classList.add('active-order-tab');
                el.parentElement.parentElement.style.height = 60 + 'px';
                el.querySelector('.category-filter__arrow').classList.remove('reverse');
            }
        });
    });
}
