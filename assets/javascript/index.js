window.addEventListener("DOMContentLoaded", (event) => {
var $mobileHeaderBtn = document.getElementById('mobile-header-button');

    $mobileHeaderBtn.addEventListener('click', function(){
        var $mainNav = document.getElementById('main-nav');
        var $classes = $mainNav.classList;

        $classes.toggle("open");
    });
});