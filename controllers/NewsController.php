<?php

class NewsController extends AbstractController
{
    public function index()
    {
        $this->render("news");
    }
}
