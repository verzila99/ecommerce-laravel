// Cart


cart();
noItem();

function cart() {
    let products = document.querySelectorAll(".cart-row"),
        finalSumDiv = document.querySelector(".cart-summary__sum--number"),
        sumOfProducts = 0,
        cartNavbar = document.getElementById('cart-navbar'),
        cartNavbarText = cartNavbar.querySelector('.cart-text'),
        finalPriceWithDeliveryDiv = document.querySelector('.cart-summary__sum--number-final');


    products.forEach((product) => {
        let increaseQuantity = product.querySelector(".increase-quantity"),
            decreaseQuantity = product.querySelector(".decrease-quantity"),
            handInput = product.querySelector(".quantity-of-products"),
            deleteFromCartButton = product.querySelector(".delete-item"),
            quantityOfProducts = +handInput.value,
            finalPriceDiv = product.querySelector(".finalPrice"),
            productId = product.dataset.product_id,
            priceOfProduct = product.dataset.price,
            DeliveryPriceDiv = product.querySelector('.cart-delivery-price');


        renderPrice();

        function renderPrice() {
            if (typeof quantityOfProducts === "number") {
                if (quantityOfProducts >= 0) {
                    let finalPriceValue = +priceOfProduct * quantityOfProducts;

                    finalPriceDiv.innerHTML = finalPriceValue.
                    toLocaleString(
                        undefined);
                    finalPriceDiv.dataset.finalPrice = finalPriceValue;
                } else {
                    quantityOfProducts = 0;
                    handInput.value = quantityOfProducts;
                }
                product.dataset.quantity = quantityOfProducts;
            }
        }


        deleteFromCartButton.addEventListener("click", () => {


            if (document.cookie.includes(productId)) {
                deleteCartCookie(productId);
            }
            product.remove();

            renderSummaryPrice();
            noItem();


        });
        increaseQuantity.addEventListener("click", () => {
            quantityOfProducts++;
            handInput.value = quantityOfProducts;
            renderPrice();
            renderSummaryPrice();

        });
        decreaseQuantity.addEventListener("click", () => {
            quantityOfProducts--;
            handInput.value = quantityOfProducts;
            renderPrice();
            renderSummaryPrice();

        });

        handInput.addEventListener('keyup', () => {
            quantityOfProducts = +handInput.value;
            renderPrice();
            renderSummaryPrice();

        });

    });

    renderSummaryPrice();

    function deleteCartCookie(value) {
        let productsArray = document.cookie
                                    .match(/cart=[0-9,]+/g)[0]
            .replace(/cart=/g, '')
            .split(',');
        let index = productsArray.indexOf(value);
        productsArray.splice(index, 1);
        document.cookie = 'cart=' + productsArray.join(',') + ';';
    }


    function renderSummaryPrice() {

        let allPrices = document.querySelectorAll(".finalPrice");
        let summaryPrice = 0;
        allPrices.forEach((elem) => {
            summaryPrice += +elem.dataset.finalPrice;
            console.log(summaryPrice);
        });

        finalSumDiv.textContent = summaryPrice.toLocaleString(
            undefined);

        if (summaryPrice === 0) {
            cartNavbarText.style.fontWeight = '400';
            cartNavbarText.innerText = 'Корзина';
        } else {
            cartNavbarText.style.fontWeight = '700';
            cartNavbarText.
            innerHTML = summaryPrice.toLocaleString(
                undefined) + ' р.';
        }
        finalPriceWithDeliveryDiv.innerHTML = (+summaryPrice + 944).toLocaleString(
            undefined);
    }

}

function noItem() {
    if (document.querySelector(".cart-row") === null) {
        document.querySelector(".cart").remove();
        document.querySelector(".noitems").style.display = "flex";
    }
}
