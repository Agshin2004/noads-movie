import "./bootstrap";
import Splide from "@splidejs/splide";
import MicroModal from "micromodal";
import "flowbite";
import Alpine from "alpinejs";

document.addEventListener("DOMContentLoaded", function () {
    new Splide("#image-slider", {
        type: "loop",
        perPage: 1,
        heightRatio: 0.5,
        gap: 20,
        autoplay: true,
        interval: 3000,
        rewind: true,
    }).mount();

    MicroModal.init();

    window.Alpine = Alpine;
    Alpine.start();
});

if (window.location.pathname.includes("/people/")) {
    const moreTextEl = document.getElementById("more-text");
    const toggleBtnEl = document.getElementById("toggle-btn");
    const hideBtnEl = document.getElementById("hide-btn");

    toggleBtnEl.addEventListener("click", () => {
        moreTextEl.classList.toggle("hidden");
        toggleBtnEl.classList.toggle("hidden");
        hideBtnEl.classList.toggle("hidden");
    });

    hideBtnEl.addEventListener("click", () => {
        moreTextEl.classList.toggle("hidden");
        toggleBtnEl.classList.toggle("hidden");
        hideBtnEl.classList.toggle("hidden");
    });
}
