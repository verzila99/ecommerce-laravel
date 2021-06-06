slider(".top-promotions");
slider(".bottom-promotions");

function slider(arg) {
    let parent = document.querySelector(arg),
        slider = parent.querySelector(".slider"),
        slides = Array.from(parent.querySelectorAll(".slide")),
        sliderContainer = parent.querySelector(".slider-container__homepage"),
        containerWidth = sliderContainer.offsetWidth,
        dotContainer = parent.querySelector(".dot-container"),
        container = parent.querySelector(".slider-container__main"),
        arrowLeft = parent.querySelector(".arrow-left__container"),
        arrowRight = parent.querySelector(".arrow-right__container");

    sliderTimer = 3000;
    let isDragging = false,
        startPos = 0,
        currentTranslate = 0,
        prevTranslate = 0,
        animationID = 0,
        currentIndex = 0,
        dotDivs = "",
        currentPos,
        animationInProceed = false;

    // control by dots
    let dotDiv = ``;
    for (let dot = 0; dot < slides.length; dot++) {
        dotDiv = `<div class="dot" data-index = ${dot}></div>`;
        dotDivs = dotDivs + dotDiv;
    }
    dotContainer.insertAdjacentHTML("afterbegin", dotDivs);
    let dots = parent.querySelectorAll(".dot");
    dots[0].classList.add("dot-active");
    dots.forEach((dot) => {
        dot.addEventListener("click", (e) => {
            let dotIndex = dot.dataset.index;
            setPositionByIndexByDots(dotIndex);
        });
    });
    function setPositionByIndexByDots(index) {
        index = Number(index);
        if (index != currentIndex) {
            dots[currentIndex].classList.remove("dot-active");
            currentTranslate =
                (index - currentIndex) * -containerWidth + prevTranslate;
            currentIndex = index;
            dots[currentIndex].classList.add("dot-active");
            prevTranslate = currentTranslate;
            slider.style.transform = `translateX(${currentTranslate}px)`;
        }
    }

    //control by arrows
    arrowLeft.addEventListener("click", slideBack);
    arrowRight.addEventListener("click", slideForward);
    // slideback
    function slideBack() {
        if (currentIndex == 0) setPositionByIndexByDots(slides.length - 1);
        else {
            setPositionByIndexByDots(Number(currentIndex - 1));
        }
    }
    //autoslide
    let sliderInterval = setInterval(slideForward, sliderTimer);
    //slideForward
    function slideForward() {
        if (currentIndex == 0) setPositionByIndexByDots(1);
        else if (currentIndex < slides.length - 1) {
            setPositionByIndexByDots(Number(currentIndex + 1));
        } else setPositionByIndexByDots(0);
    }
    container.addEventListener("mouseover", () =>
        clearInterval(sliderInterval)
    );
    container.addEventListener("mouseleave", () => {
        sliderInterval = setInterval(slideForward, sliderTimer);
    });

    //control by dragging
    slides.forEach((slide, index) => {
        const slideImage = slide.querySelector("img");
        slideImage.addEventListener("dragstart", (e) => e.preventDefault());

        //touch events
        slide.addEventListener("touchstart", touchStart(index));
        slide.addEventListener("touchend", touchEnd);
        slide.addEventListener("touchmove", touchMove);

        //mouse events
        slide.addEventListener("mousedown", touchStart(index));
        slide.addEventListener("mouseup", touchEnd);
        slide.addEventListener("mouseleave", touchEnd);
        slide.addEventListener("mousemove", touchMove);
    });

    // disable context menu
    slider.oncontextmenu = function (event) {
        event.preventDefault();
        event.stopPropagation();
        return false;
    };

    function touchStart() {
        return function (event) {
            startPos = getPositionX(event);
            isDragging = true;
            animationID = requestAnimationFrame(animation);
        };
    }
    function touchEnd() {
        isDragging = false;
        cancelAnimationFrame(animationID);
        dots[currentIndex].classList.remove("dot-active");

        let movedBy = currentTranslate - prevTranslate;
        if (movedBy < -100 && currentIndex < slides.length - 1)
            currentIndex += 1;

        if (movedBy > 100 && currentIndex > 0) currentIndex -= 1;
        currentTranslate =
            Math.floor(currentTranslate / container.clientWidth) *
            container.clientWidth;
        setPositionByIndex();
        dots[currentIndex].classList.add("dot-active");
    }
    function touchMove(event) {
        if (isDragging == true) {
            currentPos = getPositionX(event);

            currentTranslate = prevTranslate + currentPos - startPos;
        }
    }
    function setPositionByIndex() {
        currentTranslate = -currentIndex * containerWidth;
        prevTranslate = currentTranslate;
        setSliderPosition();
    }

    function getPositionX(event) {
        if (event.type.includes("mouse")) {
            return event.pageX;
        } else {
            return event.touches[0].clientX;
        }
    }
    function animation() {
        setSliderPosition();
        if (isDragging) {
            requestAnimationFrame(animation);
        }
    }
    function setSliderPosition() {
        slider.style.transform = `translateX(${currentTranslate}px)`;
    }
    // <<--------------------------------->>
}
