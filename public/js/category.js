//accordion

let accordionTitles = document.querySelectorAll(".accordion-group"),
  showMoreButtons = document.querySelectorAll('.show-more'),
  accordionPrice = document.querySelector('.accordion-price'),
  checkboxInputs = document.querySelectorAll('.checkbox-filter'),
  measuringDiv, measuringDivBottom;

accordionTitles.forEach((elem) => {

  elem.querySelector(".category-filter__title").addEventListener(
    "click",
    () => {


      if (elem.querySelector(".category-filter__title").nextElementSibling.classList.contains('accordion-price')) {

        if (!elem.querySelector('.category-filter__arrow').classList.contains('reverse')) {

          accordionPrice.style.height = '0px';
          elem.querySelector('.category-filter__arrow').classList.add('reverse');
        } else {

          elem.querySelector('.category-filter__arrow').classList.remove('reverse');
          accordionPrice.style.height = '150px';

        }
      } else if (elem.querySelector('.category-filter__arrow').classList.contains('reverse') && elem.querySelector('.show-more').textContent === 'Show more') {

        elem.querySelector(".accordion-item").style.height = '212px';
        elem.querySelector('.category-filter__arrow').classList.remove('reverse');
        elem.querySelector(".show-more").style.height = '20px';

      } else if (elem.querySelector('.category-filter__arrow').classList.contains('reverse') && elem.querySelector('.show-more').textContent === 'Hide') {
        measuringDiv = elem.querySelector('.measuring').clientHeight;
        elem.querySelector(".accordion-item").style.height = 10 + measuringDiv + 'px';
        elem.querySelector('.category-filter__arrow').classList.remove('reverse');
        elem.querySelector(".show-more").style.height = '20px';

      } else if (elem.querySelector('.category-filter__arrow').classList.contains('reverse')) {
        measuringDiv = elem.querySelector('.measuring').clientHeight;
        elem.querySelector(".accordion-item").style.height = 10 + measuringDiv + 'px';
        elem.querySelector('.category-filter__arrow').classList.remove('reverse');

        if (elem.querySelector(".show-more")) {

          elem.querySelector(".show-more").style.height = '20px';
        }
      } else {

        elem.querySelector('.category-filter__arrow').classList.add('reverse');
        elem.querySelector(".accordion-item").style.height = '0px';
        elem.querySelector(".show-more").style.height = '0px';


      }


    }
  );
});

showMoreButtons.forEach((elem) => {

  elem.addEventListener("click", () => {
    measuringDivBottom = elem.previousElementSibling.querySelector('.measuring').clientHeight;

    if (elem.textContent === 'Show more') {
      elem.textContent = 'Hide';
      elem.previousElementSibling.style.height = 10 + measuringDivBottom + 'px';
    } else {
      elem.textContent = 'Show more';
      elem.previousElementSibling.style.height = '13.4rem';
    }

  });


});
// Filtering
let urlObject = new URL(document.location.href);
let urlParams = urlObject.searchParams;
let queryString = decodeURI(urlParams.toString());
let priceFrom = document.querySelector('#price_from');
let priceTo = document.querySelector('#price_to');
let newDiv = document.createElement('a');
newDiv.classList.add('button');
newDiv.classList.add('is-primary');
newDiv.classList.add('absolute-button');


checkboxInputs.forEach(elem => {
  elem.addEventListener('change', () => {

    let parameter = elem.getAttribute('data-parameter') + '[]=' + elem.getAttribute('data-value');
    if (elem.checked) {
      queryString += queryString ? `&${parameter}` : parameter;
      console.log(queryString);
    } else if (!elem.checked) {
      if (queryString.includes('&' + parameter)) {
        queryString = queryString.replace('&' + parameter, '');
      } else if (queryString.includes(parameter)) {
        queryString = queryString.replace(parameter, '');
      }
    }
    axios.get('/api' + urlObject.pathname + '?' + decodeURIComponent(queryString))
         .then(function (response) {
           return response.data;
         })
         .then((res) => {

                 if (res !== 0) {
                   queryString = queryString.replace('?', '');
                   newDiv.innerHTML = 'Найдено:' + res;
                   newDiv.setAttribute('href', urlObject.pathname + '?' + decodeURIComponent(queryString));
                   elem.parentNode.parentNode.parentNode.parentNode.parentNode.appendChild(newDiv);
                 } else {
                   newDiv.innerHTML = '0 найдено';
                   elem.parentNode.parentNode.parentNode.parentNode.parentNode.appendChild(newDiv);
                 }
               }
         )
         .catch(function (error) {
           console.log(error);
         });
  });
});

