<?php

class VarietyManager
{
    
    public function createVariety(Variety $variety) : Variety
    {
        $query = $this->db->prepare('INSERT INTO varieties ( produce_id, name, availablity, season_start ,season_end , description  ) VALUES ( :produce_id, :name, :availablity, :season_start, :season_end, :description )');
        $parameters = [
            'produce_id' => $produce_id ,
            'name' => $name->getName(),
            'availablity' => "0",
            'season_start' => $seasonStart->getSeasonStart(),
            '$season_End' => $seasonEnd->getSeasonEnd(),
            'description' => $description->getDescription(),
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
        $query = $this->db->prepare('SELECT produce_id, name, availablity, season_start, season_end, description, media_id FROM varieties WHERE variety.id = :id');
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
        
        $query = $this->db->prepare('UPDATE variety SET produce_id = :produce_id, availablity = :availablity, season_start = :season_start, season_end = :season_end, description = :description FROM varieties WHERE variety.name = :name');
        $parameters = [
            'produce_id' => $produceId,
            'availablity' => $availablity,
            'season_start' => $seasonStart,
            'season_end' => $seasonEnd,
            'description' => $description
        ];
        $query->execute($parameters);
        $result = $query->fetchAll(PDO::FETCH_ASSOC);
        
        $variety = [];

        return $variety;
        
    }
    
    public function deleteVariety(Variety $variety) : void
    {
        
        $query = $this->db->prepare('DELETE id, produce_id, name, availablity, season_start, season_end, description, media_id FROM varieties WHERE varietv.name = :name');
        $parameters = [
            'name' => $name
        ];
        $query->execute($parameters);
        $result = $query->fetchAll(PDO::FETCH_ASSOC);
        
    }
    
}

?>