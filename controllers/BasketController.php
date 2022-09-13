<?php

class BasketController extends AbstractController
{

    /**
     * Renders the basket index page
     * @param array $post
     * @return void
     */
    public function index(array $post) :void
    {
        $allAvailableVarieties = $this->vm->getAllAvailableVarieties();
        $medias = [];

        foreach($allAvailableVarieties as $key => $availableVariety)
                {
                    if(!is_null($availableVariety['media_id'])){
                        
                        $mediaId = $availableVariety['media_id'];
                        $media = $this->mm->getMediaById($mediaId);
                        $item = [
                            "media" => $media,
                            "availableVariety" => $availableVariety
                            ];
                        $medias[] = $item;
                        //return $media;
                    }
                    else
                    {
                        $availableVariety["media_id"] = null;
                        $item = [
                            "media" => null,
                            "availableVariety" => $availableVariety
                            ];
                        $medias[] = $item;
                    }
                  
                }
                
        $template = "basket";
        
        $this->render($template, ["allAvailableVarieties" => $allAvailableVarieties, "medias" => $medias]);
        
    }
    
    
    /**
     * initialize $_SESSION["basket"]
     * @param array $post
     * @return void
     */
    public function basketUpdate(array $post) :void
    {
        // Pour pouvoir vider le panier pour test
        // A ENLEVER ***************************
        // $_SESSION["basket"]=[];
        
        if(!is_array($_SESSION["basket"]))
        {
            $tmp = $this->basketToArray($_SESSION["basket"]);
        
            $_SESSION["basket"] = $tmp;
        }

        if($_POST["data"]) // the form has been submitted
        {
            // récupère le post de la variété ajoutée
            $availableVariety = $_POST["availableVarietyName"];
            $availableVarietyUnits = $_POST["availableVarietyUnits"];
            $availableVarietyPrice = $_POST["availableVarietyPrice"];
            $availableVarietyMediaId = $_POST["availableVarietyMedia"];

            if($availableVarietyMediaId !== null){
                $getMedia = $this -> mm -> getMediaUrlAlt(intval($availableVarietyMediaId));
                
                if(!empty($getMedia)){
                $mediaUrl = $getMedia[0]["url"];
                $mediaAlt = $getMedia[0]["alt"];

                }
                else
                {
                $mediaUrl = "./assets/img/varieties/panierVide.jpg";
                $mediaAlt = "pas de photo disponible";
                }
                
            }
            else
            {
                $mediaUrl = "./assets/img/varieties/panierVide.jpg";
                $mediaAlt = "pas de photo disponible";
            }

            $baskets = $_SESSION["basket"];

            if(count($baskets) < 1)
            {
                $_SESSION["basket"]["items"][] = 
                [
                    "variety" => $availableVariety,
                    "amount" => 1,
                    "units" => $availableVarietyUnits,
                    "price" => $availableVarietyPrice,
                    "media_url" => $mediaUrl,
                    "media_alt" => $mediaAlt,
                ];
                $_SESSION["basket"]["totalPrice"] = $availableVarietyPrice;
            
            }
            else 
            {
                foreach($_SESSION["basket"]["items"] as $key => $basket){
                    
                    $this->verifyVariety($key, $basket, $availableVariety, $availableVarietyUnits, $availableVarietyPrice, $mediaUrl, $mediaAlt);
                }
            }
            
            echo json_encode($_SESSION["basket"]);
            
        }
        else
        {
            echo json_encode($_POST);
        }
    }
    
    
    /**
     * Return variety key
     * @param array $basket
     * @param string $variety
     * @return null | int
     */

    private function containsVariety(array $basket, string $variety) :?int
    {
        foreach($basket as $key => $item)
        {
            if($item["variety"] === $variety)
            {
                return $key;
            }
        }
        
        return null;
    }
    
    /**
     * Initialize a new variety in $_SESSION["basket"] or update amount
     * @param array ------------------- a finir
     * @param string
     * @return null | int
     */
    public function verifyVariety(int $key, array $basket, string $availableVariety, string $availableVarietyUnits, int $availableVarietyPrice, ?string $mediaUrl, ?string $mediaAlt) :void
    {
        $keyB = $this->containsVariety($_SESSION["basket"]["items"], $availableVariety);
        if($keyB === null)
        {
            $_SESSION["basket"]["items"][] = [
                "variety" => $availableVariety,
                "amount" => 1,
                "units" => $availableVarietyUnits,
                "price" => $availableVarietyPrice,
                "media_url" => $mediaUrl,
                "media_alt" => $mediaAlt
                ];
        }
        else
        {
            if($key === $keyB)
            {
                $_SESSION["basket"]["items"][$key]["amount"]++;
            }
        }

    }
    
    public function buttonAddRemove() :void
    {
        if(!is_array($_SESSION["basket"]))
        {
            $tmp = $this->basketToArray($_SESSION["basket"]);
        
            $_SESSION["basket"] = $tmp;
        }
        
        $baskets = json_decode($_POST["data"]);
        $_SESSION["basket"] = $baskets;
        
        foreach($baskets["items"] as $key => $basket){
            $_SESSION["basket"]["items"][] = [
                "variety" => $basket[$key]["variety"],
                "amount" => $basket[$key]["amount"],
                "units" => $basket[$key]["units"],
                "price" => $basket[$key]["price"],
                "media_url" => $basket[$key]["media_url"],
                "media_alt" => $basket[$key]["media_alt"],
            ];
        }
        
        $_SESSION["basket"]["totalPrice"] = [
            $baskets[$key]["totalPrice"]
        ];
    }
    
    public function basketOrder(array $post) :void
    {
        require "templates/order.phtml";
    }
    
}
