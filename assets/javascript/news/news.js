// Trie des articles par catégorie
    
function initNews(){
    
    let $selectNews = document.getElementById("selectNews");
    
    $selectNews.addEventListener('change', function(event){
        event.preventDefault();

    // VARIABLES
        // je récupère la liste complète des news
        let $allNews = document.querySelectorAll(".newsArticle");

        //  je récupère la catégorie actuelle
        let $categoryId = $selectNews.value.trim();

        // je récupère la liste des news qui ont la catégorie actuelle
        let $newsShow = document.querySelectorAll(".newsArticle[data-category='"+$categoryId+"']");

        //  je récupère la liste des news qui n'ont pas la catégorie actuelle
        let $newsHide = document.querySelectorAll(".newsArticle:not([data-category='"+$categoryId+"'])");


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
        // Pour tout le monde j'ajoute show et je retire hide
            for(var k=0; k<$allNews.length; k++){
                $allNews[k].classList.remove("hide");
                $allNews[k].classList.add("show");
            }
            
        }
        
    });
    
}

export { initNews };