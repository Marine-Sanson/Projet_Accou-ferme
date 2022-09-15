<?php

require "./models/Order.php";

class OrdersController extends AbstractController
{
    public function index() :void
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
        
        $template = "order";
        
        $this->render($template, ["order" => $order]);
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
    
    public function validationOrder(array $post) :void
    {
        $baskets = $_SESSION["basket"]["items"];
        
        $name = $this->test_input($_POST['name']);
        $firstName = $this->test_input($_POST['firstName']);
        $email = $this->test_input($_POST['email']);
        $tel = $this->test_input($_POST['tel']);
        $day = $this->test_input($_POST['date_retrait']);
        $totalPrice = $this->test_input($_POST['totalPrice']);
        $dateCommande = DateTime::createFromFormat("Y-m-d H:i:s", date("Y-m-d H:i:s"));

        $order = new Order(null, $name, $firstName, $email, $tel, $dateCommande, $day, $totalPrice, null);
        var_dump($order);
        $id = $this->om->createOrder($order);

        foreach($baskets as $key => $basket)
        {
            $idOrder = $id;
            $varietyName = $basket["variety"];
            $amount = $basket["amount"];
            $units = $basket["units"];
            $price = $basket["price"];
            $totalVariety = $amount * $price;
            $varietyId = $this->vm->getVarietyId($varietyName);
            $varietyId = $varietyId["id"];

            $this->om->createVarietyOrdered($idOrder, $varietyId, $varietyName, $amount, $units, $price, $totalVariety);
        }
        
        $_SESSION["basket"] = [];
        
        

        $this->render("_validationOrder");
    }
}

?>