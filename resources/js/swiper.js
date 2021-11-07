// core version + navigation, pagination modules:
import Swiper, { Navigation, Pagination, Autoplay } from "swiper";
// import Swiper and modules styles
import "swiper/css";
import "swiper/css/navigation";
import "swiper/css/pagination";

// configure Swiper to use modules
Swiper.use([Navigation, Pagination, Autoplay]);

// init Swiper:
const swiper = new Swiper(".swiper", {
    // Optional parameters
    autoplay: {
        delay: 3000,
    },

    loop: true,

    // If we need pagination
    pagination: {
        el: ".swiper-pagination",
    },

    // Navigation arrows
    navigation: {
        nextEl: ".swiper-button-next",
        prevEl: ".swiper-button-prev",
    },

    // And if we need scrollbar
    scrollbar: {
        el: ".swiper-scrollbar",
    },
});
