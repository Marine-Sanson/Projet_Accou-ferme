function listenButtonAdd(event){
    event.preventDefault();
    // qui a été cliqué
    var $clickedButton = event.target;
    
    var $idVariety = $clickedButton.getAttribute("data-product-id");
    
    var $varietyUnits = document.getElementById("variety-units-"+$idVariety);
    var $varietyPrice = document.getElementById("variety-price-"+$idVariety);
    var $varietyMedia = document.getElementById("variety-media-"+$idVariety);
    
    var $formData = new FormData();
    $formData.append('data', true);
    $formData.append('availableVarietyName', event.target.value);
    $formData.append('availableVarietyUnits', $varietyUnits.value);
    $formData.append('availableVarietyPrice', $varietyPrice.value);
    $formData.append('availableVarietyMedia', $varietyMedia.value);
    

    const options = {
        method: 'POST',
        body: $formData
    };
    
    fetch('/Projet_Accou-ferme/basket_update', options)
        .then(response => response.json())
        .then(data => {
            console.log(data);
            // createBasketDisplay(data);
        })
        .catch( error => {
        });
        
}

function createBasketDisplay(data){
    
    var $basket = data;
    
    for (var i=0; i<$basket.length; i++){
        var newLi = document.createElement("li");
        var newContent = document.createTextNode($basket[i]['variety'] + $basket[i]['amount']);
        
        newLi.appendChild(newContent);
        

    }
}

window.addEventListener("DOMContentLoaded", (event) => {
    
// Responsive sur le header
    
    // let $mobileHeaderBtn = document.getElementsByClassName('mobile-header-button');

    // $mobileHeaderBtn.addEventListener('click', function(){
    //     let $mainNav = document.getElementById('main-nav');
    //     let $classes = $mainNav.classList;

    //     $classes.toggle("open");
    // });
    
// Maj du panier

    // le bouton plus
    var $buttonsAdd = document.getElementsByClassName("buttonAdd");
    //console.log($buttonsAdd);
    // console.log($buttonsAdd.getAttribute(data-productAdded));
    
    for(var i = 0; i < $buttonsAdd.length; i++)
    {
        $buttonsAdd[i].addEventListener('click', listenButtonAdd);
    }


    

    
// Trie des produits par famille

    // var $selectProduct = document.getElementById("selectProduct");
    
    // $selectProduct.addEventListener('change', function(event){
        
    // // VARIABLES
    //     // je récupère la liste complète des produits
    //     var $allProducts = document.querySelectorAll(".productName");
    //     console.log($allProducts);
        
    //     // je récupère la liste complète des variétés
    //     var $allVarieties = document.querySelectorAll(".varietyDetail");
        
    //     //  je récupère le produit actuel
    //     var $productId = $selectProduct.value.trim();
    //     console.log($productId);
        
    //     // je récupère la liste des produits qui dépendent du produit actuel
    //     var $productsShow = document.querySelectorAll(".productName[data-product='"+$productId+"']");
    //     console.log($productsShow);
        
    //     // je récupère la liste des variétés qui dépendent du produit actuel
    //     var $varietyShow = document.querySelectorAll(".varietyDetail[data-product='"+$productId+"']");
        
    //     //  je récupère la liste des produits qui ne dépendent pas du produit actuel
    //     var $productsHide = document.querySelectorAll(".productName:not([data-product='"+$productId+"'])");
    //     console.log($productsHide);
        
    //     //  je récupère la liste des variétés qui ne dépendent pas du produit actuel
    //     var $varietyHide = document.querySelectorAll(".varietyDetail:not([data-product='"+$productId+"'])");
        
    // // Pour les variétés qui dépendent du produit actuel:
    //         for(var i=0; i<$productsShow.length; i++){
    //     // j'ajoute show
    //             $productsShow[i].classList.add("show");
            
    //     // je retire hide
    //             $productsShow[i].classList.remove("hide");
    //         }
            
    // // même chose pour les articles
    //         for(var l=0; l<$varietyShow.length; l++){
    //     // j'ajoute hide
    //             $varietyShow[l].classList.add("show");
            
    //     // je retire show
    //             $varietyShow[l].classList.remove("hide");
    //         }
        
    // // Pour les variétés qui ne dépendent pas du produit actuel:
    //         for(var j=0; j<$productsHide.length; j++){
    //     // j'ajoute hide
    //             $productsHide[j].classList.add("hide");

    //     // je retire show
    //             $productsHide[j].classList.remove("show");
    //         }
            
    // // même chose pour les articles
    //         for(var m=0; m<$varietyHide.length; m++){
    //     // j'ajoute hide
    //             $varietyHide[m].classList.add("hide");
            
    //     // je retire show
    //             $varietyHide[m].classList.remove("show");
    //         }
        
    // // Si le produit actuel est 0
    //     if($productId === "0"){
    //         console.log("id = 0");
    //         console.log($productId);
    //     // Pour tout le monde j'ajoute show et je retire hide
    //         // sur les produits
    //         for(var k=0; k<$allProducts.length; k++){
    //             $allProducts[k].classList.remove("hide");
    //             $allProducts[k].classList.add("show");
    //         }
            
    //         // sur les articles
    //         for(var n=0; n<$allVarieties.length; n++){
    //             $allVarieties[n].classList.remove("hide");
    //             $allVarieties[n].classList.add("show");
    //         }

    //     }
        
    // });
    
// Trie des articles par catégorie
    
    // var $selectNews = document.getElementById("selectNews");
    
    // $selectNews.addEventListener('change', function(event){
        
    // // VARIABLES
    //     // je récupère la liste complète des news
    //     var $allNews = document.querySelectorAll(".newsArticle");
    //     console.log($allNews);
        
    //     //  je récupère la catégorie actuelle
    //     var $categoryId = $selectNews.value.trim();
    //     console.log($categoryId);
        
    //     // je récupère la liste des news qui ont la catégorie actuelle
    //     var $newsShow = document.querySelectorAll(".newsArticle[data-category='"+$categoryId+"']");
    //     console.log($newsShow);
        
    //     //  je récupère la liste des news qui n'ont pas la catégorie actuelle
    //     var $newsHide = document.querySelectorAll(".newsArticle:not([data-category='"+$categoryId+"'])");
    //     console.log($newsHide);

        
    // // Pour les news qui ont la catégorie actuelle:
    //         for(var i=0; i<$newsShow.length; i++){
    //     // j'ajoute show
    //             $newsShow[i].classList.add("show");            
            
    //     // je retire hide
    //             $newsHide[i].classList.remove("hide");
    //         }
        
    // // Pour les news qui n'ont pas la catégorie actuelle
    //         for(var j=0; j<$newsHide.length; j++){
    //     // j'ajoute hide
    //             $newsHide[j].classList.add("hide");
            
    //     // je retire show
    //             $newsHide[j].classList.remove("show");
    //         }
        
    // // Si la catégorie actuelle est 0
    //     if($categoryId === "0"){
    //         console.log("id = 0");
    //         console.log($categoryId);
    //     // Pour tout le monde j'ajoute show et je retire hide
    //         for(var k=0; k<$allNews.length; k++){
    //             $allNews[k].classList.remove("hide");
    //             $allNews[k].classList.add("show");
    //         }
            
    //     }
        
    // });
    

    
});