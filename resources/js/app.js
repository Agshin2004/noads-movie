import "./bootstrap";
import MicroModal from "micromodal";
import Splide from "@splidejs/splide";
import "flowbite";
import Alpine from "alpinejs";

document.addEventListener("DOMContentLoaded", function () {
    if (location.pathname.includes("/watch/")) {
        new Splide("#image-slider", {
            type: "loop",
            perPage: 1,
            heightRatio: 0.5,
            gap: 20,
            autoplay: true,
            interval: 3000,
            rewind: true,
        }).mount();
    }

    new Splide("#movies-slider", {
        type: "loop",
        perPage: 5,
        perMove: 1,
        gap: "1rem",
        autoplay: true,
        interval: 3000,
        pauseOnHover: true,
        drag: true,
        arrows: true,
        pagination: false,
        breakpoints: {
            1536: {
                // xl
                perPage: 5,
            },
            1280: {
                // lg
                perPage: 4,
            },
            1024: {
                // md
                perPage: 3,
            },
            768: {
                // sm
                perPage: 2,
            },
            640: {
                // xs
                perPage: 1,
            },
        },
    }).mount();

    // MicroModal
    MicroModal.init();

    // Alpine js
    window.Alpine = Alpine;
    Alpine.start();
});
