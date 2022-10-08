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
    
    /**
     * récupère le prix et la quantité commandée et renvoie le total d'une variété
     * @param int $orderVarietyAmount
     * @param int $orderVarietyPrice
     * @return int $totalVariety
     */
    
    public function totalVariety(int $orderVarietyAmount, int $orderVarietyPrice) :int
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
    
    public function totalOrder(int $totalVariety, int $totalOrder) :int
    {
        $totalOrder = $totalOrder + $totalVariety;
        
        return $totalOrder;
    }
    
    /**
     * récupère le $_SESSION["basket"] et le formulaire de validation de commande le clean et le vérifie puis le rentre dans la base de données
     * @param array $post
     * @return void
     */
    
    public function validationOrder(array $post) :void
    {
        var_dump($post);
        
        $baskets = $_SESSION["basket"]["items"];

        $errors = [];
        $validation = [];
        
        foreach($baskets as $key => $basket)
        {
            $varietyName = $basket["variety"];
            $id = $this->vm->getVarietyId($varietyName);
            $varietyId = $id["id"];
            
            $variety = $this->vm->getVarietyById($varietyId);
            $varietyQuantityAvailable = $variety->getQuantityAvailable();
            
            if($basket["amount"] > $varietyQuantityAvailable)
            {
                $errors[] = "stock insuffisant pour la variété $varietyName, veuillez modifier votre commande";
                
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
            }
        }
        
        if($errors !== [])
        {
            $template = "basket";
            
            $this->render($template, ["errors" => $errors, "allAvailableVarieties" => $allAvailableVarieties, "medias" => $medias]);
        }
        else
        {
            if(isset($_POST["name"]) && $_POST["name"] !== "")
            {
                $name = $this->clean_input($_POST["name"]);
            }
            else
            {
                $name = "";
                $errors[] = "Veuillez renter votre nom";
            }
            
            if(isset($_POST["firstName"]) || $_POST["firstName"] !== "")
            {
                $firstName = $this->clean_input($_POST["firstName"]);
            }
            else
            {
                $firstName = "";
                $errors[] = "Veuillez renter votre prénom";
            }
            
            var_dump($firstName);
    
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
    
            if($errors === [])
            {
                $totalPrice = $this->clean_input($_POST['totalPrice']);
                $dateCommande = DateTime::createFromFormat("Y-m-d H:i:s", date("Y-m-d H:i:s"));
        
                $order = new Order(null, $name, $firstName, $email, $tel, $dateCommande, $day, $totalPrice, null);
                $id = $this->om->createOrder($order);
        
                foreach($baskets as $key => $basket)
                {
                    $idOrder = $id;
                    $varietyName = $basket["variety"];
                    $amount = $basket["amount"];
                    $units = $basket["units"];
                    $price = $basket["price"];
                    $totalVariety = $amount * $price;
                    $id = $this->vm->getVarietyId($varietyName);
                    $varietyId = $id["id"];
        
                    $this->om->createVarietyOrdered($idOrder, $varietyId, $varietyName, $amount, $units, $price, $totalVariety);
                }
                
                $validation[] = "Votre commande à bien été prise en compte, à $day pour le retrait";
    
                $_SESSION["basket"] = [];
                
                $template = "_validationOrder";
                
                $this->render($template, ["validation" => $validation]);
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
                
                
                $template = "order";
                
                $this->render($template, ["errors" => $errors, "customer" => $customer]);
            }

        }
        

    }
    
    
}
