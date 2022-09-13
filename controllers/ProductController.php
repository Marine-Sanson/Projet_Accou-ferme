<?php

class ProductController extends AbstractController
{
    // lance la fonction du manager pour afficher les noms des produits
    public function index()
    {
    
        $products = $this->pm->getAllProducts();
        $medias = [];
        
        foreach($products as $key => $product)
        {
            foreach($product["varieties"] as $key => $variety)
            {
                if(!is_null($variety['media_id'])){
                    
                    $mediaId = $variety['media_id'];
                    $media = $this->mm->getMediaById($mediaId);
                    $item = [
                        "media" => $media,
                        "variety" => $variety
                        ];
                    $medias[] = $item;
                    //return $media;
                }
                else
                {
                    $variety["media_id"] = null;
                    $item = [
                        "media" => null,
                        "variety" => $variety
                        ];
                    $medias[] = $item;
                }
            }
        }
        
        // $mediaId = $variety['media_id'];
        // var_dump($mediaId);
        // 
        // 
        $template="products";

        $this->render($template, ["products" => $products, "medias" => $medias]);
    }
    
}
