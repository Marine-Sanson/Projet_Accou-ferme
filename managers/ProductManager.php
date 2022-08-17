<?php

class ProductManager extends DBConnect
{
    
    // permet de créer un nouveau produit
    public function createProduct(Product $product) : Product
    {
        
        $query = $this->db->prepare('INSERT INTO products ( name ) VALUES ( :name )');
        $parameters = [
            'name' => $name->getName(),
        ];
        $query->execute($parameters);
        
        $produce = [];

        return $produce;
    }
    
    // va chercher un tableau avec tous les produits
    public function getAllProducts() :array
    {
        $query = $this->db->prepare('SELECT name, id FROM products');
        $query->execute();
        $products = $query->fetchAll(PDO::FETCH_ASSOC);
        
        $fullProducts = [];
        foreach ($products as $product)
        {
            $fullProduct = [];
            $fullProduct["product"] = $product;
            $vm = new VarietyManager();
            $fullProduct["varieties"] = $vm->getVarietyByProduct($product['name']);
            $fullProducts[] = $fullProduct;
        }
        
        return $fullProducts;
    }
    
    // va chercher un tableau avec tous les id des produits
    public function getAllIdProduct() :array
    {
        $query = $this->db->prepare('SELECT id FROM products');
        $query->execute();
        $idProducts = $query->fetchAll(PDO::FETCH_ASSOC);
        
        return $idProducts;
    }
    
    // va chercher l'id d'un produit d'après son nom
    public function getProduceId(string $name) : int
    {
        $query = $this->db->prepare('SELECT id FROM products WHERE products.name = :name');
        $parameters = [
            'name' => $name
        ];
        $query->execute($parameters);
        $result = $query->fetch(PDO::FETCH_ASSOC);
        
        $product = [];

        return $product['id'];
    }
    
    // va chercher le nom d'un produit d'après son id
    public function getProductName(int $id) : string
    {
        $query = $this->db->prepare('SELECT name FROM products WHERE products.id = :id');
        $parameters = [
            'id' => $id
        ];
        $query->execute($parameters);
        $result = $query->fetch(PDO::FETCH_ASSOC);
        
        $product = [];
        $productName = $product['name'];

        return $productName;
    }
    
    // permet de supprimer un produit
    public function deleteProduct(Product $product) : void
    {
        
        $query = $this->db->prepare('DELETE id, name FROM products WHERE products.name = :name');
        $parameters = [
            'name' => $name
        ];
        $query->execute($parameters);
        $result = $query->fetchAll(PDO::FETCH_ASSOC);
        
    }
    
}

?>