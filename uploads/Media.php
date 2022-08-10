<?php

/**
 * Media class used for media upload
 * @author Mari Doucet
 * @author Marine Sanson
*/

class Media
{
    private ?int $id;
    private string $originalName;
    private string $fileName;
    private string $fileType;
    private string $url;
    private string $alt;

    
    function __construct(int $id, string $originalName, string $fileName, string $fileType, string $url, string $alt)
    {
        $this->id = $id;
        $this->originalName = $originalName;
        $this->fileName = $fileName;
        $this->fileType = $fileType;
        $this->url = $url;
        $this->alt = $alt;
    }
    
    public function getId() : ?int
    {
        return $this->id;
    }
    
    public function setId(int $id) : void
    {
        $this->id = $id;
    }
    
    public function getOriginalName() : string
    {
        return $this->originalName;
    }
    
    public function getFileName() : string
    {
        return $this->fileName;
    }
    
    public function setFileName(string $fileName) : self
    {
        $this->fileName = $fileName;
        return $this;
    }
    
    public function getFileType() : string
    {
        return $this->fileType;
    }
    
    public function setFileType(string $fileType) : self
    {
        $this->fileType = $fileType;
        return $this;
    }
    
    public function getUrl() : string
    {
        return $this->url;
    }
    
    public function setUrl(string $url) : self
    {
        $this->url = $url;
        return $this;
    }
    
    public function getAlt() : string
    {
        return $this->alt;
    }
    
    public function setAlt(string $alt) : self
    {
        $this->alt = $alt;
        return $this;
    }
    
    
   
}