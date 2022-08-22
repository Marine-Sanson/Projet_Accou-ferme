<?php

class NewsController extends AbstractController
{
    public function index()
    {
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

        $this->render("news", ["news" => $news, "medias" => $medias]);
    }
}
