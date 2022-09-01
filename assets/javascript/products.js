// Trie des produits par famille

    let $selectProduct = document.getElementById("selectProduct");
    
    $selectProduct.addEventListener('change', function(event){
        
    // VARIABLES
        // je récupère la liste complète des produits
        let $allProducts = document.querySelectorAll(".productName");
        console.log($allProducts);
        
        // je récupère la liste complète des variétés
        let $allVarieties = document.querySelectorAll(".varietyDetail");
        
        //  je récupère le produit actuel
        let $productId = $selectProduct.value.trim();
        console.log($productId);
        
        // je récupère la liste des produits qui dépendent du produit actuel
        let $productsShow = document.querySelectorAll(".productName[data-product='"+$productId+"']");
        console.log($productsShow);
        
        // je récupère la liste des variétés qui dépendent du produit actuel
        let $varietyShow = document.querySelectorAll(".varietyDetail[data-product='"+$productId+"']");
        
        //  je récupère la liste des produits qui ne dépendent pas du produit actuel
        let $productsHide = document.querySelectorAll(".productName:not([data-product='"+$productId+"'])");
        console.log($productsHide);
        
        //  je récupère la liste des variétés qui ne dépendent pas du produit actuel
        let $varietyHide = document.querySelectorAll(".varietyDetail:not([data-product='"+$productId+"'])");
        
    // Pour les variétés qui dépendent du produit actuel:
            for(var i=0; i<$productsShow.length; i++){
        // j'ajoute show
                $productsShow[i].classList.add("show");
            
        // je retire hide
                $productsShow[i].classList.remove("hide");
            }
            
    // même chose pour les articles
            for(var l=0; l<$varietyShow.length; l++){
        // j'ajoute hide
                $varietyShow[l].classList.add("show");
            
        // je retire show
                $varietyShow[l].classList.remove("hide");
            }
        
    // Pour les variétés qui ne dépendent pas du produit actuel:
            for(var j=0; j<$productsHide.length; j++){
        // j'ajoute hide
                $productsHide[j].classList.add("hide");

        // je retire show
                $productsHide[j].classList.remove("show");
            }
            
    // même chose pour les articles
            for(var m=0; m<$varietyHide.length; m++){
        // j'ajoute hide
                $varietyHide[m].classList.add("hide");
            
        // je retire show
                $varietyHide[m].classList.remove("show");
            }
        
    // Si le produit actuel est 0
        if($productId === "0"){
            console.log("id = 0");
            console.log($productId);
        // Pour tout le monde j'ajoute show et je retire hide
            // sur les produits
            for(var k=0; k<$allProducts.length; k++){
                $allProducts[k].classList.remove("hide");
                $allProducts[k].classList.add("show");
            }
            
            // sur les articles
            for(var n=0; n<$allVarieties.length; n++){
                $allVarieties[n].classList.remove("hide");
                $allVarieties[n].classList.add("show");
            }

        }
        
    });
