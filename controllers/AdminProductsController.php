<?php

require "./models/Product.php";
require "./models/Variety.php";


class AdminProductsController extends AbstractController
{
    public function index() :void
    {
        if($_SESSION["connectAdmin"] === true)
        {
            $allProducts = $this->pm->getProducts();
            $allVarieties = $this->vm->getAllVarieties();
            
            $this->render("adminProducts", ["allProducts" => $allProducts, "allVarieties" => $allVarieties]);
        }
        else if($_SESSION["connectAdmin"] === false || empty($_SESSION["connectAdmin"]))
        {
            $errors[] = "Veuillez vous connecter";
            $this->render("admin", ["errors" => $errors]);
        }
    }
    
    public function productCreated(array $post) :void
    {
        if($_SESSION["connectAdmin"] === true)
        {
            $name = $_POST["newProd"];
            $newProd = new Product(null, $name);

            $this->pm->createProduct($newProd);
            
            $validation = "nouveau produit créé";
            
            $allProducts = $this->pm->getProducts();
            $allVarieties = $this->vm->getAllVarieties();
            
            $this->render("adminProducts", ["allProducts" => $allProducts, "allVarieties" => $allVarieties, "validation" => $validation]);
        }
        else
        {
            $errors[] = "Veuillez vous connecter";
            $this->render("admin", ["errors" => $errors]);
        }
    }
    
    public function deleteProduct(array $post) :void
    {
        if($_SESSION["connectAdmin"] === true)
        {
            var_dump($post);
            
            $inputid = $this->clean_input($_POST["productId"]);
            $id = intval($inputid);
            
            if($id < 0 || strlen($inputid) > 5 || $id === "")
            {
                $errors[] = "Veuillez selectionner un produit";
            }
            
            $allVarieties = $this->vm->getAllVarieties();

            if(!isset($errors) || count($errors) <= 0)
            {
                $this->pm->deleteProduct($id);
                $validation = "Produit spprimé";
                
                $allProducts = $this->pm->getProducts();

                $this->render("adminProducts", ["allProducts" => $allProducts, "allVarieties" => $allVarieties, "validation" => $validation]);
            }
            
            $allProducts = $this->pm->getProducts();

            $this->render("adminProducts", ["allProducts" => $allProducts, "allVarieties" => $allVarieties, "errors" => $errors]);
        }
        else
        {
            $errors[] = "Veuillez vous connecter";
            $this->render("admin", ["errors" => $errors]);
        }
    }

    public function adminCrudVariety(array $post) :void
    {

        $action = $post["action"];
        $allProducts = $this->pm->getProducts();
        
        if(isset($post["crudId"]) && $post["crudId"] !== null)
        {
            $crudId = $post["crudId"];
            $variety = $this->vm->getVarietyById($crudId);
        }
        else
        {
            $crudId = 0;
            $variety = [];
        }
        
        $this->render("adminCrudVariety", ["action" => $action, "allProducts" => $allProducts, "variety" => $variety]);
    }
    
    public function createVariety(array $post) :void
    {
        if($_SESSION["connectAdmin"] === true)
        {
            $action = "create";
            $varietyVerified = $this->verifyVariety($post, $action);
            $allProducts = $this->pm->getProducts();
            
            if(empty($varietyVerified["errors"]))
            {
                $this->vm->createVariety($varietyVerified["variety"]);

                $allVarieties = $this->vm->getAllVarieties();
                $validation = "Votre varieté a bien été créée!";
                
                $this->render("adminProducts", ["validation" => $validation, "allProducts" => $allProducts, "allVarieties" => $allVarieties]);
            }
            else
            {
                $errors = $varietyVerified["errors"];
                $action = "create";
                $variety = $varietyVerified["variety"];
                $this->render("adminCrudVariety", ["variety" => $variety, "allProducts" => $allProducts, "errors" => $errors, "action" => $action]);
            }
            
        }
        else
        {
            $errors[] = "Veuillez vous connecter";
            $this->render("admin", ["errors" => $errors]);
        }
    }

