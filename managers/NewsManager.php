<?php

class NewsManager
{
    
    public function createNews(Recipe $news) : News
    {
        $query = $this->db->prepare('INSERT INTO news ( category_id, name, content ) VALUES ( :category_id, :name, :content )');
        $parameters = [
            'category_id' => $categoryId->getCategoryId() ,
            'name' => $name->getName(),
            'content' => $content->getContent
        ];
        $query->execute($parameters);
        
        $news = [];

        return $news;
    }
    
    public function getNewsId(string $name) : int
    {
        
        $query = $this->db->prepare('SELECT id FROM news WHERE news.name = :name');
        $parameters = [
            'name' => $name
        ];
        $query->execute($parameters);
        $result = $query->fetchAll(PDO::FETCH_ASSOC);
        
        $news = [];

        return $news['id'];
        
    }
    
    public function getNewsById(News $id) : News
    {
        $query = $this->db->prepare('SELECT category_id, name, media_id, content FROM news WHERE news.id = :id');
        $parameters = [
            'id' => $id
        ];
        $query->execute($parameters);
        $result = $query->fetch(PDO::FETCH_ASSOC);
        
        $news = [];

        return $news;
    }
    
    public function updateNews(News $news) : News
    {
        $query = $this->db->prepare('UPDATE news SET category_id = :category_id, name = :name, content = :content FROM news WHERE news.name = :name');
        $parameters = [
            'category_id' => $categoryId,
            'name' => $name,
            'content' => $content
        ];
        $query->execute($parameters);
        $result = $query->fetchAll(PDO::FETCH_ASSOC);
        
        $news = [];

        return $news;
        
    }
    
    public function deleteNews(News $news) : void
    {
        
        $query = $this->db->prepare('DELETE id, category_id, name, media_id, content FROM news WHERE news.name = :name');
        $parameters = [
            'name' => $name
        ];
        $query->execute($parameters);
        $result = $query->fetchAll(PDO::FETCH_ASSOC);
        
    }
    
}

?>