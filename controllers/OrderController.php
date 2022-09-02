<?php

class OrderController extends AbstractController
{
    public function index()
    {
        // $orderVarieties = $this->BasketController->buttonAddRemove();
        
        if(!is_array($_SESSION["basket"]))
        {
            $tmp = $this->basketToArray($_SESSION["basket"]);
        
            $_SESSION["basket"] = $tmp;
        }

        $orderVarieties = $_SESSION["basket"];

        $order = [];

        foreach($orderVarieties["items"] as $key => $orderVariety)
        {
            $orderVarietyName = $orderVariety["variety"];
            $orderVarietyAmount = $orderVariety["amount"];
            $orderVarietyUnits = $orderVariety["units"];
            $orderVarietyPrice = $orderVariety["price"];
        
            $totalVariety = $this->totalVariety($orderVarietyAmount, $orderVarietyPrice);

            // $totalOrder = $this->totalOrder($totalVariety, $totalOrder);
            
            $order["items"][]= [
                "variety" => $orderVarietyName,
                "amount" => $orderVarietyAmount,
                "units" => $orderVarietyUnits,
                "price" => $orderVarietyPrice,
                "totalVariety" => $totalVariety
                ];
        }
        
        $order["totalPrice"] = $_SESSION["basket"]["totalPrice"];
        
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
        $this->render("_validationOrder");
    }
}

?>