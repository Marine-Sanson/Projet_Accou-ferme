<?php

class OrdersController extends AbstractController
{
    
    /**
     * récupère une commande dans le $_SESSION["basket"] et le renvoie en un array $order
     * @param $_SESSION["basket"]
     * @return array $order
     */

    public function index() :void
    {
        
        if(!is_array($_SESSION["basket"]))
        {
            $tmp = $this->basketToArray($_SESSION["basket"]);
        
            $_SESSION["basket"] = $tmp;
        }

        $orderVarieties = $_SESSION["basket"];

        $order = [];
        $errors = [];
        
        if(!isset($totalOrder))
        {
            $totalOrder = 0;
        }

        foreach($orderVarieties["items"] as $key => $orderVariety)
        {
            if($orderVariety["amount"] > 0){
                $orderVarietyName = $orderVariety["variety"];
                $orderVarietyAmount = $orderVariety["amount"];
                $orderVarietyUnits = $orderVariety["units"];
                $orderVarietyPrice = $orderVariety["price"];
                
                $tmpId = $this->vm->getVarietyId($orderVarietyName);
                $orderVarietyId = $tmpId["id"];
                
                $variety = $this->vm->getVarietyById($orderVarietyId);
                $varietyQuantityAvailable = $variety->getQuantityAvailable();
    
                if($orderVarietyAmount > $varietyQuantityAvailable)
                {
                    $errors[] = "stock insuffisant pour la variété $orderVarietyName,
                    nous l'avons remplacé par $varietyQuantityAvailable, quantité maximum possible";
                    $orderVarietyAmount = $varietyQuantityAvailable;
                }
    
                $totalVariety = $this->totalVariety($orderVarietyAmount, $orderVarietyPrice);
        
                $totalOrder = $this->totalOrder($totalVariety, $totalOrder);
                
                $order["items"][]= [
                    "variety" => $orderVarietyName,
                    "amount" => $orderVarietyAmount,
                    "units" => $orderVarietyUnits,
                    "price" => $orderVarietyPrice,
                    "totalVariety" => $totalVariety
                ];
            }
        }
        
        $order["totalPrice"] = $totalOrder;
        
        if($errors === [])
        {
            $template = "order";
            
            $this->render($template, ["order" => $order]);
        }
        else
        {
            $template = "order";
            
            $this->render($template, ["order" => $order, "errors" => $errors]);
        }
    }
    
    /**
     * récupère le prix et la quantité commandée et renvoie le total d'une variété
     * @param int $orderVarietyAmount
     * @param int $orderVarietyPrice
     * @return int $totalVariety
     */
    
    public function totalVariety(float $orderVarietyAmount, float $orderVarietyPrice) :float
    {
        $totalVariety = $orderVarietyAmount * $orderVarietyPrice;

        return $totalVariety;
    }
    
    /**
     * récupère le total de la commande et le prix de la variété et renvoie le nouveau total de la commande
     * @param int $totalVariety
     * @param int $totalOrder
     * @return int $totalOrder
     */
    
    public function totalOrder(float $totalVariety, float $totalOrder) :float
    {
        $totalOrder = $totalOrder + $totalVariety;
        
        return $totalOrder;
    }
    
    /**
     * récupère le $_SESSION["basket"] et le formulaire de validation de commande ($_POST) le clean et le vérifie
     * puis le rentre dans la base de données
     * @param
     * @return void
     */
    
