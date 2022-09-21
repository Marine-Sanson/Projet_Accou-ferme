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
            
            $news = $this->nm->getAllNews();

            $this->render("adminNews", ["categories" => $categories, "news" => $news]);
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
    
    public function adminCrudNews(array $post) :void
    {
        $action = $post["action"];
        $categories = $this->cm->getAllCategories();
        $news = $this->nm->getAllNews();

        $this->render("adminCrudNews", ["action" => $action, "categories" => $categories, "news" => $news]);
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
    
    public function updateNews(array $post)
    {
        if($_SESSION["connectAdmin"] === true)
        {
            var_dump($post);
            
            $id = intval($post["id"]);
            $news = $this->nm->getNewsById($id);
            
            $categories = $this->cm->getAllCategories();

            $this->render("adminUpdateNews", ["news" => $news, "categories" => $categories]);
        }
    }
    
    public function newsUpdated(array $post)
    {
        if($_SESSION["connectAdmin"] === true)
        {
            $errors = [];
            
            $id = $post["id"];
            $categoryId = $post["category_id"];
            $name = $post["name"];
            $media = intval($post["media_id"]);
            $content = $post["content"];
            
            if($categoryId === "0")
            {
                $errors[] = "Veuillez selectionner une catégorie";
            }
            
            if($name === "")
            {
                $errors[] = "Veuillez mettre un titre";
            }
            
            if($content === "")
            {
                $errors[] = "Veuillez entrer un contenu";
            }
            
            $news = new News($id, $categoryId, $name, $media, $content);

            $this->nm->updateNews($news);
            $categories = $this->cm->getAllCategories();
            
            $this->render("adminUpdateNews", ["news" => $news, "categories" => $categories, "errors" => $errors]);
        }
    }
    
    public function deleteNews(array $post)
    {
        if($_SESSION["connectAdmin"] === true)
        {
            $this->render("adminDeleteNews");
        }
    }
}