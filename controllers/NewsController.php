<?php

class NewsController extends AbstractController
{
    
    /**
     * va chercher toutes les catégories et toutes les news et les renvoi pour affichage sur la page News
     *
     * @return void
     */
     
    public function index() :void
    {
        $allCategories = $this->cm->getAllCategories();
        $news = $this->nm->getAllNews();
        $medias = [];
        
        foreach($news as $key => $singleNews)
        {
            if(!is_null($singleNews['media_id']))
            {
                $mediaId = $singleNews['media_id'];
                $media = $this->mm->getMediaById($mediaId);
            }
            else
            {
                $media = null;
            }
            $news[$key][] = $media;
        }
        
        $template = "news";

        $this->render($template, ["allCategories" => $allCategories, "news" => $news]);
    }
    
    /**
     * va chercher toutes les news par catégorie et les renvoi pour affichage sur la page News
     * @param id de la catégorie selectionnée
     * @return void
     */
    
    public function displayAllNewsByCategoryId($categoryId) :void
    {
        if(isset($POST['category-id']))
        {
            $categoryId = $POST['category-id'];
            $nm = new NewsManager();
            $allNewsByCategoryId = $nm->getAllNewsByCategoryId($categoryId);
            
            $template = "news_detail";
            
            $this->render($template, ["allNewsByCategoryId" => $allNewsByCategoryId]);
        }
    }
    
    /**
     * va chercher une news ou une recette par son id, puis son image s'il y en a une et les renvoi pour affichage
     * @param id de la news ou de la recette
     * @return void
     */
     
    public function newsDetail(array $post) :void
    {
        $newsId = $post["id"];
        $newsDetail = $this->nm->getNewsById($newsId);
        
        $categorieId = $newsDetail->getCategoryId();

        $cm = new CategoryManager;
        $categorie = $cm->getCategoryNameById($categorieId);
        
        $mediaId = $newsDetail->getMediaId();
        if($mediaId !== null)
        {
            $mm = new MediaManager;
            $media = $mm->getMediaById($mediaId);
        }
        else
        {
            $media = null;
        }
        
        if($categorieId === 3)
        {
            $rm = new RecipeManager;
            $recipe = $rm->getRecipeByNews($newsDetail);
        }
        else
        {
            $recipe = [];
        }

        $template = "actus_show";
        
        $this->render($template, ["newsDetail" => $newsDetail, "categorie" => $categorie, "media" =>$media, "recipe" => $recipe]);
    }
}
