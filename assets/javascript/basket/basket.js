function getData()
{
    return JSON.parse(sessionStorage.getItem("data"));
}

// update the cart in session storage
function saveData(data)
{
    sessionStorage.setItem("data", JSON.stringify(data));
}

function newFetch(){
    let $basket = getData();
    
    let $formData = new FormData();
        $formData.append("data", JSON.stringify($basket));
    // attention JSON.stringify transforme les data en class d'ou la function basketToArray dans l'abstractController

        const options = {
            method: 'POST',
            body: $formData
        };
    
    fetch('/Projet_Accou-ferme/buttonAddRemove', options)
        .then(response => response.json())
        .catch( error => {
        });

}

function listenButtonAdd(event){
    event.preventDefault();
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
            saveData(data);
            computeBasketTotal();
            renderBasket();
        })
        .catch( error => {
        });
}

function computeBasketTotal()
{
    
    let $basket = getData();
    let $price = 0;

    for(var i = 0; i < $basket.items.length; i++)
    {
        $price += ($basket.items[i].price * $basket.items[i].amount);
        $basket.totalPrice = $price;
    }
    saveData($basket);
    newFetch($basket);
}

// get the item key in the cart.items array
function findItem($varietyName)
{
    
    let $basket = getData();

    for(var i = 0; i < $basket.items.length; i++)
    {

        if($basket.items[i].variety === $varietyName)
        {
            return i;
        }
    }

    return null;
}

// update the item amount to + 1
function addItem(event)
{
    
    let $varietyName = event.target.getAttribute("data-variety-name");
    let $itemKey = findItem($varietyName);
    let $basket = getData();

    if($itemKey !== null)
    {
        $basket.items[$itemKey].amount += 1;
        saveData($basket);
        computeBasketTotal();
        renderBasket();
        newFetch($basket);
    }

}

// update the item amount to - 1
function removeItem(event)
{
    
    let $varietyName = event.target.getAttribute("data-variety-name");
    let $itemKey = findItem($varietyName);
    let $basket = getData();

    if($itemKey !== null)
    {
        $basket.items[$itemKey].amount -= 1;
        saveData($basket);
        computeBasketTotal();
        renderBasket();
        newFetch($basket);
    }

}

function loadListeners()
{
    
    let $addButtons = document.getElementsByClassName("updateButtonAdd");
    let $removeButtons = document.getElementsByClassName("updateButtonRemove");

    for(var i = 0; i < $addButtons.length; i++)
    {
        $addButtons[i].addEventListener("click", addItem);
        $removeButtons[i].addEventListener("click", removeItem);
    }
}

