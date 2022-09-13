<?php

class VarietyManager extends AbstractManager
{
    
    public function createVariety(Variety $variety) : Variety
    {
        $query = $this->db->prepare('INSERT INTO varieties ( product_id, name, season_start ,season_end , description, availablity, quantity_available ) VALUES ( :product_id, :name, :availablity, :season_start, :season_end, :description, :quantity_available, :units, ;price');
        $parameters = [
            'product_id' => $product_id ,
            'name' => $variety->getName(),
            'season_start' => $variety->getSeasonStart(),
            '$season_End' => $variety->getSeasonEnd(),
            'description' => $variety->getDescription(),
            'availablity' => "0",
            'quantity_available' => $variety->getQuantityAvailable(),
            'units' => $variety->getUnits(),
            'price' => $variety->getPrice()
        ];
        $query->execute($parameters);
        
        return $varieties;
    }
    
    public function getVarietyId(string $varietyName) : array
    {
        $query = $this->db->prepare('SELECT id FROM varieties WHERE varieties.name = :name');
        $parameters = [
            'name' => $varietyName
        ];
        $query->execute($parameters);
        $varietyId = $query->fetch(PDO::FETCH_ASSOC);
        
        return $varietyId;
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
        $query = $this->db->prepare('SELECT product_id, name, season_start, season_end, description, media_id, availablity, quantity_available, units, price FROM varieties WHERE varieties.id = :id');
        $parameters = [
            'id' => $id
        ];
        $query->execute($parameters);
        $variety = $query->fetch(PDO::FETCH_ASSOC);
        
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
        
        $query = $this->db->prepare('UPDATE varieties SET product_id = :product_id, season_start = :season_start, season_end = :season_end, description = :description, availablity = :availablity, quantity_available, = :quantity_available, units = :units, price = :price FROM varieties WHERE varieties.name = :name');
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
        $variety = $query->fetchAll(PDO::FETCH_ASSOC);
        
        return $variety;
        
    }
    
    public function deleteVariety(Variety $variety) : void
    {
        
        $query = $this->db->prepare('DELETE id, product_id, name, season_start, season_end, description, media_id, availablity, quantity_available, units, price FROM varieties WHERE varieties.name = :name');
        $parameters = [
            'name' => $name
        ];
        $query->execute($parameters);
        $result = $query->fetchAll(PDO::FETCH_ASSOC);
        
    }
    
}

?>