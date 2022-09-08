<?php

class AdminOrdersController extends AbstractController
{
    public function index()
    {
        if($_SESSION["connectAdmin"] === true)
        {
            
            
            
            $this->render("adminOrders");
        }
        else
        {
            $this->render("admin");
        }
    }
}