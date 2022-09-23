<?php

class AdminOrdersController extends AbstractController
{
    public function index() :void
    {
        if($_SESSION["connectAdmin"] === true)
        {
            
            $this->render("adminOrders");
        }
        else if($_SESSION["connectAdmin"] === false || empty($_SESSION["connectAdmin"]))
        {
            $errors[] = "Veuillez vous connecter";
            $this->render("admin", ["errors" => $errors]);
        }
    }
}