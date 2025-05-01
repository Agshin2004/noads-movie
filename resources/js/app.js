import "./bootstrap";
import MicroModal from "micromodal";
import Splide from "@splidejs/splide";
import "flowbite";
import Alpine from "alpinejs";

// vidsrc has bunch of console errors, so I decided to clear console after 1 sec
setTimeout(() => {
    console.clear();
}, 1000);

window.fetchPlayers = (movieId) => {
    document
        .getElementById("serverSelect")
        .addEventListener("change", (e) => {
            const server = e.target.value;
            const iframe = document.querySelector(".movie-iframe");
            console.log(iframe.src);

            let src = "";
            switch (server) {
                case "1":
                    src = `https://vidsrc.to/v2/embed/movie/${movieId}?autoPlay=false`;
                    break;
                case "2":
                    src = `https://www.2embed.cc/embed/${movieId}`;
                    break;
                case "3":
                    src = `https://vidsrc.cc/v3/embed/movie/${movieId}?autoPlay=false`;
                    break;
                case "4":
                    src = `https://embed.su/embed/movie/${movieId}`;
                    break;
                case "5":
                    src = `https://letsembed.cc/embed/movie/?id=${movieId}`;
                    break;
            }
            iframe.src = src;
        });
    };


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
            pagination: false,
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
