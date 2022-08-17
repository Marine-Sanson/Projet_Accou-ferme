<?php

class Variety
{
    private ?int $id;
    private int $productId;
    private string $name;
    private string $seasonStart;
    private string $seasonEnd;
    private string $description;
    private int $mediaId;
    private bool $availablity;
    private ?int $quantity_available;

    function __construct(?int $id, int $productId, string $name, string $seasonStart, string $seasonEnd, string $description, int $mediaId, bool $availablity, int $quantityAvailable)
    {
        $this->id = $id;
        $this->productId = $productId;
        $this->name = $name;
        $this->seasonStart = $seasonStart;
        $this->seasonEnd = $seasonEnd;
        $this->description = $description;
        $this->mediaId = $mediaId;
        $this->availablity = $availablity;
        $this->quantityAvailable = $quantityAvailable;
    }
    
    public function getId() : ?int
    {
        return $this->id;
    }
    
    public function setId(int $id) : void
    {
        $this->id = $id;
    }
    
    public function getProductId() : ?int
    {
        return $this->productId;
    }
    
    public function setProductId(int $productId) : void
    {
        $this->productId = $productId;
    }
    
    public function getName() : string
    {
        return $this->name;
    }
    
    public function setName(string $name) : void
    {
        $this->id = $name;
    }
    
    public function getAvailablity() : bool
    {
        return $this->availablity;
    }
    
    public function setAvailablity(string $availablity) : void
    {
        $this->availablity = $availablity;
    }
    
    public function getSeasonStart() : string
    {
        return $this->seasonStart;
    }
    
    public function setSeasonStart(string $seasonStart) : void
    {
        $this->seasonStart = $seasonStart;
    }
    
    public function getSeasonEnd() : string
    {
        return $this->seasonEnd;
    }
    
    public function setSeasonEnd(string $seasonEnd) : void
    {
        $this->seasonEnd = $seasonEnd;
    }
    
    public function getDescription() : string
    {
        return $this->description;
    }
    
    public function setDescription(string $description) : void
    {
        $this->description = $description;
    }
    
    public function getMediaId() : int
    {
        return $this->mediaId;
    }
    
    public function setMediaId(int $mediaId) : void
    {
        $this->mediaId = $mediaId;
    }
    
    public function getQuantityAvailable() : int
    {
        return $this->quantityAvailable;
    }
    
    public function setQuantityAvailable(int $quantityAvailable) : void
    {
        $this->quantityAvailable = $quantityAvailable;
    }
    
}