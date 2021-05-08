// Cart

function cart() {
    let products = document.querySelectorAll(".cart-row"),
        finalSumDiv = document.querySelector(".cart-summary__sum--number"),
        sumOfProducts = 0;

    products.forEach((product) => {
        let increaseQuantity = product.querySelector(".increase-quantity"),
            decreaseQuantity = product.querySelector(".decrease-quantity"),
            handInput = product.querySelector("input"),
            deleteProduct = product.querySelector(".deleteItem"),
            priceOfProduct = +product.querySelector(".price").textContent,
            quantityOfProducts = +handInput.value,
            finalPriceDiv = product.querySelector(".finalPrice");

        renderPrice();

        function renderPrice() {
            if (typeof quantityOfProducts === "number") {
                if (quantityOfProducts >= 0) {
                    finalPriceValue = priceOfProduct * quantityOfProducts;
                    finalPriceDiv.textContent = finalPriceValue;
                    sumOfProducts += finalPriceValue;
                } else {
                    quantityOfProducts = 0;
                    handInput.value = quantityOfProducts;
                }
            }
        }
        deleteProduct.addEventListener("click", () => {
            product.remove();
            renderSummaryPrice();
            console.log(document.querySelector(".cart-row"));
            if (document.querySelector(".cart-row") == null) {
                document.querySelector(".cart").remove();
                document.querySelector(".noitems").style.display = "flex";
            }
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
            console.log(quantityOfProducts);
        });
    });

    renderSummaryPrice();

    function renderSummaryPrice() {
        let allPrices = document.querySelectorAll(".finalPrice");
        let summaryPrice = 0;
        allPrices.forEach((elem) => {
            summaryPrice += +elem.textContent;
        });

        finalSumDiv.textContent = summaryPrice;
    }
}
cart();
