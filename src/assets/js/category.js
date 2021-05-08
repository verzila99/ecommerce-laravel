let accordionTitles = document.querySelectorAll(".accordion-group");
console.log(accordionTitles);
accordionTitles.forEach((elem) => {
    elem.querySelector(".category-filter__title").addEventListener(
        "click",
        () => {
            elem.querySelector(".accordion").classList.toggle("collapse");
        }
    );
});
