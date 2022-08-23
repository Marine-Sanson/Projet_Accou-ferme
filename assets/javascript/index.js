window.addEventListener("DOMContentLoaded", (event) => {
    let $mobileHeaderBtn = document.getElementById('mobile-header-button');

    $mobileHeaderBtn.addEventListener('click', function(){
        let $mainNav = document.getElementById('main-nav');
        let $classes = $mainNav.classList;

        $classes.toggle("open");
    });
    
    var $selectNews = document.getElementById("selectNews");
    
    $selectNews.addEventListener('change', function(event){
        
    // VARIABLES
        // je récupère la liste complète des news
        var $allNews = document.querySelectorAll(".newsArticle");
        console.log($allNews);
        
        //  je récupère la catégorie actuelle
        var $categoryId = $selectNews.value.trim();
        console.log($categoryId);
        
        // je récupère la liste des news qui ont la catégorie actuelle
        var $newsShow = document.querySelectorAll(".newsArticle[data-category='"+$categoryId+"']");
        console.log($newsShow);
        
        //  je récupère la liste des news qui n'ont pas la catégorie actuelle
        var $newsHide = document.querySelectorAll(".newsArticle:not([data-category='"+$categoryId+"'])");
        console.log($newsHide);

        
    // Pour les news qui ont la catégorie actuelle:
            for(var i=0; i<$newsShow.length; i++){
        // j'ajoute show
                $newsShow[i].classList.add("show");            
            
        // je retire hide
                $newsHide[i].classList.remove("hide");
            }
        
    // Pour les news qui n'ont pas la catégorie actuelle
            for(var j=0; j<$newsHide.length; j++){
        // j'ajoute hide
                $newsHide[j].classList.add("hide");
            
        // je retire show
                $newsHide[j].classList.remove("show");
            }
        
    // Si la catégorie actuelle est 0
        if($categoryId === "0"){
            console.log("id = 0");
            console.log($categoryId);
        // Pour tout le monde j'ajoute show et je retire hide
            for(var k=0; k<$allNews.length; k++){
                $allNews[k].classList.remove("hide");
                $allNews[k].classList.add("show");
            }
            
        }
        
    });
    
});

        // let updateBasket = document.querySelector( '#basketPreview' )
        
        // let $submitAddRemove = document.getElementByClassName(".availableVarietyButton");
       
        // $submitAddRemove.addEventListener('click', function(event){
        //     event.preventDefault();
            
        //     let availableVarietyName;
        //     let buttonAdd;
        //     let buttonRemove;

        //     let formData = new FormData();
        //     formData.append('data', true);
        //     formData.append('availableVarietyName', availableVarietyName);
        //     formData.append('buttonAdd', buttonAdd);
        //     formData.append('buttonRemove', buttonRemove);

           
        //     const options = {
        //         method: 'POST',
        //         body: formData
        //     };
            
        //     fetch('/Projet_Accou-ferme/basket_preview', options)
        //         .then(response => response.text())
        //         .then(data => {
        //             preview = document.getElementById("basketPreview");
        //             preview.innerHTML = data;
        //         });
        
        
    //   });
