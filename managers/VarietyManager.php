<?php

class VarietyManager extends DBConnect
{
    
    public function createVariety(Variety $variety) : Variety
    {
        $query = $this->db->prepare('INSERT INTO varieties ( product_id, name, season_start ,season_end , description, availablity, quantity_available ) VALUES ( :product_id, :name, :availablity, :season_start, :season_end, :description, :quantity_available, :units, ;price');
        $parameters = [
            'product_id' => $product_id ,
            'name' => $name->getName(),
            'season_start' => $seasonStart->getSeasonStart(),
            '$season_End' => $seasonEnd->getSeasonEnd(),
            'description' => $description->getDescription(),
            'availablity' => "0",
            'quantity_available' => $quantityAvailable->getQuantityAvailable(),
            'units' => $units->getUnits(),
            'price' => $price->getPrice()
        ];
        $query->execute($parameters);
        
        $varieties = [];

        return $varieties;
    }
    
    public function getVarietyId(string $name) : int
    {
        $query = $this->db->prepare('SELECT id FROM varieties WHERE variety.name = :name');
        $parameters = [
            'name' => $name
        ];
        $query->execute($parameters);
        $result = $query->fetchAll(PDO::FETCH_ASSOC);
        
        $variety = [];

        return $variety['id'];
        
    }
    
    public function getVarietyByProduct($productName) :array
    {
        $query = $this->db->prepare("SELECT varieties.id, varieties.name, varieties.season_start, varieties.season_end, varieties.description, varieties.media_id, varieties.availablity, varieties.quantity_available, varieties.units, varieties.price FROM varieties JOIN products ON products.id = varieties.product_id WHERE products.name = :name") or die($this->db->errorInfo());
        $parameters = [
            'name' => $productName
        ];
        $query->execute($parameters) or die($this->db->errorInfo());
        $varieties = $query->fetchAll(PDO::FETCH_ASSOC);
        return $varieties;
        
    }
    
    
    public function getVarietyById(Variety $id) : Variety
    {
        $query = $this->db->prepare('SELECT product_id, name, season_start, season_end, description, media_id, availablity, quantity_available, units, price FROM varieties WHERE variety.id = :id');
        $parameters = [
            'id' => $id
        ];
        $query->execute($parameters);
        $result = $query->fetch(PDO::FETCH_ASSOC);
        
        $variety = [];

        return $variety;
    }
    
    public function getAllAvailableVarieties() :array{
        $query = $this->db->prepare('SELECT products.name AS product_name, varieties.id, varieties.name, varieties.media_id, varieties.quantity_available, varieties.units, varieties.price FROM varieties JOIN products ON varieties.product_id = products.id WHERE varieties.quantity_available > 0 ');
        $query->execute();
        $allAvailableVarieties = $query->fetchAll(PDO::FETCH_ASSOC);
        
        return $allAvailableVarieties;
    }
    
    public function getAvailableVariety() :array{
        $query = $this->db->prepare('SELECT product_id, name, quantity_available, units, price FROM varieties WHERE varieties.quantity_available > 0');
        $query->execute();
        $availableVariety = $query->fetchAll(PDO::FETCH_ASSOC);
        
        return $availableVariety;
    }
    
    public function updateVariety(Variety $variety) : Variety
    {
        
        $query = $this->db->prepare('UPDATE variety SET product_id = :product_id, season_start = :season_start, season_end = :season_end, description = :description, availablity = :availablity, quantity_available, = :quantity_available, units = :units, price = :price FROM varieties WHERE variety.name = :name');
        $parameters = [
            'product_id' => $productId,
            'season_start' => $seasonStart,
            'season_end' => $seasonEnd,
            'description' => $description,
            'availablity' => $availablity,
            'quantity_available' => $quantityAvailable,
            'units' => $units,
            'price' => $price
        ];
        $query->execute($parameters);
        $result = $query->fetchAll(PDO::FETCH_ASSOC);
        
        $variety = [];

        return $variety;
        
    }
    
    public function deleteVariety(Variety $variety) : void
    {
        
        $query = $this->db->prepare('DELETE id, product_id, name, season_start, season_end, description, media_id, availablity, quantity_available, units, price FROM varieties WHERE varietv.name = :name');
        $parameters = [
            'name' => $name
        ];
        $query->execute($parameters);
        $result = $query->fetchAll(PDO::FETCH_ASSOC);
        
    }
    
}

?>