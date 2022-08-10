<?php

class Basket
{
    private ?int $id;
    private ?int $userId;
    private DateTime $dateCommande;
    private DateTime $dateRetrait;
    private ?int $varietyId;
    private int $quantity;
    
    function __construct (int $id, int $userId, DateTime $dateCommande, DateTime $dateRetrait, int $varietyId, int $quantity)
    {
        $this->id = $id;
        $this->userId = $userId;
        $this->dateCommande = $dateCommande;
        $this->dateRetrait = $dateRetrait;
        $this->varietyId = $varietyId;
        $this->quantity = $quantity;
    }
    
    public function getId() : ?int
    {
        return $this->id;
    }
    
    public function setId(int $id) : void
    {
        $this->id = $id;
    }
    
    public function getUserId() : ?int
    {
        return $this->userId;
    }
    
    public function setUserId(int $userId) : void
    {
        $this->userId = $userId;
    }
    
    public function getDateCommande() : DateTime
    {
        return $this->dateCommande;
    }
    
    public function setDateCommande(string $dateCommande) : void
    {
        $this->dateCommande = $dateCommande;
    }
    
    public function getDateRetrait() : DateTime
    {
        return $this->dateRetrait;
    }
    
    public function setDateRetrait(string $dateRetrait) : void
    {
        $this->dateRetrait = $dateRetrait;
    }
    
    public function getVarietyId() : int
    {
        return $this->varietyId;
    }
    
    public function setVarietyId(string $varietyId) : void
    {
        $this->varietyId = $varietyId;
    }
    
    public function getQuantity() : int
    {
        return $this->quantity;
    }
    
    public function setQuantity(string $quantity) : void
    {
        $this->quantity = $quantity;
    }
    
}


?>