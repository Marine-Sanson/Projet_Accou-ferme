<?php

class BasketManager
{
    
    public function createBasket(Basket $news) : Basket
    {
        $query = $this->db->prepare('INSERT INTO baskets ( user_id, date_commande, date_retrait, variety_id, quantity ) VALUES ( :user_id, :date_commande, :date_retrait, :variety_id, :quantity )');
        $parameters = [
            'user_id' => $userId->getUserId() ,
            'date_commande' => $dateCommande->getdateCommande(),
            'date_retrait' => $dateRetrait->getDateRetrait,
            'variety_id' => $varietyId->getVarietyId,
            'quantity' => $quantity->getQuantity
        ];
        $query->execute($parameters);
        
        $basket = [];

        return $basket;
    }
    
    public function getBasketByDateRetrait(Basket $dateRetrait) : Basket
    {
        $query = $this->db->prepare('SELECT user_id, date_commande, variety_id, quantity FROM baskets WHERE basket.date_retrait = :date_retrait');
        $parameters = [
            'date_retrait' => $dateRetrait
        ];
        $query->execute($parameters);
        $result = $query->fetch(PDO::FETCH_ASSOC);
        
        $basket = [];

        return $basket;
    }
    
    public function getBasketByUserId(Basket $userId) : Basket
    {
        $query = $this->db->prepare('SELECT date_commande, date_retrait, variety_id, quantity FROM baskets WHERE basket.user_id = :user_id');
        $parameters = [
            'user_id' => $userId
        ];
        $query->execute($parameters);
        $result = $query->fetch(PDO::FETCH_ASSOC);
        
        $basket = [];

        return $basket;
    }
    
}