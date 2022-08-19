<?php

class BasketController extends AbstractController
{
    public function index()
    {
        $allAvailableVarieties = $this->vm->getAllAvailableVarieties();
        

        $this->render("basket", ["allAvailableVarieties" => $allAvailableVarieties]);
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
