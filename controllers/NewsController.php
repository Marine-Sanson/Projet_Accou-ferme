<?php

class NewsController extends AbstractController
{
    public function index() :void
    {
        $allCategories = $this->cm->getAllCategories();
        $news = $this->nm->getAllNews();
        $medias = [];
        
        foreach($news as $key => $singleNews)
        {
            if(!is_null($singleNews['media_id'])){
                    
                $mediaId = $singleNews['media_id'];
                $media = $this->mm->getMediaById($mediaId);
                $item = [
                    "media" => $media,
                    "singleNews" => $singleNews
                    ];
                $medias[] = $item;
                //return $media;
            }
            else
            {
                $singleNews["media_id"] = null;
                $item = [
                    "media" => null,
                    "singleNews" => $singleNews
                    ];
                $medias[] = $item;
            }
        }
        
        $template = "news";

        $this->render($template, ["allCategories" => $allCategories, "news" => $news, "medias" => $medias]);
    }
    
    public function displayAllNewsByCategoryId($categoryId) :void
    {
        if(isset($POST['category-id']))
        {
            $categoryId = $POST['category-id'];
            $nm = new NewsManager();
            $allNewsByCategoryId = $nm->getAllNewsByCategoryId($categoryId);
            
            $this->render("news_detail", ["allNewsByCategoryId" => $allNewsByCategoryId]);
        }
    }
    
}