//range slider
let startSlider = document.querySelector('#range-slider');
let priceFromData = +document.querySelector('#price_from').dataset.value;
let priceFromDataValue = +document.querySelector('#price_from').value;
let priceToData = +document.querySelector('#price_to').dataset.value;
let priceToDataValue = +document.querySelector('#price_to').value;

let inputPriceFrom = document.querySelector('#price_from');
let inputPriceTo = document.querySelector('#price_to');
let getProductsByPriceTimeout;


noUiSlider.create(startSlider, {
  start: [priceFromDataValue ? priceFromDataValue : priceFromData,
          priceToDataValue ? priceToDataValue : priceToData],
  connect: true,
  step: 1,
  format: {
    to: function (val) {return Math.floor(val);},
    from: function (value) {return Number(value.replace(',-', ''));}
  },
  range: {
    'min': [priceFromData],
    'max': [priceToData]
  }
});
startSlider.noUiSlider.on("update", () => {

  let data = startSlider.noUiSlider.get();
  inputPriceFrom.value = data[0];
  inputPriceTo.value = data[1];
});

startSlider.noUiSlider.on("end", () => {

  let dataFrom = 'price=' + startSlider.noUiSlider.get()[0] + ':' + startSlider.noUiSlider.get()[1];
  console.log(dataFrom);
  if (getProductsByPriceTimeout) {
    clearTimeout(getProductsByPriceTimeout);
  }

  getProductsByPriceTimeout = setTimeout(() => {

    getProductsNumberByPrice(dataFrom);

  }, 800);
});


//allow only digits in input
let numberInputs = document.querySelectorAll('.input-number');
numberInputs.forEach((elem) => {
  elem.addEventListener('input', () => {
    elem.value = elem.value.replace(/\D+/g, '');

  });
});

priceFrom.addEventListener('keyup', () => {

  let priceFromValue = 'price=' + priceFrom.value + ':' + priceTo.value;

  if (getProductsByPriceTimeout) {
    clearTimeout(getProductsByPriceTimeout);
  }
  getProductsByPriceTimeout = setTimeout(() => {

    getProductsNumberByPrice(priceFromValue);

    startSlider.noUiSlider.set([+priceFrom.value, null]);

  }, 800);


});

priceTo.addEventListener('keyup', () => {

  let priceToValue = 'price=' + priceFrom.value + ':' + priceTo.value;

  if (getProductsByPriceTimeout) {
    clearTimeout(getProductsByPriceTimeout);
  }
  getProductsByPriceTimeout = setTimeout(() => {

    getProductsNumberByPrice(priceToValue);

    startSlider.noUiSlider.set([null, +priceTo.value]);

  }, 800);
});

function getProductsNumberByPrice(priceValue) {
  queryString = decodeURIComponent(queryString);
  queryString = queryString.replace(/price=\d+:\d+/g, '').replace(/^[&]|[&?]$/, '');
  console.log(queryString);
  queryString = queryString === '' ? queryString : queryString + '&';

  axios.get('/api' + urlObject.pathname + '?' + decodeURIComponent(queryString + priceValue))
       .then(function (response) {

         return response.data;
       })
       .then((res) => {

               if (res !== 0) {

                 queryString = queryString.replace('?', '');
                 newDiv.innerHTML = 'Найдено:' + res;

                 newDiv.setAttribute('href', urlObject.pathname + '?' + decodeURIComponent(queryString + priceValue));

                 priceTo.parentNode.parentNode.parentNode.parentNode.appendChild(newDiv);
               } else {
                 newDiv.innerHTML = 'Найдено: 0';
                 priceTo.parentNode.parentNode.parentNode.parentNode.appendChild(newDiv);
               }
             }
       )
       .catch(function (error) {
         console.log(error);
       });
}

//deleting sidebar filters
let filters = document.querySelectorAll('.applied-filter');

filters.forEach((elem) => {
  elem.addEventListener('click', () => {
    let filterName = elem.querySelector('.filter-name').dataset.name;
    let filterValue = elem.querySelector('.filter-value').dataset.value;

    queryString = decodeURIComponent(queryString);

    queryString = queryString
      .replace(filterName + '=' + filterValue, '')
      .replace(filterName + '[]=' + filterValue, '')
      .replace(/^[&]|[&?]$/, '');
    queryString = queryString === '' ? queryString : '?' + queryString;

    window.location = urlObject.origin + urlObject.pathname + decodeURIComponent(queryString);

  });
});
