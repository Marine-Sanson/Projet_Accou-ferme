<?php

class Variety
{
    private ?int $id;
    private int $produceId;
    private string $name;
    private bool $availablity;
    private string $seasonStart;
    private string $seasonEnd;
    private string $description;
    private int $imgId;

    function __construct(?int $id, int $produceId, string $name, bool $availablity, string $seasonStart, string $seasonEnd, string $description, int $imgId)
    {
        $this->id = $id;
        $this->produceId = $produceId;
        $this->name = $name;
        $this->availablity = $availablity;
        $this->seasonStart = $seasonStart;
        $this->seasonEnd = $seasonEnd;
        $this->description = $description;
        $this->imgId = $imgId;
    }
    
    public function getId() : ?int
    {
        return $this->id;
    }
    
    public function setId(int $id) : void
    {
        $this->id = $id;
    }
    
    public function getProduceId() : ?int
    {
        return $this->produceId;
    }
    
    public function setProduceId(int $produceId) : void
    {
        $this->produceId = $produceId;
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
    
}