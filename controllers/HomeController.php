<?php

class HomeController extends AbstractController
{
    public function index(array $post) :void
    {
        $template = "home";
        
        $this->render($template);
    }
}
