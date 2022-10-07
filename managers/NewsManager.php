<?php

class NewsManager extends AbstractManager
{
    
    /**
     * reçoit une News, la crée dans la base de donées et renvoie son id
     * @param News
     * @return id
     */
    
    public function createNews(News $news) : int
    {
        $query = $this->db->prepare('INSERT INTO news ( category_id, name, content ) VALUES ( :category_id, :name, :content )');
        $parameters = [
            'category_id' => $news->getCategoryId() ,
            'name' => $news->getName(),
            'content' => $news->getContent()
        ];
        $query->execute($parameters);
        
        $newsId = $this->db->lastInsertId();
        
        return $newsId;
    }
    
    /**
     * reçoit le nom d'une News et renvoie son id
     * @param $name
     * @return id
     */
    
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
    
    /**
     * va chercher toutes les News
     * @param 
     * @return un array avec toutes les News
     */
    
    public function getAllNews() :array
    {
        $query = $this->db->prepare('SELECT news.id, news.category_id, news.name, news.media_id, news.content, categories.name as category_name FROM news JOIN categories ON news.category_id = categories.id');
        $query->execute();
        $fullNews = $query->fetchAll(PDO::FETCH_ASSOC);

        return $fullNews;
    }
    
    /**
     * va chercher toutes les News d'après l'id de la catégorie
     * @param $categoryId
     * @return un array avec toutes les News concernées
     */
    
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
    
    /**
     * va chercher toutes une News d'après son id
     * @param $id
     * @return News
     */
    
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
    
    /**
     * va chercher la dernière une News insérée dans la base de données
     * @param 
     * @return News
     */
    
    public function getLastNews() : News
    {
        $query = $this->db->prepare('SELECT id, category_id, name, media_id, content FROM news WHERE category_id != 3 ORDER BY id DESC LIMIT 1');
        // $parameters = [
        //     'id' => $id
        // ];
        $query->execute();
        $result = $query->fetchAll(PDO::FETCH_ASSOC);
        
        $newsId = $result[0]["id"];
        $newsCatId = $result[0]["category_id"];
        $newsName = $result[0]["name"];
        $newsMedia = $result[0]["media_id"];
        $newsContent = $result[0]["content"];
        $news = new News($newsId, $newsCatId, $newsName, $newsMedia, $newsContent);

        return $news;
    }
    
    /**
     * va chercher la dernière Recipe (=News avec l'id de catégorie = 3) insérée dans la base de données
     * @param 
     * @return News
     */
    
    public function getLastRecipe() : News
    {
        $query = $this->db->prepare('SELECT id, category_id, name, media_id, content FROM news WHERE category_id = 3 ORDER BY id DESC LIMIT 1');
        $query->execute();
        $result = $query->fetchAll(PDO::FETCH_ASSOC);
        
        $newsId = $result[0]["id"];
        $newsCatId = $result[0]["category_id"];
        $newsName = $result[0]["name"];
        $newsMedia = $result[0]["media_id"];
        $newsContent = $result[0]["content"];
        $news = new News($newsId, $newsCatId, $newsName, $newsMedia, $newsContent);

        return $news;
    }
    
    /**
     * reçoit une News et la met à jour
     * @param News
     * @return 
     */
    
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
    
    /**
     * reçoit un id de Media et le met à jour sur la News concernée
     * @param $mediaId, $newsId
     * @return
     */
    
    public function updateNewsMedia(int $mediaId, int $newsId) : void
    {
        $query = $this->db->prepare('UPDATE news SET media_id = :media_id WHERE id = :id');
        $parameters = [
            'id' => $newsId,
            'media_id' => $mediaId
        ];
        $query->execute($parameters);
    }
    
    /**
     * supprime une News
     * @param News
     * @return
     */
    
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