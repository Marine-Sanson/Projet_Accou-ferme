<?php

require "./models/Category.php";
require "./models/News.php";


class AdminNewsController extends AbstractController
{
    public function index() :void
    {
        if($_SESSION["connectAdmin"] === true)
        {
            $categories = $this->cm->getAllCategories();

            $this->render("adminNews", ["categories" => $categories]);
        }
        else
        {
            $this->render("admin");
        }
    }
    
    public function categoryCreated(array $post) :void
    {
        if($_SESSION["connectAdmin"] === true)
        {
            $name = $_POST["newCat"];
            $newCat = new Category(null, $name);

            $this->cm->createCategory($newCat);
        }
        else
        {
            $this->render("admin");
        }
    }
    
    public function newsCreated(array $post) :void
    {
        if($_SESSION["connectAdmin"] === true)
        {
            $categoryId = $_POST["cat"];
            $name = $_POST["name"];
            $content = $_POST["content"];
        
            $news = new News(null, $categoryId, $name, null, $content);
            $this->nm->createNews($news);
        }
        else
        {
            $this->render("admin");
        }
    }
}