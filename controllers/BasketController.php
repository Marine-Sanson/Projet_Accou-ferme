<?php

class BasketController extends AbstractController
{
    public function index()
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
    
    // public function getAvailableVariety() : array
    // {
    //     $availableVariety = $this->vm->getAvailableVariety();

    //     $productId = $availableVariety[0]['product_id'];
        
    //     $name = $availableVariety[0]['name'];
    //     $quantityAvailable = $availableVariety[0]['quantity_available'];
        
    //     $productName = $this->pm->getProductName($productId);

    //     $fullAvailableVariety = [
    //         "productName" => $productName,
    //         "name" => $name,
    //         "quantityAvailable" => $quantityAvailable
    //         ];

    //     return $fullAvailableVariety;
        
    // }

}
