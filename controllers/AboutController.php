<?php

class AboutController extends AbstractController
{
    public function index() :void
    {
        $template="about";

        $this->render($template);
    }
}
