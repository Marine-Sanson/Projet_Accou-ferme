<?php

class Order
{
    private ?int $id;
    private string $name;
    private string $firstName;
    private string $email;
    private int $tel;
    private string $dateCommande;
    private string $day;
    private int $totalPrice;

    function __construct (?int $id, string $name, string $firstName, string $email, int $tel, string $dateCommande, string $day, int $totalPrice)
    {
        $this->id = $id;
        $this->name = $name;
        $this->firstName = $firstName;
        $this->email = $email;
        $this->tel = $tel;
        $this->dateCommande = $dateCommande;
        $this->day = $day;
        $this->totalPrice = $totalPrice;
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

    public function getDateCommande() : string
    {
        return $this->dateCommande;
    }
    
    public function setDateCommande(string $dateCommande) : void
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
    
    public function setTotalPrice(int $totalPrice) : void
    {
        $this->totalPrice = $totalPrice;
    }
    
}


?>