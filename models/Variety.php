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
    private int $mediaId;

    function __construct(?int $id, int $produceId, string $name, bool $availablity, string $seasonStart, string $seasonEnd, string $description, int $mediaId)
    {
        $this->id = $id;
        $this->produceId = $produceId;
        $this->name = $name;
        $this->availablity = $availablity;
        $this->seasonStart = $seasonStart;
        $this->seasonEnd = $seasonEnd;
        $this->description = $description;
        $this->mediaId = $mediaId;
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
    
}