    public function updateVariety(array $post)
    {
        if($_SESSION["connectAdmin"] === true)
        {
            $action = "update";
            $varietyVerified = $this->verifyVariety($post, $action);
            $variety = $varietyVerified["variety"];
            $allProducts = $this->pm->getProducts();
            
            if(empty($varietyVerified["errors"]))
            {
                $this->vm->updateVariety($variety);
                $allVarieties = $this->vm->getAllVarieties();
                
                $validation = "Votre varieté a bien été modifiée!";
    
                $this->render("adminProducts", ["validation" => $validation, "allVarieties" => $allVarieties, "allProducts" => $allProducts]);
            }
            else
            {
                $errors = $varietyVerified["errors"];

                $this->render("adminCrudVariety", ["variety" => $variety, "allProducts" => $allProducts, "errors" => $errors, "action" => $action]);
            }
        }
    }
    
    public function deleteVariety(array $post)
    {
        if($_SESSION["connectAdmin"] === true)
        {
            $action = "delete";
            $varietyVerified = $this->verifyVariety($post, $action);
            $allProducts = $this->pm->getProducts();
            
            if(empty($varietyVerified["errors"]))
            {
                $variety = $varietyVerified["variety"];
                $this->vm->deleteVariety($variety);
                $allVarieties = $this->vm->getAllVarieties();
                
                $validation = "Votre varieté a bien été suprimée!";
    
                $this->render("adminProducts", ["validation" => $validation, "allVarieties" => $allVarieties, "allProducts" => $allProducts]);
            }
            else
            {
                $errors = $varietyVerified["errors"];
                $variety = $varietyVerified["variety"];

                $this->render("adminCrudVariety", ["variety" => $variety, "allProducts" => $allProducts, "errors" => $errors, "action" => $action]);
            }
        }
    }
    
