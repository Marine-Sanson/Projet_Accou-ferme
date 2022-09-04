<?php

class AdminNewsController extends AbstractController
{
    public function index()
    {
        $this->render("_adminNews");
    }
    
    public function newsCreated(array $post) :News
    {
        
    }
    
}