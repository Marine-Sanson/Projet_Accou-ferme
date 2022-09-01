import { mobileHeader } from "./header.js";
// import {  } from "./products.js";
import { initBasket } from "./basket/basket.js";
// import {  } from "./news.js";


window.addEventListener("DOMContentLoaded", (event) => {
    mobileHeader();
    // ----- products -----
    initBasket();
    // ----- news -----
});

