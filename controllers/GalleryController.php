<?php

class GalleryController extends AbstractController
{
    
    /**
     * va chercher 24 images présentes et les renvoi pour affichage
     * @param 
     * @return void
     */

    public function index() :void
    {
        $template="gallery";
        
        $allMediasIds = $this->mm->getMediasIdsforGallery();

        foreach($allMediasIds as $key => $id)
        {
            $media = $this->mm->getMediaById($id["id"]);
            $allMedias[] = $media;
        }
        
        $this->render($template, ["allMedias" => $allMedias]);
    }
}
