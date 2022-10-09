<?php

class VarietyManager extends AbstractManager
{
    
    /**
     * reçoit une Variety l'insère dans la base de données
     * @param une Variety
     * @return void
     */

    public function createVariety(Variety $variety) : void
    {
        if($variety->getAvailablity())
        {
            $availablity = 1;
        }
        else
        {
            $availablity = 0;
        }

        if($variety->getOffer())
        {
            $offer = 1;
        }
        else{
            $offer = 0;
        }

        if($variety->getMediaId() === 0)
        {
            $mediaId = null;
        }
        else{
            $mediaId = $variety->getMediaId();
        }

        $query = $this->db->prepare('INSERT INTO varieties (product_id, name, season_start, season_end, description, media_id, availablity, offer, quantity_available, units, price) VALUES (:product_id, :name, :season_start, :season_end, :description, :media_id, :availablity, :offer, :quantity_available, :units, :price)');
        $parameters = [
            'product_id' => $variety->getProductId(),
            'name' => $variety->getName(),
            'season_start' => $variety->getSeasonStart(),
            'season_end' => $variety->getSeasonEnd(),
            'description' => $variety->getDescription(),
            'media_id' => $mediaId,
            'availablity' => $availablity,
            'offer' => $offer,
            'quantity_available' => $variety->getQuantityAvailable(),
            'units' => $variety->getUnits(),
            'price' => $variety->getPrice()
        ];
        $query->execute($parameters);
    }
    
    /**
     * va chercher un id de Variety d'après son nom
     * @param $varietyName
     * @return void
     */

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
    
    /**
     * va chercher toutes les variétés qui dépendent d'un produit d'après le nom de ce produit
     * @param $productName
     * @return un array avec les variétés
     */
    
    public function getVarietyByProduct($productName) :array
    {
        $query = $this->db->prepare("SELECT varieties.id, varieties.name, varieties.season_start, varieties.season_end, varieties.description, varieties.media_id, varieties.availablity, varieties.quantity_available, varieties.offer, varieties.units, varieties.price FROM varieties JOIN products ON products.id = varieties.product_id WHERE products.name = :name") or die($this->db->errorInfo());
        $parameters = [
            'name' => $productName
        ];
        $query->execute($parameters) or die($this->db->errorInfo());
        $varieties = $query->fetchAll(PDO::FETCH_ASSOC);
        return $varieties;
        
    }
    
    /**
     * va chercher toutes les variétés et le nom du produit dont elles dépendent
     * @param 
     * @return un array avec toutes les variétés et le nom du produit
     */
    
    public function getAllVarieties() :array
    {
        $query = $this->db->prepare("SELECT varieties.id, varieties.product_id, varieties.name, varieties.season_start, varieties.season_end, varieties.description, varieties.media_id, varieties.availablity, varieties.offer, varieties.quantity_available, varieties.units, varieties.price, products.name AS product_name FROM varieties JOIN products ON products.id = varieties.product_id ");
        // or die($this->db->errorInfo());
        $query->execute();
        // or die($this->db->errorInfo());
        $varieties = $query->fetchAll(PDO::FETCH_ASSOC);
        
        return $varieties;
    }
    
    /**
     * va chercher une variété d'après son id
     * @param $id
     * @return une Variety
     */
    
    public function getVarietyById(int $id) : Variety
    {
        $query = $this->db->prepare('SELECT product_id, name, season_start, season_end, description, media_id, availablity, offer, quantity_available, units, price FROM varieties WHERE varieties.id = :id');
        $parameters = [
            'id' => $id
        ];
        $query->execute($parameters);
        $result = $query->fetch(PDO::FETCH_ASSOC);
        
        $varietyId = $id;
        $varietyProductId = $result["product_id"];
        $varietyName = $result["name"];
        $varietySeasonStart = $result["season_start"];
        $varietySeasonEnd = $result["season_end"];
        $varietyDescription = $result["description"];
        $varietyMediaId = $result["media_id"];
        $varietyAvailablity = $result["availablity"];
        $varietyOffer = $result["offer"];
        $varietyQuantityAvailable = $result["quantity_available"];
        $varietyUnits = $result["units"];
        $varietyPrice = $result["price"];
        
        $variety = new Variety($varietyId, $varietyProductId, $varietyName, $varietySeasonStart, $varietySeasonEnd, $varietyDescription, $varietyMediaId, $varietyAvailablity, $varietyOffer, $varietyQuantityAvailable, $varietyUnits, $varietyPrice);
        
        return $variety;
    }
    
