<?php

class AdminProductsController extends AbstractController
{
    public function index()
    {
        if($_SESSION["connectAdmin"] === true)
        {
            $this->render("adminProducts");
        }
        else
        {
            $this->render("admin");
        }
    }
    
}