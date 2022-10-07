<?php

class ProductManager extends AbstractManager
{
    
    /**
     * reçoit un Product et le crée dans la base de données
     * @param Product
     * @return 
     */
    
    public function createProduct(Product $product) : void
    {
        $query = $this->db->prepare('INSERT INTO products ( name ) VALUES ( :name )');
        $parameters = [
            'name' => $product->getName(),
        ];
        $query->execute($parameters);
    }
    
    /**
     * va chercher tous les produits et les variétés qui en dépendent
     * @param 
     * @return un array avec tous les Products et les variétés associées
     */

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
    
    /**
     * va chercher tous les produits
     * @param 
     * @return un array avec tous les Product
     */
    
    public function getProducts() :array
    {
        $query = $this->db->prepare('SELECT id, name FROM products');
        $query->execute();
        $products = $query->fetchAll(PDO::FETCH_ASSOC);
        
        return $products;
    }
    
    /**
     * va chercher tous les id des produits
     * @param 
     * @return un array avec tous les id des produits
     */

    public function getAllIdProduct() :array
    {
        $query = $this->db->prepare('SELECT id FROM products');
        $query->execute();
        $idProducts = $query->fetchAll(PDO::FETCH_ASSOC);
        
        return $idProducts;
    }
    
    /**
     * va chercher l'id d'un produit d'après son nom
     * @param $name
     * @return id
     */
    
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

    /**
     * va chercher le nom d'un produit d'après son id
     * @param $id
     * @return name
     */

    public function getProductName(int $id) : string
    {
        $query = $this->db->prepare('SELECT name FROM products WHERE products.id = :id');
        $parameters = [
            'id' => $id
        ];
        $query->execute($parameters);
        $product = $query->fetch(PDO::FETCH_ASSOC);
        
        $productName = $product['name'];

        return $productName;
    }
    
    /**
     * supprime un produit d'après son id
     * @param $id
     * @return
     */
     
    public function deleteProduct(int $id) : void
    {
        $query = $this->db->prepare('DELETE FROM products WHERE products.id = :id');
        $parameters = [
            'id' => $id
        ];
        $query->execute($parameters);
    }
}

?>