import { mobileHeader } from "../header/header.js";
import { initNews } from "../news/news.js";

window.addEventListener("DOMContentLoaded", (event) => {
    mobileHeader();
    initNews();
});

