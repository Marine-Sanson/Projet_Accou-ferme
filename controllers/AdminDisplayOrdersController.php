<?php

class AdminDisplayOrdersController extends AbstractController
{
    public function index(array $post) :void
    {
        if($_SESSION["connectAdmin"] === true)
        {
            $this->render("adminDisplayOrders");
        }
        else
        {
            $this->render("admin");
        }
    }
    
    public function displayOrdersByDay(array $post) :void
    {
        
        if($_SESSION["connectAdmin"] === true)
        {
            if(isset($_POST["day"])){
                
                $day = $_POST["day"];
                $allOrders = $this->om->getAllOrders($day);
                
                foreach($allOrders as $key => $order){

                    foreach($order as $key => $varieties){
                        $varieties = $this->om->getVarietiesOrderedByOrderId($order["id"]);
                    }
                }

                $this->render("adminDisplayOrders", ["allOrders" => $allOrders, "order" => $order, "varieties" => $varieties]);
            }
            else
            {
                $this->render("adminDisplayOrders");
            }
        }
        else
        {
            $this->render("admin");
        }
    }

    
}