<?php

class NewsManager extends AbstractManager
{

    public function createNews(News $news) :void
    {
        $query = $this->db->prepare('INSERT INTO news ( category_id, name, content ) VALUES ( :category_id, :name, :content )');
        $parameters = [
            'category_id' => $news->getCategoryId() ,
            'name' => $news->getName(),
            'content' => $news->getContent()
        ];
        $query->execute($parameters);
        
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
    
    public function getAllNews() :array
    {
        $query = $this->db->prepare('SELECT news.id, news.category_id, news.name, news.media_id, news.content, categories.name as category_name FROM news JOIN categories ON news.category_id = categories.id');
        $query->execute();
        $fullNews = $query->fetchAll(PDO::FETCH_ASSOC);

        return $fullNews;
    }
    
    public function getAllNewsByCategoryId($categoryId) :array
    {
        $query = $this->db->prepare('SELECT id, name, media_id, content FROM news WHERE category_id = :categories.id ');
        $parameters = [
            'categories.id' => $categoryId
        ];
        $query->execute($parameters);
        $NewsByCategoryId = $query->fetchAll(PDO::FETCH_ASSOC);

        return $NewsByCategoryId;
    }
    
    public function getNewsById(int $id) : News
    {
        $query = $this->db->prepare('SELECT category_id, name, media_id, content FROM news WHERE news.id = :id');
        $parameters = [
            'id' => $id
        ];
        $query->execute($parameters);
        $result = $query->fetch(PDO::FETCH_ASSOC);
        
        $newsId = $id;
        $newsCatId = $result["category_id"];
        $newsName = $result["name"];
        $newsMedia = $result["media_id"];
        $newsContent = $result["content"];
        $news = new News($id, $newsCatId, $newsName, $newsMedia, $newsContent);

        return $news;
    }
    
    public function updateNews(News $news) : void
    {
        $query = $this->db->prepare('UPDATE news SET category_id = :category_id, name = :name, content = :content WHERE id = :id');
        $parameters = [
            'id' => $news->getId(),
            'category_id' => $news->getCategoryId(),
            'name' => $news->getName(),
            'content' => $news->getContent()
        ];
        $query->execute($parameters);

    }
    
    public function deleteNews(News $news) : void
    {
        
        $query = $this->db->prepare('DELETE FROM news WHERE id = :id');
        $parameters = [
            'id' => $news->getId()
        ];
        $query->execute($parameters);
    }
    
}

?>