    /**
     * va chercher toutes les Variety disponibles et le nom du produit dont elles dépendent
     * @param 
     * @return un array avec les varietés concernées
     */
    
    public function getAllAvailableVarieties() :array{
        $query = $this->db->prepare('SELECT products.name AS product_name, varieties.id, varieties.name, varieties.media_id, varieties.quantity_available, varieties.offer, varieties.units, varieties.price FROM varieties JOIN products ON varieties.product_id = products.id WHERE varieties.quantity_available > 0 ');
        $query->execute();
        $allAvailableVarieties = $query->fetchAll(PDO::FETCH_ASSOC);
        
        return $allAvailableVarieties;
    }
    
    /**
     * va chercher toutes les Variety disponibles
     * @param 
     * @return un array avec les varietés concernées
     */
    
    public function getAvailableVariety() :array
    {
        $query = $this->db->prepare('SELECT product_id, name, quantity_available, units, price FROM varieties WHERE varieties.quantity_available > 0');
        $query->execute();
        $availableVariety = $query->fetchAll(PDO::FETCH_ASSOC);
        
        return $availableVariety;
    }
    
    /**
     * va chercher 3 Variety pour la section produits du moment
     * @param 
     * @return un array avec les varietés concernées
     */
    
    public function getOfferVarieties() :array
    {
        $query = $this->db->prepare('SELECT product_id, name, description, media_id, quantity_available, units, price FROM varieties WHERE varieties.offer = 1 LIMIT 3');
        $query->execute();
        $offerVariety = $query->fetchAll(PDO::FETCH_ASSOC);
        
        return $offerVariety;
    }
    
    /**
     * met à jour une Variety
     * @param Variety
     * @return
     */
    
    public function updateVariety(Variety $variety) : void
    {
        if($variety->getAvailablity())
        {
            $availablity = 1;
        }
        else
        {
            $availablity = 0;
        }

        if($variety->getOffer())
        {
            $offer = 1;
        }
        else{
            $offer = 0;
        }

        if($variety->getMediaId() === 0)
        {
            $mediaId = null;
        }
        else{
            $mediaId = $variety->getMediaId();
        }

        $query = $this->db->prepare('UPDATE varieties SET name = :name, product_id = :product_id, season_start = :season_start, season_end = :season_end, description = :description, media_id = :media_id, availablity = :availablity, offer = :offer, quantity_available = :quantity_available, units = :units, price = :price WHERE id = :id');
        $parameters = [
            'id' => $variety->getId(),
            'name' => $variety->getName(),
            'product_id' => $variety->getProductId(),
            'season_start' => $variety->getSeasonStart(),
            'season_end' => $variety->getSeasonEnd(),
            'description' => $variety->getDescription(),
            'media_id' => $mediaId,
            'availablity' => $availablity,
            'offer' => $offer,
            'quantity_available' => $variety->getQuantityAvailable(),
            'units' => $variety->getUnits(),
            'price' => $variety->getPrice()
        ];
        $query->execute($parameters);
    }
    
    /**
     * reçoit un id de Media et le met à jour sur la variété concernée
     * @param $mediaId, $varietyId
     * @return
     */
    
    public function updateVarietyMedia(int $mediaId, int $varietyId) : void
    {
        $query = $this->db->prepare('UPDATE varieties SET media_id = :media_id WHERE id = :id');
        $parameters = [
            'id' => $varietyId,
            'media_id' => $mediaId
        ];
        $query->execute($parameters);
    }
    
    /**
     * reçoit un id de variété une quantité et met à jour la quantité disponible
     * @param $varietyId
     * @return void
     */
    
    public function updateVarietyQuantityAvailable(int $varietyId, int $quantityAvailable) : void
    {
        $query = $this->db->prepare('UPDATE varieties SET quantity_available = :quantity_available WHERE id = :id');
        $parameters = [
            'id' => $varietyId,
            'quantity_available' => $quantityAvailable
        ];
        $query->execute($parameters);
    }
    
    /**
     * supprime une Variety
     * @param Variety
     * @return
     */
    
    public function deleteVariety(Variety $variety) : void
    {
        $query = $this->db->prepare('DELETE FROM varieties WHERE varieties.id = :id');
        $parameters = [
            'id' => $variety->getId()
        ];
        $query->execute($parameters);
    }
}

?>