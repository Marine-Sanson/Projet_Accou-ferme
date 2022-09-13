<?php

class AdminOrdersController extends AbstractController
{
    public function index() :void
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