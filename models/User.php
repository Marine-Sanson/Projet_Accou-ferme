<?php

class User
{
    private ?int $id;
    private string $name;
    private string $email;
    private string $password;
    private int $tel;
    private string $role;

    function __construct(?int $id, string $name, string $email, string $password, int $tel, string $role)
    {
        $this->id = $id;
        $this->name = $name;
        $this->email = $email;
        $this->password = $password;
        $this->tel = $tel;
        $this->role = $role;
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
        $this->id = $name;
    }
    
    public function getEmail() : string
    {
        return $this->email;
    }
    
    public function setEmail(string $email) : void
    {
        $this->email = $email;
    }
    
    public function getPassword() : string
    {
        return $this->password;
    }
    
    public function setPassword(string $password) : void
    {
        $this->password = $password;
    }
    
    public function getTel() : int
    {
        return $this->tel;
    }
    
    public function setTel(int $tel) : void
    {
        $this->tel = $tel;
    }
    
    public function getRole() : ?string
    {
        return $this->role;
    }
    
    public function setRole(string $role) : void
    {
        $this->role = $role;
    }
    
}