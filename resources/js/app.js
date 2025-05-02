import "./bootstrap";
import MicroModal from "micromodal";
import Splide from "@splidejs/splide";
import "flowbite";
import Alpine from "alpinejs";

// vidsrc has bunch of console errors, so I decided to clear console after 1 sec
// setTimeout(() => {
//     console.clear();
// }, 1000);

window.fetchPlayers = (movieId) => {
    document.getElementById("serverSelect").addEventListener("change", (e) => {
        const server = e.target.value;
        const iframe = document.querySelector(".movie-iframe");

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

window.fetchShows = (showId) => {
    //  'https://api.themoviedb.org/3/tv/1399/season/1?language=en-US'

    insertEpisodes(showId);
    const iframe = document.querySelector(".show-iframe");
    let season = 1;
    let url = '';

    document
        .getElementById("season")
        .addEventListener("change", async function () {
            season = this.value;
            url = `https://vidsrc.cc/v2/embed/tv/${showId}/${season}/1?autoPlay=false`;
            iframe.src = url;

            insertEpisodes(showId, season);
        });

    document.getElementById("episode").addEventListener("change", function () {
        const episode = this.value;
        // Change episode to selected from player that is used rn
        url = `https://vidsrc.cc/v2/embed/tv/${showId}/${season}/${episode}?autoPlay=false`;
        iframe.src = url;
    });
};

async function fetchEpisodes(showId, season = 1) {
    const res = await axios.get(
        `https://api.themoviedb.org/3/tv/${showId}/season/${season}`,
        {
            headers: {
                Authorization:
                    "Bearer eyJhbGciOiJIUzI1NiJ9.eyJhdWQiOiIxZDFiYmY3OWIxYTljZjQwMGRlOGUyZmUyODJmZjRlYiIsIm5iZiI6MTc0NTA1MzY2MS40MDQsInN1YiI6IjY4MDM2N2RkZTAzMjA3ZDBiMWQ5NThkMCIsInNjb3BlcyI6WyJhcGlfcmVhZCJdLCJ2ZXJzaW9uIjoxfQ.ZYW8tQc_Ax8njZWG9BbzgMUoeLpkQFs6u9GLeKtxmCk",
            },
        }
    );

    return res.data.episodes;
}

async function insertEpisodes(showId, season) {
    const episodes = await fetchEpisodes(showId, season);
    const episodeSelectEl = document.getElementById("episode");

    // not the cleanest solution but removes all options from select
    episodeSelectEl.innerHTML = "";
    episodes.map((episode) => {
        const optionEl = document.createElement("option");
        optionEl.value = episode.episode_number;
        optionEl.innerHTML = `${episode.episode_number} - ${episode.name}`;
        episodeSelectEl.append(optionEl);
    });
}

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
