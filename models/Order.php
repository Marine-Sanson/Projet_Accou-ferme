<?php

class Order
{
    private ?int $id;
    private string $name;
    private string $firstName;
    private string $email;
    private int $tel;
    private DateTime $dateCommande;
    private string $day;
    private float $totalPrice;
    private bool $endOrder;

    function __construct (?int $id, string $name, string $firstName, string $email, int $tel, DateTime $dateCommande, string $day, float $totalPrice, bool $endOrder)
    {
        $this->id = $id;
        $this->name = $name;
        $this->firstName = $firstName;
        $this->email = $email;
        $this->tel = $tel;
        $this->dateCommande = $dateCommande;
        $this->day = $day;
        $this->totalPrice = $totalPrice;
        $this->endOrder = $endOrder;
    }
    
    public function getId() : ?int
    {
        return $this->id;
    }
    
    public function setId(int $id) : void
    {
        $this->id = $id;
    }
    
    public function getName() : string
    {
        return $this->name;
    }
    
    public function setName(string $name) : void
    {
        $this->name = $name;
    }
    
    public function getFirstName() : string
    {
        return $this->firstName;
    }
    
    public function setFirstName(string $firstName) : void
    {
        $this->firstName = $firstName;
    }
    
    public function getEmail() : string
    {
        return $this->email;
    }
    
    public function setEmail(string $email) : void
    {
        $this->email = $email;
    }
    
    public function getTel() : int
    {
        return $this->tel;
    }
    
    public function setTel(int $tel) : void
    {
        $this->tel = $tel;
    }

    public function getDateCommande() : DateTime
    {
        return $this->dateCommande;
    }
    
    public function setDateCommande(DateTime $dateCommande) : void
    {
        $this->dateCommande = $dateCommande;
    }
    
    public function getDay() : string
    {
        return $this->day;
    }
    
    public function setDay(string $day) : void
    {
        $this->day = $day;
    }
    
    public function getTotalPrice() : int
    {
        return $this->totalPrice;
    }
    
    public function setTotalPrice(float $totalPrice) : void
    {
        $this->totalPrice = $totalPrice;
    }
    
    public function getEndOrder() : bool
    {
        return $this->endOrder;
    }
    
    public function setEndOrder(bool $endOrder) : void
    {
        $this->endOrder = $endOrder;
    }

}


?>