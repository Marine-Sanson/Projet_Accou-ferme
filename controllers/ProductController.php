<?php

class ProductController extends AbstractController
{
    // lance la fonction du manager pour afficher les noms des produits
    public function index()
    {
        $products = $this->pm->getAllProducts();
        $this->render("product", ["products" => $products]);
    }
    
}