    public function validationOrder() :void
    {
        $baskets = $_SESSION["basket"]["items"];

        $errors = [];
        $validation = [];
        
        if(isset($_POST["name"]) && $_POST["name"] !== "")
        {
            $name = $this->clean_input($_POST["name"]);
        }
        else
        {
            $name = "";
            $errors[] = "Veuillez renter votre nom";
        }
        
        if(isset($_POST["firstName"]) && $_POST["firstName"] !== "")
        {
            $firstName = $this->clean_input($_POST["firstName"]);
        }
        else
        {
            $firstName = "";
            $errors[] = "Veuillez renter votre prénom";
        }
        
        if(isset($_POST["email"]) && $_POST["email"] !== "")
        {
            $email = $this->clean_input($_POST["email"]);
        }
        else
        {
            $email = "";
            $errors[] = "Veuillez renter votre email";
        }

        if(isset($_POST["tel"]) && $_POST["tel"] !== "")
        {
            $inputTel = $this->clean_input($_POST["tel"]);
            $tel = intval($inputTel);
        }
        else
        {
            $tel = "";
            $errors[] = "Veuillez renter votre numéro de téléphone";
        }

        
        if(isset($_POST["date_retrait"]) && $_POST["date_retrait"] !== "")
        {
            $day = $this->clean_input($_POST['date_retrait']);
        }
        else
        {
            $day = "";
            $errors[] = "Veuillez choisir un jour de retrait";
        }
        
        $inputTotalPrice = $this->clean_input($_POST['totalPrice']);
        $totalPrice = floatval($inputTotalPrice);
        $dateCommande = DateTime::createFromFormat("Y-m-d H:i:s", date("Y-m-d H:i:s"));
        
        if($errors === [])
        {
            $order = new Order(null, $name, $firstName, $email, $tel, $dateCommande, $day, $totalPrice, false);
            $id = $this->om->createOrder($order);
    
            foreach($baskets as $key => $basket)
            {
                if($basket["amount"] > 0)
                {
                    $idOrder = $id;
                    $varietyName = $basket["variety"];
                    $amount = $basket["amount"];
                    $units = $basket["units"];
                    $price = $basket["price"];
                    
                    $tmpId = $this->vm->getVarietyId($varietyName);
                    $varietyId = $tmpId["id"];
                    
                    $variety = $this->vm->getVarietyById($varietyId);
                    $varietyQuantityAvailable = $variety->getQuantityAvailable();
    
                    if($amount > $varietyQuantityAvailable)
                    {
                        $errors[] = "stock insuffisant pour la variété $varietyName, nous l'avons remplacé par
                        $varietyQuantityAvailable, quantité maximum possible";
                        $amount = $varietyQuantityAvailable;
                    }
    
                    $totalVariety = $amount * $price;
    
                    $this->om->createVarietyOrdered($idOrder, $varietyId, $varietyName, $amount, $units, $price,
                    $totalVariety);
                    
                    $newQuantityAvailable = $varietyQuantityAvailable - $amount;
                    $this->vm->updateVarietyQuantityAvailable($varietyId, $newQuantityAvailable);
                }
            }
            
            $_SESSION["basket"] = [];
            
            $template = "_validationOrder";
            
            $this->render($template);
        }
        else
        {
            $customer = [
                "name" => $name,
                "first_name" => $firstName,
                "email" => $email,
                "tel" => $tel,
                "day" => $day
            ];
            
            foreach($baskets as $key => $basket){
                
                $varietyName = $basket["variety"];
                $amount = $basket["amount"];
                $units = $basket["units"];
                $price = $basket["price"];
                $totalVariety = $amount * $price;

                $tmpId = $this->vm->getVarietyId($varietyName);
                $varietyId = $tmpId["id"];
                
                $variety = $this->vm->getVarietyById($varietyId);
                $varietyQuantityAvailable = $variety->getQuantityAvailable();

                if($amount > $varietyQuantityAvailable)
                {
                    $errors[] = "stock insuffisant pour la variété $varietyName, nous l'avons remplacé par
                    $varietyQuantityAvailable, quantité maximum possible";
                    $amount = $varietyQuantityAvailable;
                }

                $order["items"][] = [
                    "variety" => $varietyName,
                    "amount" => $amount,
                    "units" => $units,
                    "price" => $price,
                    "totalVariety" => $totalVariety,
                    "varietyId" => $varietyId
                ];
            }
            
            $order["totalPrice"] = floatval($totalPrice);

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
            
            $template = "order";
            
            $this->render($template, ["errors" => $errors, "customer" => $customer, "order" => $order,
            "allAvailableVarieties" => $allAvailableVarieties]);
        }
    }
}
