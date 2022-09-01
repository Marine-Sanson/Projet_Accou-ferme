<?php

class OrderController extends AbstractController
{
    public function index()
    {
        // $orderVarieties = $this->BasketController->buttonAddRemove();
        
        $orderVarieties = $_SESSION["basket"];

        $order = [];

        $totalOrder = 0;
        
        foreach($orderVarieties as $key => $orderVariety)
        {
            $orderVarietyName = $orderVariety["variety"];
            $orderVarietyAmount = $orderVariety["amount"];
            $orderVarietyUnits = $orderVariety["units"];
            $orderVarietyPrice = $orderVariety["price"];
        
            $totalVariety = $this->totalVariety($orderVarietyAmount, $orderVarietyPrice);

            $totalOrder = $this->totalOrder($totalVariety, $totalOrder);
            
            $order[]= [
                "variety" => $orderVarietyName,
                "amount" => $orderVarietyAmount,
                "units" => $orderVarietyUnits,
                "price" => $orderVarietyPrice,
                "totalVariety" => $totalVariety,
                "totalOrder" => $totalOrder
                ];
        }
        
        $this->render("_order", ["order" => $order]);
    }
    
    public function totalVariety(int $orderVarietyAmount, int $orderVarietyPrice) :int
    {
        $totalVariety = $orderVarietyAmount * $orderVarietyPrice;
        return $totalVariety;

    }
    
    public function totalOrder(int $totalVariety, int $totalOrder) :int
    {
        $totalOrder = $totalOrder + $totalVariety;
        return $totalOrder;
    }
    
    public function validationOrder()
    {
        var_dump($_POST);
        $this->render("_validationOrder");
    }
}

?>