function createBasketItem($item){
    
    let $containerSection = document.createElement("section");
    $containerSection.classList.add("containerSection");

    // création de figure et image
    let $figure = document.createElement("figure");
    $figure.classList.add("updateImg");
    let $img = document.createElement("img");
    $img.setAttribute("alt", $item['media_alt']);
    $img.setAttribute("src", $item['media_url']);

    $figure.appendChild($img);

    $containerSection.appendChild($figure);

    // création des infos de la variété
    let $varietyInfo = document.createElement("section");
    $varietyInfo.classList.add("varietyInfo");
    let $varietyName = document.createElement("h3");
    $varietyName.classList.add("updateTitle");
    let $text = document.createTextNode($item.variety);
    $varietyName.appendChild($text);
    $varietyInfo.appendChild($varietyName);
    
    $containerSection.appendChild($varietyInfo);
    
    // création de la section boutons et amount
    let $buttonSection = document.createElement("section");
    $buttonSection.classList.add("amountAddRemove");

    let $newButtonAdd = document.createElement("button");
    $newButtonAdd.classList.add("updateButtonAdd");
    $newButtonAdd.classList.add("button");
    $newButtonAdd.setAttribute("id", "button-Add-"+$item.variety);
    $newButtonAdd.setAttribute("data-variety-name", $item.variety);
    let $textButtonAdd = document.createTextNode("+");
    $newButtonAdd.appendChild($textButtonAdd);
    
    let $newAmount = document.createElement("p");
    let $textNewAmount = document.createTextNode($item.amount);
    $newAmount.appendChild($textNewAmount);

    let $newButtonRemove = document.createElement("button");
    $newButtonRemove.classList.add("updateButtonRemove");
    $newButtonRemove.classList.add("button");
    $newButtonRemove.setAttribute("id", "button-Remove-"+$item.variety);
    $newButtonRemove.setAttribute("data-variety-name", $item.variety);
    let $textButtonRemove = document.createTextNode("-");
    $newButtonRemove.appendChild($textButtonRemove);
    
    $buttonSection.appendChild($newButtonAdd);
    $buttonSection.appendChild($newAmount);
    $buttonSection.appendChild($newButtonRemove);

    $containerSection.appendChild($buttonSection);

    let $unitPrice = document.createElement("p");
    $unitPrice.classList.add("unitPrice");

    let $newPrice = document.createElement("span");
    $newPrice.classList.add("updatePrice");
    $newPrice.setAttribute("data-variety-name", $item.variety);
    let $textNewPrice = document.createTextNode($item.price);
    $newPrice.appendChild($textNewPrice);

    let $newEuros = document.createElement("span");
    let $textNewEuros = document.createTextNode("€");
    $newEuros.appendChild($textNewEuros);

    let $slash = document.createElement("span");
    $slash.appendChild($textNewEuros);
    let $textSlash = document.createTextNode(" / ");
    $slash.appendChild($textSlash);

    let $newUnits = document.createElement("span");
    $newUnits.classList.add("updateUnits");
    $newUnits.setAttribute("data-product-name", $item.variety);
    let $textNewUnits = document.createTextNode($item.units.slice(0, -3));
    $newUnits.appendChild($textNewUnits);

    $unitPrice.appendChild($newPrice);
    $unitPrice.appendChild($newEuros);
    $unitPrice.appendChild($slash);
    $unitPrice.appendChild($newUnits);
    
    $containerSection.appendChild($unitPrice);
    
    let $totalVarietyPrice = document.createElement("section");
    $totalVarietyPrice.classList.add("updateTotalPrice");

    let $productPriceSpan = document.createElement("p");
    let $productPriceSpanContent = document.createTextNode("= " + $item.amount * $item.price);
    $productPriceSpan.appendChild($productPriceSpanContent);
    $productPriceSpan.appendChild($textNewEuros);

    $totalVarietyPrice.appendChild($productPriceSpan);

    $containerSection.appendChild($totalVarietyPrice);

    return $containerSection;
}

function renderBasket(){
    
    // je récupère les data
    let $basket = getData();

    // je vais chercher la section
    let $section = document.getElementById("updateContentSection");
    // et son ul 
    let $ul = document.getElementById("updateContent");
    // et je le retire 
    $section.removeChild($ul);
    // puis je le recrée
    let $newUL = document.createElement("ul");
    $newUL.setAttribute("id", "updateContent");

    // pour chaque produit dans le panier je crée un li et son contenu auquel j'ajoute une classe, un contenu, et éventuellement des attributs
    

    for(var i=0; i<$basket.items.length; i++){

        if($basket.items[i].amount > 0){
            
            console.log("je rentre dans le if");
            let $item = $basket.items[i];
            let $newLi = document.createElement("li");
            $newLi.classList.add("updateDetail");
            $newLi.appendChild(createBasketItem($item));
            $newUL.appendChild($newLi);
        }
        
        // je renvoie le ul dans la section
        $section.appendChild($newUL);
        
        // je mets à jour le prix total du panier
        let $totalOrderPrice = document.getElementById("totalOrderPrice");
        $totalOrderPrice.innerText = $basket.totalPrice;
        
        saveData($basket);

    }
        loadListeners();
}

// Maj du panier
function initBasket(){
    // le bouton Ajouter au panier
    let $buttonsAddToBasket = document.getElementsByClassName("buttonAddToBasket");

    for(var i = 0; i < $buttonsAddToBasket.length; i++)
    {
        $buttonsAddToBasket[i].addEventListener('click', listenButtonAdd);
    }
}

export { initBasket };