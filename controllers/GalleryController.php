<?php

class GalleryController extends AbstractController
{
    public function index() :void
    {
        $template="gallery";

        $this->render($template);

    }
}
