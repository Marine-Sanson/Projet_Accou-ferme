<?php

class OrderManager extends DBConnect
{
    
    public function createOrder(Order $order) : int
    {
        $query = $this->db->prepare('INSERT INTO orders (name, first_name, email, tel, date_commande, day, total_price) VALUES (:name, :first_name, :email, :tel, :date_commande, :day, :total_price)');
        $parameters = [
            'name' => $order->getName(),
            'first_name' => $order->getFirstName(),
            'email' => $order->getEmail(),
            'tel' => $order->getTel(),
            'date_commande' => $order->getDateCommande(),
            'day' => $order->getDay(),
            'total_price' => $order->getTotalPrice()
        ];
        $query->execute($parameters);
        
        $id = $this->db->lastInsertId();
            
        return $id;
        
    }
    
    public function createVarietyOrdered(int $idOrder, int $varietyId, string $varietyName, int $amount, string $units, int $price, int $totalVariety) :void
    {
        $query = $this->db->prepare('INSERT INTO varietyOrdered (id_order, variety_id, variety_name, amount, units, price, total_variety) VALUES (:id_order, :variety_id, :variety_name, :amount, :units, :price, :total_variety)');
        $parameters = [
            'id_order' => $idOrder,
            'variety_id' => $varietyId,
            'variety_name' => $varietyName,
            'amount' => $amount,
            'units' => $units,
            'price' => $price,
            'total_variety' => $totalVariety
        ];
        $query->execute($parameters);
        
    }
    
    public function getOrderById(int $id) : Order
    {
        $query = $this->db->prepare('SELECT name, firstName, email, tel, date_commande, day, totalPrice FROM orders WHERE id = :id');
        $parameters = [
            'id' => $id
        ];
        $query->execute($parameters);
        $result = $query->fetch(PDO::FETCH_ASSOC);
        
        $order = [];

        return $order;
    }

    
    public function getOrderByDateRetrait(Order $dateRetrait) : Basket
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
    
    public function getOrderByUserId(Basket $userId) : Order
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