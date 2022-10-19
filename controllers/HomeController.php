<?php

class HomeController extends AbstractController
{

    /**
     * va chercher les produits du moment, la dernière info et la dernière recette et les renvoi
     * pour affichage sur la page Home
     *
     * @return void
     */
     
    public function index() :void
    {
        $template = "home";
        
        $offers = $this->getOffers();
        
        $lastNews = $this->getLastNews();
        
        $lastRecipe = $this->getLastRecipe();

        $this->render($template, ["offers" => $offers, "lastNews" => $lastNews, "lastRecipe" => $lastRecipe]);
    }
    
    /**
     * va chercher les produits du moment et l'image associée et les renvoi
     * 
     * @return produits du moment
     */
    
    public function getOffers() : array
    {
        $offers = $this->vm->getOfferVarieties();
        
        foreach($offers as $key => $offer)
        {
            $productName = $this->pm->getProductName($offer["product_id"]);
            $offers[$key][] = ["product_name" => $productName];
            
            if($offer["media_id"] !== null)
            {
                $media = $this->mm->getMediaById($offer["media_id"]);
                $offers[$key][] = ["media" => $media];
            }
            else
            {
                $media = [];
            }
        }
        
        return $offers;

    }
    
    /**
     * va chercher la dernière info et l'image associée et les renvoi
     * 
     * @return dernière info
     */

    public function getLastNews() : array
    {
        $news = $this->nm->getLastNews();
        $lastNews["news"] = $news;

        $lastNewsMediaId = $news->getMediaId();

        if($lastNewsMediaId !== null)
        {
            $media = $this->mm->getMediaById($lastNewsMediaId);

            $lastNews["media"] = $media;
        }
        else
        {
            $media = [];
        }

        return $lastNews;
    }
    
    /**
     * va chercher la dernière recette et l'image associée et les renvoi
     * 
     * @return dernière recette
     */

    public function getLastRecipe() : array
    {
        $news = $this->nm->getLastRecipe();
        $newsId = $news->getId();
        $recipe = $this->rm->getRecipeByNews($news);
        
        $lastRecipe["recipe"] = $recipe;

        $lastRecipeMediaId = $recipe->getMediaId();

        if($lastRecipeMediaId !== null)
        {
            $media = $this->mm->getMediaById($lastRecipeMediaId);

            $lastRecipe["media"] = $media;
        }
        else
        {
            $media = [];
        }

        return $lastRecipe;
    }

}
