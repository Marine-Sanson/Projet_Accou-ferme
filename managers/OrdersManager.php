<?php

class OrdersManager extends AbstractManager
{
    
    /**
     * reçoit un Order, le crée dans la base de donées et renvoie son id
     * @param Order
     * @return id
     */

    public function createOrder(Order $order) : int
    {
        $query = $this->db->prepare('INSERT INTO orders (name, first_name, email, tel, date_commande, day, total_price ) VALUES (:name, :first_name, :email, :tel, :date_commande, :day, :total_price)');
        $parameters = [
            'name' => $order->getName(),
            'first_name' => $order->getFirstName(),
            'email' => $order->getEmail(),
            'tel' => $order->getTel(),
            'date_commande' => $order->getDateCommande()->format('Y-m-d H:i:s'),
            'day' => $order->getDay(),
            'total_price' => $order->getTotalPrice()
        ];
        $query->execute($parameters);
        
        $id = $this->db->lastInsertId();
            
        return $id;
    }
    
    /**
     * reçoit un Order et le crée dans la base de donées
     * @param Order
     * @return 
     */
    
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
    
    /**
     * va chercher tous les Order d'après le jour de retrait et le statut de commande
     * @param $day, $endOrder
     * @return un array avec les Orders concernés
     */

    public function getAllOrders(string $day, bool $endOrder) :array
    {
        $query = $this->db->prepare('SELECT id, name, first_name, email, tel, date_commande, day, total_price, end_order FROM orders WHERE day = :day AND end_order = :end_order ORDER BY orders.date_commande DESC');
        $parameters = [
            'day' => $day,
            'end_order' => $endOrder
        ];
        $query->execute($parameters);
        $allOrders = $query->fetchAll(PDO::FETCH_ASSOC);

        return $allOrders;
    }
    
    /**
     * va chercher toutes les variétés commandées d'une commande d'après son id
     * @param $idOrder
     * @return un array avec les variétés concernées
     */

    public function getVarietiesOrderedByOrderId(int $idOrder) :array
    {
        $query = $this->db->prepare('SELECT variety_id, variety_name, amount, units, price, total_variety FROM varietyOrdered WHERE id_order = :id_order');
        $parameters = [
            'id_order' => $idOrder
        ];
        $query->execute($parameters);
        $varietiesOrdered = $query->fetchAll(PDO::FETCH_ASSOC);

        return $varietiesOrdered;
    }
    
    /**
     * met à jour le statut d'une commande d'après son id
     * @param $id
     * @return void
     */
    
    public function updateEndOrder($id) :void
    {
        $query = $this->db->prepare('UPDATE orders SET end_order = :end_order WHERE id = :id');
        $parameters = [
            'id' => $id,
            'end_order' => '1'
        ];
        $query->execute($parameters);
    }

    // public function getAllOrders(string $day) :array
    // {
    //     $query = $this->db->prepare('SELECT orders.id, orders.name, orders.first_name, orders.email, orders.tel, orders.date_commande, orders.day, orders.total_price, varietyOrdered.variety_id, varietyOrdered.variety_name, varietyOrdered.amount, varietyOrdered.units, varietyOrdered.price, varietyOrdered.total_variety FROM orders JOIN varietyOrdered ON varietyOrdered.id_order = orders.id WHERE orders.day = :day ORDER BY orders.date_commande DESC');
    //     $parameters = [
    //         'day' => $day
    //     ];
    //     $query->execute($parameters);
    //     $allOrders = $query->fetchAll(PDO::FETCH_ASSOC);

    //     return $allOrders;
    // }

    

}