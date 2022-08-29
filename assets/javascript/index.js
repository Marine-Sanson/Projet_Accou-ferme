function listenButtonAdd(event){
    event.preventDefault();
    // qui a été cliqué
    let $clickedButton = event.target;
    
    let $idVariety = $clickedButton.getAttribute("data-product-id");
    
    let $varietyUnits = document.getElementById("variety-units-"+$idVariety);
    let $varietyPrice = document.getElementById("variety-price-"+$idVariety);
    let $varietyMedia = document.getElementById("variety-media-"+$idVariety);
    
    let $asideUpdate = document.getElementById("basketPreview");
    $asideUpdate.classList.add("showUpdate");
    $asideUpdate.classList.remove("hideUpdate");
    
    let $formData = new FormData();
    $formData.append('data', true);
    $formData.append('availableVarietyName', event.target.value);
    $formData.append('availableVarietyUnits', $varietyUnits.value);
    $formData.append('availableVarietyPrice', $varietyPrice.value);
    $formData.append('availableVarietyMedia', $varietyMedia.value);
    
    const options = {
        method: 'POST',
        body: $formData
    };
    
    fetch('/Projet_Accou-ferme/_update', options)
        .then(response => response.json())
        .then(data => {
            createBasketDisplay(data);
            console.log(data);
        })
        .catch( error => {
        });
}

function createBasketDisplay(data){
    console.log("je rentre dans createBasketDisplay");
    // je récupère les data
    let $basket = data;
    
    let $section = document.getElementById("updateContentSection");
        
        let $ul = document.getElementById("updateContent");
        
        $section.removeChild($ul);
    
    // pour chaque produit dans le panier je crée un li et son contenu auquel j'ajoute une classe, un contenu, et éventuellement des attributs
    for (var i=0; i<$basket.length; i++){
        
        let $newUL = document.createElement("ul");
        $newUL.setAttribute("id", "updateContent");
        $section.appendChild($newUL);
        
        let $newLi = document.createElement("li");
        $newLi.classList.add("updateDetail");
        
        let $newImg = document.createElement("img");
        $newImg.classList.add("updateImg");
        $newImg.setAttribute("src", $basket[i]['media_url']);
        $newImg.setAttribute("alt", $basket[i]['media_alt']);
        
        let $newH3 = document.createElement("h3");
        
        $newH3.classList.add("updateH3");
        
        let $text = document.createTextNode($basket[i]['variety']);
        $newH3.appendChild($text);
        
        let $newP1 = document.createElement("p");
        $newP1.classList.add("updateP1");
        let $text2 = document.createTextNode($basket[i]['amount'] + " " + $basket[i]['units'] + " " + $basket[i]['price'] + "€");
        $newP1.appendChild($text2);
        
        let $newP2 = document.createElement("p");
        $newP2.classList.add("updateP2");
        let $text3 = document.createTextNode($basket[i]['price'] + "€ / " + $basket[i]['units'].slice(0, -3));
        $newP2.appendChild($text3);
        
        $newLi.appendChild($newImg);
        $newLi.appendChild($newH3);
        $newLi.appendChild($newP1);
        $newLi.appendChild($newP2);
        
        let $newUlAgain = document.getElementById("updateContent");
        $newUlAgain.appendChild($newLi);
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
    let $buttonsAdd = document.getElementsByClassName("buttonAdd");
    //console.log($buttonsAdd);
    // console.log($buttonsAdd.getAttribute(data-productAdded));
    
    for(var i = 0; i < $buttonsAdd.length; i++)
    {
        $buttonsAdd[i].addEventListener('click', listenButtonAdd);
    }


    

    
// Trie des produits par famille

    // let $selectProduct = document.getElementById("selectProduct");
    
    // $selectProduct.addEventListener('change', function(event){
        
    // // VARIABLES
    //     // je récupère la liste complète des produits
    //     let $allProducts = document.querySelectorAll(".productName");
    //     console.log($allProducts);
        
    //     // je récupère la liste complète des variétés
    //     let $allVarieties = document.querySelectorAll(".varietyDetail");
        
    //     //  je récupère le produit actuel
    //     let $productId = $selectProduct.value.trim();
    //     console.log($productId);
        
    //     // je récupère la liste des produits qui dépendent du produit actuel
    //     let $productsShow = document.querySelectorAll(".productName[data-product='"+$productId+"']");
    //     console.log($productsShow);
        
    //     // je récupère la liste des variétés qui dépendent du produit actuel
    //     let $varietyShow = document.querySelectorAll(".varietyDetail[data-product='"+$productId+"']");
        
    //     //  je récupère la liste des produits qui ne dépendent pas du produit actuel
    //     let $productsHide = document.querySelectorAll(".productName:not([data-product='"+$productId+"'])");
    //     console.log($productsHide);
        
    //     //  je récupère la liste des variétés qui ne dépendent pas du produit actuel
    //     let $varietyHide = document.querySelectorAll(".varietyDetail:not([data-product='"+$productId+"'])");
        
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
    
    // let $selectNews = document.getElementById("selectNews");
    
    // $selectNews.addEventListener('change', function(event){
        
    // // VARIABLES
    //     // je récupère la liste complète des news
    //     let $allNews = document.querySelectorAll(".newsArticle");
    //     console.log($allNews);
        
    //     //  je récupère la catégorie actuelle
    //     let $categoryId = $selectNews.value.trim();
    //     console.log($categoryId);
        
    //     // je récupère la liste des news qui ont la catégorie actuelle
    //     let $newsShow = document.querySelectorAll(".newsArticle[data-category='"+$categoryId+"']");
    //     console.log($newsShow);
        
    //     //  je récupère la liste des news qui n'ont pas la catégorie actuelle
    //     let $newsHide = document.querySelectorAll(".newsArticle:not([data-category='"+$categoryId+"'])");
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