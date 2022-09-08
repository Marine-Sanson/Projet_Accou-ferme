import { mobileHeader } from "../header/header.js";
import { initProducts } from "../products/products.js";

window.addEventListener("DOMContentLoaded", (event) => {
    mobileHeader();
    initProducts();
});
