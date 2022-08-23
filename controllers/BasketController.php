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
    
    public function update(array $post){
        if(isset($_POST["data"])) // the form has been submitted
        {
            $availableVariety = $_POST["availableVarietyId"];
            $buttonAdd = $_POST["buttonAdd"];
            $buttonRemove = $_POST["buttonRemove"];
            $update = $this->renderPartial("_update", [
                "availableVarietyId" => $availableVariety,
                "buttonAdd" => $buttonAdd,
                "buttonRemove" => $buttonRemove
            ]);
        }
        else
        {
            $this->render("basket_update", [
            
            ]);
        }
    }
    
    
    public function updateQuantity(array $post)
    {
        echo "wdskgn";
    }

}
