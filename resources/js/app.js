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
        perPage: 7,
        perMove: 1,
        gap: "0.5rem",
        autoplay: true,
        interval: 3000,
        pauseOnHover: true,
        drag: true,
        arrows: true,
        pagination: false,
        breakpoints: {
            1536: {
                // xl
                perPage: 7,
            },
            1280: {
                // lg
                perPage: 6,
            },
            1024: {
                // md
                perPage: 5,
            },
            768: {
                // sm
                perPage: 4,
            },
            640: {
                // xs
                perPage: 3,
            },
        },
    }).mount();

    // MicroModal
    MicroModal.init();

    // Alpine js
    window.Alpine = Alpine;
    Alpine.start();
});
