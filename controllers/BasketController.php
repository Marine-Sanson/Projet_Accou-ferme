<?php

class BasketController extends AbstractController
{
    public function index(array $post)
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

        $this->render("basket", ["allAvailableVarieties" => $allAvailableVarieties, "medias" => $medias]);
        
    }
    
    public function basketUpdate(array $post)
    {
        // Pour pouvoir vider le panier pour test
        // A ENLEVER ***************************
        // $_SESSION["basket"]=[];
            

        if($_POST["data"]) // the form has been submitted
        {
            
            // récupère le post de la variété ajoutée
            $availableVariety = $_POST["availableVarietyName"];
            $availableVarietyUnits = $_POST["availableVarietyUnits"];
            $availableVarietyPrice = $_POST["availableVarietyPrice"];
            
            $baskets = $_SESSION["basket"];
            
            //var_dump($baskets);
            
            if(count($baskets) < 1)
            {
                $_SESSION["basket"][] = [
                    "variety" => $availableVariety,
                    "amount" => 1,
                    "units" => $availableVarietyUnits,
                    "price" => $availableVarietyPrice
                ];

            }
            else 
            {
                foreach($baskets as $key => $basket){
                    
                    $this->verifyVariety($key, $basket, $availableVariety);
                
                }
            }
            

            // Ajoute la variété cliquée au panier
            // $_SESSION["basket"][] = [
            //     "variety" => $availableVariety,
            //     "amount" => 1,
            //     "units" => $availableVarietyUnits,
            //     "price" => $availableVarietyPrice
            //     ];
            
            $basket = $_SESSION["basket"];
            
            echo json_encode($basket);
            
        }
        else
        {
            echo json_encode($_POST);
        }
    }
    
    public function verifyVariety(int $key, array $basket, string $availableVariety) :void
    {
        //var_dump($basket);
        if($basket["variety"] === $availableVariety)
        {
            $amount = $basket["amount"] + 1;
            $baskets[$key]["amount"] = $amount;
            $_SESSION["basket"][$key]["amount"] = $amount;
        }
        else
        {
            $_SESSION["basket"][] = [
                "variety" => $availableVariety,
                "amount" => 1,
                "units" => $availableVarietyUnits,
                "price" => $availableVarietyPrice
                ];
        }
    
        
    }
    
    // public function verifyAmount(array $basket, string $availableVariety) :array
    // {
    //     if($basket["variety"] === $availableVariety)
    //     {
    //         $_SESSION["basket"][] = [
    //             "variety" => $availableVariety,
    //             "amount" => $amount++,
    //             "units" => $availableVarietyUnits,
    //             "price" => $availableVarietyPrice
    //             ];
    //     }
    //     else
    //     {
    //         $_SESSION["basket"][] = [
    //             "variety" => $availableVariety,
    //             "amount" => 1,
    //             "units" => $availableVarietyUnits,
    //             "price" => $availableVarietyPrice
    //             ];
    //     }
    // }

}
