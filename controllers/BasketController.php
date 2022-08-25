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

        if($_POST["data"]) // the form has been submitted
        {
            
            // récupère le post de la variété ajoutée
            $availableVariety = $_POST["availableVarietyName"];


            // Ajoute la variété cliquée au panier
            $_SESSION["basket"][] = [
                "variety" => $availableVariety,
                "amount" => 1
                ];
            
            $basket = $_SESSION["basket"];
            
            echo json_encode($basket);
            
            $this->renderPartial("basket_update", $basket);
        }
        else
        {
            echo json_encode($_POST);
        }
    }
    
    
    public function updateAmount(array $basket)
    {
        var_dump($basket['0']['variety']);
    }

}
