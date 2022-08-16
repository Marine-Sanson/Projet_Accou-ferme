<?php

class ProduceManager extends DBConnect
{
    
    // permet de créer un nouveau produit
    public function createProduce(Produce $produce) : Produce
    {
        
        $query = $this->db->prepare('INSERT INTO produce ( name ) VALUES ( :name )');
        $parameters = [
            'name' => $name->getName(),
        ];
        $query->execute($parameters);
        
        $produce = [];

        return $produce;
    }
    
    // va chercher un tableau avec tous les produits
    public function getAllProduce() :array
    {
        $query = $this->db->prepare('SELECT name FROM produce');
        $query->execute();
        $products = $query->fetchAll(PDO::FETCH_ASSOC);
        
        return $products;
    }
    
    // va chercher un tableau avec tous les id des produits
    public function getAllIdProduce() :array
    {
        $query = $this->db->prepare('SELECT id FROM produce');
        $query->execute();
        $idProducts = $query->fetchAll(PDO::FETCH_ASSOC);
        
        return $idProducts;
    }
    
    // va chercher l'id d'un produit d'après son nom
    public function getProduceId(string $name) : int
    {
        $query = $this->db->prepare('SELECT id FROM produce WHERE produce.name = :name');
        $parameters = [
            'name' => $name
        ];
        $query->execute($parameters);
        $result = $query->fetch(PDO::FETCH_ASSOC);
        
        $produce = [];

        return $produce['id'];
    }
    
    // va chercher le nom d'un produit d'après son id
    public function getProduceName(int $id) : string
    {
        $query = $this->db->prepare('SELECT name FROM produce WHERE produce.id = :id');
        $parameters = [
            'id' => $id
        ];
        $query->execute($parameters);
        $result = $query->fetch(PDO::FETCH_ASSOC);
        
        $produce = [];
        $produceName = $produce['name'];

        return $produceName;
    }
    
    // permet de supprimer un produit
    public function deleteProduce(Produce $produce) : void
    {
        
        $query = $this->db->prepare('DELETE id, name FROM produce WHERE produce.name = :name');
        $parameters = [
            'name' => $name
        ];
        $query->execute($parameters);
        $result = $query->fetchAll(PDO::FETCH_ASSOC);
        
    }
    
}

?>