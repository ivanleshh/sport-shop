const current = document.getElementById("current");
const opacity = 0.6;
const imgs = document.querySelectorAll(".gallery-img");

const updateGallery = (e) => {
    imgs.forEach(img => {
        img.style.opacity = 1;
    });
    current.src = e.target.src;
    e.target.style.opacity = opacity;
}

imgs.forEach(img => {
    img.addEventListener("click", (e) => {
        updateGallery(e)
    });
    img.addEventListener("mouseover", (e) => {
        updateGallery(e)
    });
});