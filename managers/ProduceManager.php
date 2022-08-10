<?php

class ProduceManager
{
    
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