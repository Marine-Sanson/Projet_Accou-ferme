<?php

class News
{
    private ?int $id;
    private ?int $categoryId;
    private string $name;
    private int $imgId;
    private string $content;
    
    function __construct (?int $id, int $categoryId, string $name, int $imgId, string $content)
    {
        $this->id = $id;
        $this->categoryId = $categoryId;
        $this->name = $name;
        $this->imgId = $imgId;
        $this->content = $content;
    }
    
    public function getId() : ?int
    {
        return $this->id;
    }
    
    public function setId(int $id) : void
    {
        $this->id = $id;
    }
    
    public function getCategoryId() : ?int
    {
        return $this->categoryId;
    }
    
    public function setCategoryId(int $categoryId) : void
    {
        $this->categoryId = $categoryId;
    }
    
    public function getName() : string
    {
        return $this->name;
    }
    
    public function setName(string $name) : void
    {
        $this->id = $name;
    }
    
    public function getImgId() : int
    {
        return $this->imgId;
    }
    
    public function setImgId(string $imgId) : void
    {
        $this->imgId = $imgId;
    }
    
    public function getContent() : string
    {
        return $this->content;
    }
    
    public function setContent(string $content) : void
    {
        $this->content = $content;
    }
    
}


?>