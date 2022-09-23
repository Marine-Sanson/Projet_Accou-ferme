<?php

class AdminDisplayOrdersController extends AbstractController
{
    public function index(array $post) :void
    {
        if($_SESSION["connectAdmin"] === true)
        {
            $this->render("adminDisplayOrders");
        }
        else if($_SESSION["connectAdmin"] === false || empty($_SESSION["connectAdmin"]))
        {
            $errors[] = "Veuillez vous connecter";
            $this->render("admin", ["errors" => $errors]);
        }
    }
    
    public function displayOrdersByDay(array $post) :void
    {
        
        if($_SESSION["connectAdmin"] === true)
        {
            if(isset($_POST["day"])){
                
                $day = $_POST["day"];
                $endOrder = false;
                $allOrders = $this->om->getAllOrders($day, $endOrder);
                
                foreach($allOrders as $key => $order){

                    foreach($order as $key => $orderDetail){
                        $varieties = $this->om->getVarietiesOrderedByOrderId($order["id"]);
                    }
                }

                $this->render("adminDisplayOrders", ["allOrders" => $allOrders, "varieties" => $varieties]);
            }
            else
            {
                $this->render("adminDisplayOrders");
            }
        }
        else if($_SESSION["connectAdmin"] === false || empty($_SESSION["connectAdmin"]))
        {
            $errors[] = "Veuillez vous connecter";
            $this->render("admin", ["errors" => $errors]);
        }
    }

    public function endOrder(array $post) :void
    {
        $id = intval($_POST["id"]);
        
        $endOrder = $this->om->updateEndOrder($id);
        
        $this->render("adminDisplayOrders");
    }
    
}