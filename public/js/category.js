let accordionTitles = document.querySelectorAll(".accordion-group"),
    showMoreButtons = document.querySelectorAll('.show-more'),
    accordionPrice = document.querySelector('.accordion-price'),
    checkboxInputs = document.querySelectorAll('.checkbox-filter'),
    measuringDiv, measuringDivBottom;

//Filter group accordion


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
                    accordionPrice.style.height = '50px';

                }
            } else if (elem.querySelector('.category-filter__arrow').classList.contains('reverse') && elem.querySelector('.show-more').textContent === 'Показать ещё') {

                elem.querySelector(".accordion-item").style.height = '212px';
                elem.querySelector('.category-filter__arrow').classList.remove('reverse');
                elem.querySelector(".show-more").style.height = '20px';

            } else if (elem.querySelector('.category-filter__arrow').classList.contains('reverse') && elem.querySelector('.show-more').textContent === 'Скрыть') {
                measuringDiv = elem.querySelector('.measuring').clientHeight;
                elem.querySelector(".accordion-item").style.height = 10 + measuringDiv + 'px';
                elem.querySelector('.category-filter__arrow').classList.remove('reverse');
                elem.querySelector(".show-more").style.height = '20px';

            } else if (elem.querySelector('.category-filter__arrow').classList.contains('reverse')) {
                measuringDiv = elem.querySelector('.measuring').clientHeight;
                elem.querySelector(".accordion-item").style.height = 10 + measuringDiv + 'px';
                elem.querySelector('.category-filter__arrow').classList.remove('reverse');

                if (elem.querySelector(".show-more").style.height) {

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

        if (elem.textContent === 'Показать ещё') {
            elem.textContent = 'Скрыть';
            elem.previousElementSibling.style.height = 10 + measuringDivBottom + 'px';
        } else {
            elem.textContent = 'Показать ещё';
            elem.previousElementSibling.style.height = '13.4rem';
        }

    });


});

// Sorting active tab

const sortButtons = document.querySelectorAll('.sort-button');
let urlObject = new URL(document.location.href);

let urlParams = urlObject.searchParams;
let sort = urlParams.get("sort_by");
sortButtons.forEach(elem => {
    if (elem.getAttribute('data-sort') === sort) {
        elem.classList.add('is-primary');

    } else if (elem.classList.contains('is-primary')) {

        elem.classList.remove('is-primary');
    }
});


// Filtering
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
              console.log(queryString);
                queryString = queryString.replace('&' + parameter, '');
            } else if (queryString.includes(parameter)) {
                queryString = queryString.replace(parameter, '');
            }
        }
        axios.get('/api' + urlObject.pathname + '?' + queryString.replace(/\+\+\+/g,' + ').replace(/\+/g, ' ').replace(/\s\s\s/g, ' + '))
            .then(function (response) {
                return response.data;
            })
            .then((res) => {

                      if (res !== 0) {
                          queryString = queryString.replace('?', '');
                          newDiv.innerHTML = 'Найдено:' + res;
                          newDiv.setAttribute('href', urlObject.pathname + '?' + queryString.replace(/\+\+\+/g, ' + ').replace(/\+/g, ' ').replace(/\s\s\s/g, ' + '));
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

priceFrom.addEventListener('keyup', () => {
    let priceFromValue = 'price_from=' + priceFrom.value;

    fetch('/api' + urlObject.pathname + '?' + queryString.replace(/price_from=\d+/g, '').replace('&&', '&').replace('?&', '?') + '&' + priceFromValue)
        .then(function (response) {

            return response.json();
        })
        .then((res) => {

                  if (res !== 0) {
                      queryString = queryString.replace('?', '');
                      newDiv.style.right = '-65%';
                      newDiv.innerHTML = 'Найдено:' + res;
                      newDiv.setAttribute('href', urlObject.pathname + '?' + queryString.replace(/price_from=\d+/g, '').replace('&&', '&').replace('?&', '?') + '&' + priceFromValue);
                      priceFrom.parentNode.parentNode.parentNode.parentNode.appendChild(newDiv);
                  } else {
                      newDiv.innerHTML = '0 найдено';
                      priceFrom.parentNode.parentNode.parentNode.parentNode.appendChild(newDiv);
                  }
              }
        )
        .catch(function (error) {
            console.log(error);
        });
});
priceTo.addEventListener('keyup', () => {
    let priceToValue = 'price_to=' + priceTo.value;

    fetch('/api' + urlObject.pathname + '?' + queryString.replace(/price_to=\d+/g, '').replace('&&', '&').replace('?&', '?') + '&' + priceToValue)
        .then(function (response) {

            return response.json();
        })
        .then((res) => {

                  if (res !== 0) {
                      newDiv.style.right = '-40%';
                      queryString = queryString.replace('?', '');
                      newDiv.innerHTML = 'Найдено:' + res;
                      newDiv.setAttribute('href', urlObject.pathname + '?' + queryString.replace(/price_to=\d+/g, '').replace('&&', '&').replace('?&', '?') + '&' + priceToValue);
                      priceTo.parentNode.parentNode.parentNode.parentNode.appendChild(newDiv);
                  } else {
                      newDiv.innerHTML = '0 найдено';
                      priceTo.parentNode.parentNode.parentNode.parentNode.appendChild(newDiv);
                  }
              }
        )
        .catch(function (error) {
            console.log(error);
        });
});
