<?php

class ProduceController extends AbstractController
{

    public function index()
    {
        $this->render("produce");
    }
    
    // lance la fonction du manager pour afficher les noms des produits
    public function displayProduce()
    {
        $products = $this->pm->getAllProduce();
        
        $this->render("produce", ["products" => $products]);
    
    }
    
}
