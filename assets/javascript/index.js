import { mobileHeader } from "./header.js";
// import { initProducts } from "./products.js";
import { initBasket } from "./basket/basket.js";
// import { initNews } from "./news.js";


window.addEventListener("DOMContentLoaded", (event) => {
    mobileHeader();
    // initProducts();
    initBasket();
    // initNews();
});

