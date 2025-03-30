if (document.querySelector('.hero-slider') !== null) {
    tns({
        container: '.hero-slider',
        slideBy: 'page',
        autoplay: true,
        autoplayButtonOutput: false,
        mouseDrag: true,
        gutter: 0,
        items: 1,
        nav: false,
        controls: true,
        controlsText: ['<i class="lni lni-chevron-left"></i>', '<i class="lni lni-chevron-right"></i>'],
    });
}

const current = document.getElementById("current");
const opacity = 0.6;
const imgs = document.querySelectorAll(".img");
imgs.forEach(img => {
    img.addEventListener("click", (e) => {
        //reset opacity
        imgs.forEach(img => {
            img.style.opacity = 1;
        });
        current.src = e.target.src;
        //adding class 
        //current.classList.add("fade-in");
        //opacity
        e.target.style.opacity = opacity;
    });
});