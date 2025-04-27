import "./bootstrap";
import MicroModal from "micromodal";
import Splide from "@splidejs/splide";
import "flowbite";
import Alpine from "alpinejs";

document.addEventListener("DOMContentLoaded", function () {
    if (
        location.pathname.includes("/movie/") ||
        location.pathname.includes("/show/")
    ) {
        new Splide("#image-slider", {
            type: "loop",
            perPage: 1,
            heightRatio: 0.5,
            gap: 20,
            autoplay: true,
            interval: 3000,
            rewind: true,
        }).mount();
    } else if (location.pathname === "/") {
        new Splide("#fullpage-slider", {
            type: "fade",
            rewind: true,
            pagination: false,
            arrows: true,
            height: "100vh",
            cover: true,
            autoplay: true,
            interval: 5000,
            speed: 1000,
        }).mount();

        // COPY TO CLIPBOARD FUNCTIONLITY
    } else if (this.location.pathname === "/auth/register") {
        const btnEl = document.querySelector(".copy-password");
        if (btnEl === null) return;
        const btnText = btnEl.innerHTML;
        btnEl.addEventListener("click", () => {
            const passwordEl = document.querySelector(".password");
            navigator.clipboard.writeText(passwordEl.value);
            btnEl.innerHTML = "COPIED !!!";
            setTimeout(() => {
                btnEl.innerHTML = btnText;
            }, 1000);
        });
    }

    // MicroModal
    MicroModal.init();

    // Alpine js
    window.Alpine = Alpine;
    Alpine.start();
});
