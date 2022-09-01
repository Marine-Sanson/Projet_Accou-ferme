function mobileHeader(event){
    
// Responsive sur le header
    let $mobileHeaderBtn = document.getElementById('mobile-header-button');

    $mobileHeaderBtn.addEventListener('click', function(){
        let $mainNav = document.getElementById('main-nav');
        let $classes = $mainNav.classList;

        $classes.toggle("open");
    });
}
    
export { mobileHeader };