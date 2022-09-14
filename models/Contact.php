<?php

class Contact
{
    private ?int $id;
    private string $name;
    private string $firstName;
    private string $email;
    private int $tel;
    private string $message;

    function __construct (?int $id, string $name, string $firstName, string $email, int $tel, string $message)
    {
        $this->id = $id;
        $this->name = $name;
        $this->firstName = $firstName;
        $this->email = $email;
        $this->tel = $tel;
        $this->message = $message;
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

    public function getMessage() : string
    {
        return $this->message;
    }
    
    public function setMessage(string $message) : void
    {
        $this->message = $message;
    }
    
}


?>