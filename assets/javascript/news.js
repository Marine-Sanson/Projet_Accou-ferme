// Trie des articles par catégorie
    
    let $selectNews = document.getElementById("selectNews");
    
    $selectNews.addEventListener('change', function(event){
        
    // VARIABLES
        // je récupère la liste complète des news
        let $allNews = document.querySelectorAll(".newsArticle");
        console.log($allNews);
        
        //  je récupère la catégorie actuelle
        let $categoryId = $selectNews.value.trim();
        console.log($categoryId);
        
        // je récupère la liste des news qui ont la catégorie actuelle
        let $newsShow = document.querySelectorAll(".newsArticle[data-category='"+$categoryId+"']");
        console.log($newsShow);
        
        //  je récupère la liste des news qui n'ont pas la catégorie actuelle
        let $newsHide = document.querySelectorAll(".newsArticle:not([data-category='"+$categoryId+"'])");
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