    public function verifyVariety(array $post, string $action) :array
    {
        $errors = [];
        
        if(!isset($post["id"]))
        {
            $errors[] = "Veuillez recommencer, cette action a généré un problème";
        }
        else
        {
            $inputId = $this->clean_input($post["id"]);
            $id = intval($inputId);
            
            if(strlen($inputId) > 5)
            {
                $errors[] = "Veuillez recommencer, cette action a généré un problème";
            }
        }
        
        if(!isset($post["productId"]))
        {
            $errors[] = "Veuillez selectionner un produit valide";
        }
        else
        {
            var_dump($post["productId"]);
            $inputProductId = $this->clean_input($post["productId"]);
            $productId = intval($inputProductId);

            if(strlen($inputProductId) > 5)
            {
                $errors[] = "Veuillez selectionner un produit valide";
            }
            if($inputProductId === "")
            {
                $errors[] = "Veuillez selectionner un produit";
            }
            if($inputProductId === 0 || $inputProductId === "0")
            {
                $errors[] = "Veuillez selectionner un produit";
            }
            var_dump($productId);
        }
        
        if(!isset($post["name"]))
        {
            $errors[] = "Veuillez mettre un nom";
        }
        else
        {
            $name = $this->clean_input($post["name"]);
            
            if($name === "")
            {
                $errors[] = "Veuillez mettre un nom";
            }
        
            if(strlen($name) > 256)
            {
                $errors[] = "Veuillez entrer un nom plus court (max 255 caractères)";
            }
    
            if(!is_string($name))
            {
                $errors[] = "Veuillez entrer un nom valide";
            }
        }
        
        if(!isset($post["seasonStart"]))
        {
            $errors[] = "Veuillez entrer un début de saison";
        }
        else
        {
            $seasonStart = $this->clean_input($post["seasonStart"]);
            
            if($seasonStart === "")
            {
                $errors[] = "Veuillez entrer un début de saison";
            }
            
            if(strlen($seasonStart) > 256)
            {
                $errors[] = "Veuillez entrer un début de saison plus court (max 255 caractères)";
            }
    
            if(!is_string($seasonStart))
            {
                $errors[] = "Veuillez entrer un début de saison valide";
            }            
        }

        if(!isset($post["seasonEnd"]))
        {
            $errors[] = "Veuillez entrer une fin de saison";
        }
        else
        {
            $seasonEnd = $this->clean_input($post["seasonEnd"]);
            
            if($seasonEnd === "")
            {
                $errors[] = "Veuillez entrer une fin de saison";
            }
            
            if(strlen($seasonEnd) > 256)
            {
                $errors[] = "Veuillez entrer une fin de saison plus court (max 255 caractères)";
            }
    
            if(!is_string($seasonEnd))
            {
                $errors[] = "Veuillez entrer une fin de saison valide";
            }            
        }
        
        if(!isset($post["description"]))
        {
            $errors[] = "Veuillez entrer une description";
        }
        else
        {
            $description = $this->clean_input($post["description"]);
            
            if($description === "")
            {
                $errors[] = "Veuillez entrer une description";
            }
            
            if(strlen($description) > 2048)
            {
                $errors[] = "Veuillez entrer une description plus courte (max 2047 caractères)";
            }
        
            if(!is_string($description))
            {
                $errors[] = "Veuillez entrer une description valide";
            }
        }
        
        if(!isset($post["mediaId"]))
        {
            var_dump("if !isset");
            $errors[] = "Veuillez entrer une image";
            $mediaId = null;
        }
        else
        {
            $inputMediaId = $this->clean_input($post["mediaId"]);
            $mediaId = intval($inputMediaId);
            
            if($mediaId == "")
            {
                $mediaId = null;
            }
        }
        
        if(!isset($post["availablity"]))
        {
            $errors[] = "Veuillez cocher oui ou non pour la disponibilité";
            
            $availablity = "";
        }
        else
        {
            $inputAvailablity = $this->clean_input($post["availablity"]);
            $availablity = boolval($inputAvailablity);

            if($availablity === "")
            {
                $errors[] = "Veuillez cocher oui ou non pour la disponibilité";
            }
            
            if(strlen($availablity) > 1 || !is_bool($availablity))
            {
                $errors[] = "Veuillez entrer une disponibilité valide";
            }
            
            if($availablity === false)
            {
                var_dump("je rentre dans le if = false");
                $availablity = 0;
                var_dump($availablity);
            }
            if($availablity === true)
            {
                var_dump("je rentre dans le if = true");
                $availablity = 1;
            }
        }

        var_dump("offer");
        if(!isset($post["offer"]))
        {
            $errors[] = "Veuillez cocher oui ou non pour le produit du moment";
            $offer = "";
        }
        else
        {
            $inputOffer = $this->clean_input($post["offer"]);
            $offer = boolval($inputOffer);
            
            if($offer === "")
            {
                $errors[] = "Veuillez cocher oui ou non pour le produit du moment";
            }
            
            if(strlen($offer) > 1 || !is_bool($offer))
            {
                $errors[] = "Veuillez entrer un produit du moment valide";
            }
        }
        var_dump("quantityAvailable");
        if(!isset($post["quantityAvailable"]))
        {
            $errors[] = "Veuillez entrer une quantité disponible";
        }
        else
        {
        $inputQuantityAvailable = $this->clean_input($post["quantityAvailable"]);
        $quantityAvailable = intval($inputQuantityAvailable);
            
            if($quantityAvailable === "")
            {
                $errors[] = "Veuillez entrer une quantité disponible";
            }
            
            if(strlen($quantityAvailable) > 12)
            {
                $errors[] = "Veuillez entrer une quantité disponible plus courte (max 11 caractères)";
            }
            
            if(!is_int($quantityAvailable))
            {
                $errors[] = "Veuillez entrer une quantité disponible valide";
            }
        }
        var_dump("units");
        if(!isset($post["units"]))
        {
            $errors[] = "Veuillez entrer une unité de vente";
        }
        else
        {
            $units = $this->clean_input($post["units"]);
            
            if($units === "")
            {
                $errors[] = "Veuillez entrer une unité de vente";
            }
            
            if(strlen($units) > 12)
            {
                $errors[] = "Veuillez entrer une unité de vente plus courte (max 11 caractères)";
            }
            
            if(!is_string($units))
            {
                $errors[] = "Veuillez entrer une unité de vente valide";
            }
        }
        var_dump("price");
        if(!isset($post["price"]))
        {
            $errors[] = "Veuillez entrer un prix";
        }
        else
        {
            $inputPrice = $this->clean_input($post["price"]);
            $price  = intval($inputPrice);
            
            if($price === "")
            {
                $errors[] = "Veuillez entrer un prix";
            }
            
            if(strlen($price) > 6)
            {
                $errors[] = "Veuillez entrer un prix plus court (max 5 caractères)";
            }
            
            if(!is_int($price))
            {
                $errors[] = "Veuillez entrer un prix valide";
            }
        }
        var_dump($errors);
        $variety = new Variety($id, $productId, $name, $seasonStart, $seasonEnd, $description, $mediaId, $availablity, $offer, $quantityAvailable, $units, $price);
        
        $verifyVariety = [
            "errors" => $errors,
            "action" => $action,
            "variety" => $variety
            ];
            
        return $verifyVariety;
    }
}