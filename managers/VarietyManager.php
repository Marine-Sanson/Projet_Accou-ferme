<?php

class VarietyManager
{
    
    public function createVariety(Variety $variety) : Variety
    {
        $query = $this->db->prepare('INSERT INTO varieties ( produce_id, name, season_start ,season_end , description, availablity, quantity_available ) VALUES ( :produce_id, :name, :availablity, :season_start, :season_end, :description, :quantity_available )');
        $parameters = [
            'produce_id' => $produce_id ,
            'name' => $name->getName(),
            'season_start' => $seasonStart->getSeasonStart(),
            '$season_End' => $seasonEnd->getSeasonEnd(),
            'description' => $description->getDescription(),
            'availablity' => "0",
            'quantity_available' => $quantityAvailable->getQuantityAvailable()
        ];
        $query->execute($parameters);
        
        $variety = [];

        return $variety;
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
    
    public function getVarietyById(Variety $id) : Variety
    {
        $query = $this->db->prepare('SELECT produce_id, name, season_start, season_end, description, media_id, availablity, quantity_available FROM varieties WHERE variety.id = :id');
        $parameters = [
            'id' => $id
        ];
        $query->execute($parameters);
        $result = $query->fetch(PDO::FETCH_ASSOC);
        
        $variety = [];

        return $variety;
    }
    
    public function updateVariety(Variety $variety) : Variety
    {
        
        $query = $this->db->prepare('UPDATE variety SET produce_id = :produce_id, season_start = :season_start, season_end = :season_end, description = :description, availablity = :availablity, quantity_available = :quantity_available FROM varieties WHERE variety.name = :name');
        $parameters = [
            'produce_id' => $produceId,
            'season_start' => $seasonStart,
            'season_end' => $seasonEnd,
            'description' => $description,
            'availablity' => $availablity,
            'quantity_available' => $quantityAvailable
        ];
        $query->execute($parameters);
        $result = $query->fetchAll(PDO::FETCH_ASSOC);
        
        $variety = [];

        return $variety;
        
    }
    
    public function deleteVariety(Variety $variety) : void
    {
        
        $query = $this->db->prepare('DELETE id, produce_id, name, season_start, season_end, description, media_id, availablity, quantity_available FROM varieties WHERE varietv.name = :name');
        $parameters = [
            'name' => $name
        ];
        $query->execute($parameters);
        $result = $query->fetchAll(PDO::FETCH_ASSOC);
        
    }
    
}

?>