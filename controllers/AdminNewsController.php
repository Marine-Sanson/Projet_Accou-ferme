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
            $allNews = $this->nm->getAllNews();

            $this->render("adminNews", ["categories" => $categories, "allNews" => $allNews]);
        }
        else if($_SESSION["connectAdmin"] === false || empty($_SESSION["connectAdmin"]))
        {
            $errors[] = "Veuillez vous connecter";
            $this->render("admin", ["errors" => $errors]);
        }
    }
    
    public function categoryCreated(array $post) :void
    {
        if($_SESSION["connectAdmin"] === true)
        {
            $name = $_POST["newCat"];
            $newCat = new Category(null, $name);

            $this->cm->createCategory($newCat);
            
            $validation = "nouvelle categorie créée";
            
            $categories = $this->cm->getAllCategories();
            $allNews = $this->nm->getAllNews();

            $this->render("adminNews", ["categories" => $categories, "allNews" => $allNews, "validation" => $validation]);
            
        }
        else
        {
            $errors[] = "Veuillez vous connecter";
            $this->render("admin", ["errors" => $errors]);
        }
    }
    
    public function adminCrudNews(array $post) :void
    {
        $action = $post["action"];
        $categories = $this->cm->getAllCategories();
        
        if(isset($post["crudId"]) && $post["crudId"] !== null)
        {
            $crudId = $post["crudId"];
            $singleNews = $this->nm->getNewsById($crudId);
        }
        else
        {
            $crudId = 0;
            $singleNews = [];
        }
        
        $this->render("adminCrudNews", ["action" => $action, "categories" => $categories, "singleNews" => $singleNews]);
    }
    
    
    public function createNews(array $post) :void
    {
        if($_SESSION["connectAdmin"] === true)
        {
            $action = "create";
            $newsVerified = $this->verifyNews($post, $action);
            
            if(empty($newsVerified["errors"]))
            {
                $this->nm->createNews($newsVerified["news"]);
            
                $categories = $this->cm->getAllCategories();
                $allNews = $this->nm->getAllNews();
                $validation = "Votre actu a bien été créée!";

                $this->render("adminNews", ["validation" => $validation, "categories" => $categories, "allNews" => $allNews]);
            }
            else
            {
                $categories = $this->cm->getAllCategories();
                $errors = $newsVerified["errors"];
                $action = "create";
                $singleNews = $newsVerified["news"];
                $this->render("adminCrudNews", ["singleNews" => $singleNews, "categories" => $categories, "errors" => $errors, "action" => $action]);
            }
            
        }
        else
        {
            $errors[] = "Veuillez vous connecter";
            $this->render("admin", ["errors" => $errors]);
        }
    }
    
    public function updateNews(array $post)
    {
        if($_SESSION["connectAdmin"] === true)
        {
            $action = "update";
            $newsVerified = $this->verifyNews($post, $action);
            $categories = $this->cm->getAllCategories();
            
            if(empty($newsVerified["errors"]))
            {
                $news = $newsVerified["news"];
                $this->nm->updateNews($news);
                $allNews = $this->nm->getAllNews();
                
                $validation = "Votre actu a bien été modifiée!";
    
                $this->render("adminNews", ["validation" => $validation, "allNews" => $allNews, "categories" => $categories]);
            }
            else
            {
                $errors = $newsVerified["errors"];
                $singleNews = $newsVerified["news"];
                
                $this->render("adminCrudNews", ["singleNews" => $singleNews, "categories" => $categories, "errors" => $errors, "action" => $action]);
            }
        }
    }
    
    public function deleteNews(array $post)
    {
        if($_SESSION["connectAdmin"] === true)
        {
            $action = "delete";
            $newsVerified = $this->verifyNews($post, $action);
            $categories = $this->cm->getAllCategories();
            
            if(empty($newsVerified["errors"]))
            {
                $news = $newsVerified["news"];
                $this->nm->deleteNews($news);
                $allNews = $this->nm->getAllNews();
                
                $validation = "Votre actu a bien été suprimée!";
    
                $this->render("adminNews", ["validation" => $validation, "allNews" => $allNews, "categories" => $categories]);
            }
            else
            {
                $errors = $newsVerified["errors"];
                $singleNews = $newsVerified["news"];

                $this->render("adminCrudNews", ["singleNews" => $singleNews, "categories" => $categories, "errors" => $errors, "action" => $action]);
            }
        }
    }
    
    public function verifyNews(array $post, string $action) :array
    {
        $errors = [];
        
        $inputId = $this->clean_input($post["id"]);
        $id = intval($inputId);
        
        $inputCategoryId = $this->clean_input($post["category_id"]);
        $categoryId = intval($inputCategoryId);
        
        $name = $this->clean_input($post["name"]);
        
        $inputMedia = $this->clean_input($post["media_id"]);
        $media = intval($inputMedia);
        
        $content = $this->clean_input($post["content"]);
        
        if(strlen($inputId) > 5)
        {
            $errors[] = "Veuillez recommencer, cette action a généré un problème";
        }
        
        if($categoryId === "0" || !is_int($categoryId))
        {
            $errors[] = "Veuillez selectionner une catégorie";
        }
        
        if(strlen($inputCategoryId) > 5)
        {
            $errors[] = "Veuillez selectionner une catégorie valide";
        }
        
        if($name === "")
        {
            $errors[] = "Veuillez mettre un titre";
        }
        
        if(strlen($name) > 256)
        {
            $errors[] = "Veuillez entrer un titre plus court (max 255 caractères)";
        }

        if(!is_string($name))
        {
            $errors[] = "Veuillez entrer un titre valide";
        }
        
        if(strlen($inputMedia) > 6)
        {
            $errors[] = "Veuillez choisir une image valide";
        }
        
        if($content === "")
        {
            $errors[] = "Veuillez entrer un contenu";
        }
        
        if(strlen($content) > 2048)
        {
            $errors[] = "Veuillez entrer un contenu plus court (max 2047 caractères)";
        }
        
        if(!is_string($content))
        {
            $errors[] = "Veuillez entrer un contenu valide";
        }
        
        $news = new News($id, $categoryId, $name, $media, $content);
        
        $verifyNews = [
            "errors" => $errors,
            "action" => $action,
            "news" => $news
        ];

        return $verifyNews;
    }
}