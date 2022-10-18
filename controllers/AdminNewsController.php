<?php

class AdminNewsController extends AbstractController
{
    public function index() :void
    {
        if($_SESSION["connectAdmin"] === true)
        {
            // $tokenAdminNews = $this->generateToken(25);
            // $_SESSION["tokenForAdminNews"] = $tokenAdminNews;
            
            $categories = $this->cm->getAllCategories();
            $allNews = $this->nm->getAllNews();
            
            foreach($allNews as $key => $news)
            {
                $newsId = $news["media_id"];
                if(isset($newsId) && $newsId !== null)
                {
                    $media = $this->mm->getMediaById($newsId);
                    $allNews[$key][] = $media;
                }
            }

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
            $name = $post["newCat"];
            
            // if(trim($post["tokenAdminNews"]) !== $_SESSION["tokenForAdminNews"])
            // {
            //     $errors[] = "une erreur s'est produite lors de l'envoi du formulaire";
            // }

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
            
            if(empty($errors))
            {
                $newCat = new Category(null, $name);
    
                $this->cm->createCategory($newCat);
                
                $validation = "nouvelle categorie créée";
            }
            else
            {
                $validation = "";
            }

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
        $allProducts = $this->pm->getProducts();

        if(isset($post["crudId"]) && $post["crudId"] !== null)
        {
            $crudId = $post["crudId"];
            $singleNews["news"] = $this->nm->getNewsById($crudId);
            
            $mediaId = $singleNews["news"]->getMediaId();
            if(isset($mediaId))
            {
                $media = $this->mm->getMediaById($mediaId);
            }
            else
            {
                $media = [];
            }
            
            $newsIdToVerify = $singleNews["news"]->getId();
            
            $trueNewsId = $this->trueNewsId($newsIdToVerify);
            
            if($singleNews["news"]->getCategoryId() === 3 && $trueNewsId)
            {
                $singleRecipe["recipe"] = $this->rm->getRecipeByNews($singleNews["news"]);
            }
            else
            {
                $singleRecipe["recipe"] = [];
            }
        }
        else
        {
            $crudId = 0;
            $singleNews["news"] = [];
            $singleRecipe["recipe"] = [];
            $media = [];
        }
        
        $this->render("adminCrudNews", ["action" => $action, "categories" => $categories, "singleNews" => $singleNews, "singleRecipe" => $singleRecipe, "allProducts" => $allProducts, "media" => $media]);
    }
    
    public function trueNewsId(int $newsIdToVerify) : bool
    {
        $trueNewsId = false;
        $allNewsIds = $this->rm->getAllNewsIds();
        
        foreach($allNewsIds as $key => $newsId)
        {
            if($newsId === $newsIdToVerify)
            {
                $trueNewsId = true;
            }
        }
        
        return $trueNewsId;
    }
    
        public function chooseNewsImage(array $post) :void
    {
        $newsId = $post["id"];
        $allMedias = $this->mm->getAllMedias();
        
        $this->render("chooseNewsImage", ["newsId" => $newsId, "allMedias" => $allMedias]);
    }
    
    public function updateNewsImage(array $post) :void
    {
        $mediaId = $post["mediaId"];
        $newsId = $post["newsId"];
        
        $this->nm->updateNewsMedia($mediaId, $newsId);
        
        $validation = "votre image a bien été selectionnée";
        
        $categories = $this->cm->getAllCategories();
        $allNews = $this->nm->getAllNews();
        
        foreach($allNews as $key => $singleNews)
        {
            $mediaId = $singleNews["media_id"];
            if($mediaId !== null)
            {
                $media = $this->mm->getMediaById($mediaId);
                $allNews[$key][] = $media;
            }
        }
        
        $this->render("adminNews", ["categories" => $categories, "allNews" => $allNews, "validation" => $validation]);
    }

    
    public function createNews(array $post) :void
    {
        if($_SESSION["connectAdmin"] === true)
        {

            $action = "createNews";
            $newsVerified = $this->verifyNews($post, $action);
            
            $allProducts = $this->pm->getProducts();
            
            if(empty($newsVerified["errors"]))
            {
                $this->nm->createNews($newsVerified["news"]);

                $categories = $this->cm->getAllCategories();
                $allNews = $this->nm->getAllNews();
                
                foreach($allNews as $key => $news)
                {
                    $mediaId = $news["media_id"];
                    if($mediaId !== null)
                    {
                        $media = $this->mm->getMediaById($mediaId);
                        $allNews[$key][] = $media;
                    }
                }
                
                $validation = "Votre actu a bien été créée !";

                $this->render("adminNews", ["validation" => $validation, "categories" => $categories, "allNews" => $allNews, "allProducts" => $allProducts]);
            }
            else
            {
                $categories = $this->cm->getAllCategories();
                $errors[] = $newsVerified["errors"];
                $action = "createNews";
                $singleNews = $newsVerified;
                
                $this->render("adminCrudNews", ["singleNews" => $singleNews, "categories" => $categories, "errors" => $errors, "action" => $action, "allProducts" => $allProducts]);
            }
        }
        else
        {
            $errors[] = "Veuillez vous connecter";
            $this->render("admin", ["errors" => $errors]);
        }
    }
    
    public function createRecipe(array $post) :void
    {
        if($_SESSION["connectAdmin"] === true)
        {
            $action = "createRecipe";

            $recipeVerified = $this->verifyRecipe($post, $action);

            $allProducts = $this->pm->getProducts();

            if(empty($recipeVerified["errors"]))
            {
                $newsId = $this->nm->createNews($recipeVerified["news"]);
                
                $recipeVerified["recipe"]->setNewsId($newsId);
                
                $this->rm->createRecipe($recipeVerified["recipe"]);

                $categories = $this->cm->getAllCategories();
                $allNews = $this->nm->getAllNews();
                
                foreach($allNews as $key => $news)
                {
                    $mediaId = $news["media_id"];
                    if($mediaId !== null)
                    {
                        $media = $this->mm->getMediaById($mediaId);
                        $allNews[$key][] = $media;
                    }
                }
                
                $validation = "Votre recette a bien été créée !";

                $this->render("adminNews", ["validation" => $validation, "categories" => $categories, "allNews" => $allNews, "allProducts" => $allProducts]);
            }
            else
            {
                $categories = $this->cm->getAllCategories();
                $errors[] = $recipeVerified["errors"];
                $action = "createRecipe";
                $singleNews = $recipeVerified;
                $singleRecipe = $recipeVerified;
                
                $this->render("adminCrudNews", ["singleNews" => $singleNews, "singleRecipe" => $singleRecipe, "categories" => $categories, "errors" => $errors, "action" => $action, "allProducts" => $allProducts]);
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
            $news = $post;
            
            if(intval($post["category_id"]) === 3)
            {
                $recipeVerified = $this->verifyRecipe($post, $action);
                $errors[] = $recipeVerified["errors"];
                $action = $recipeVerified["action"];
                $news = $recipeVerified["news"];
                
                $newsVerified = [
                    "errors" => $errors,
                    "action" => $action,
                    "news" => $news
                    ];
                
            }
            else
            {
                $newsVerified = $this->verifyNews($post, $action);
                $recipeVerified = [];
            }
            
            $categories = $this->cm->getAllCategories();
            $allProducts = $this->pm->getProducts();
            
            if(empty($newsVerified["errors"]))
            {
                $news = $newsVerified["news"];
                $this->nm->updateNews($news);
                
                if(isset($recipeVerified["recipe"]) && !empty($recipeVerified["recipe"]))
                {
                    $this->rm->updateRecipe($recipeVerified["recipe"]);
                }

                $allNews = $this->nm->getAllNews();
                
                foreach($allNews as $key => $news)
                {
                    $mediaId = $news["media_id"];
                    if($mediaId !== null)
                    {
                        $media = $this->mm->getMediaById($mediaId);
                        $allNews[$key][] = $media;
                    }
                }
                
                $validation = "Votre actu a bien été modifiée !";
    
                $this->render("adminNews", ["validation" => $validation, "allNews" => $allNews, "categories" => $categories, "allProducts" => $allProducts]);
            }
            else
            {
                $errors[] = $newsVerified["errors"];
                $singleNews = $newsVerified;
                if($singleNews["news"]->getCategoryId() === 3)
                {
                    $singleRecipe = $recipeVerified;
                }
                else
                {
                    $singleRecipe = [];
                }
                
                $this->render("adminCrudNews", ["singleNews" => $singleNews, "singleRecipe" => $singleRecipe, "categories" => $categories, "errors" => $errors, "action" => $action, "allProducts" => $allProducts]);
            }
        }
        else
        {
            $errors[] = "Veuillez vous connecter";
            $this->render("admin", ["errors" => $errors]);
        }
    }
    
    public function deleteNews(array $post)
    {
        if($_SESSION["connectAdmin"] === true)
        {

            $action = "delete";
            $newsVerified = $this->verifyNews($post, $action);
            
            if($newsVerified["news"]->getCategoryId() === 3)
            {
                $recipeVerified = $this->verifyRecipe($post, $action);
            }
            
            $categories = $this->cm->getAllCategories();
            $allProducts = $this->pm->getProducts();
            
            if(empty($newsVerified["errors"]))
            {
                $news = $newsVerified["news"];
                
                if(isset($recipeVerified))
                {
                    $this->rm->deleteRecipe($recipeVerified["recipe"]);
                }
                
                $this->nm->deleteNews($news);
                
                $allNews = $this->nm->getAllNews();
                
                foreach($allNews as $key => $news)
                {
                    $mediaId = $news["media_id"];
                    if($mediaId !== null)
                    {
                        $media = $this->mm->getMediaById($mediaId);
                        $allNews[$key][] = $media;
                    }
                }
                
                $validation = "Votre actu a bien été suprimée !";
    
                $this->render("adminNews", ["validation" => $validation, "allNews" => $allNews, "categories" => $categories, "allProducts" => $allProducts]);
            }
            else
            {
                $errors[] = $newsVerified["errors"];
                $singleNews = $newsVerified["news"];

                $this->render("adminCrudNews", ["singleNews" => $singleNews, "categories" => $categories, "errors" => $errors, "action" => $action, "allProducts" => $allProducts]);
            }
        }
    }
    
    public function verifyNews(array $post, string $action) :array
    {
        if(!isset($errors))
        {
            $errors = [];
        }
        
        $inputId = $this->clean_input($post["id"]);
        $id = intval($inputId);
        
        $inputCategoryId = $this->clean_input($post["category_id"]);
        $categoryId = intval($inputCategoryId);
        
        $newsMediaId = $post["media_id"];
        
        $name = $this->clean_input($post["name"]);
        
        if(isset($post["media_id"]))
        {
            $inputMedia = $this->clean_input($post["media_id"]);
            $media = intval($inputMedia);
        }
        
        $content = $this->clean_input($post["content"]);
        
        if(strlen($inputId) > 5)
        {
            $errors[] = "Veuillez recommencer, cette action a généré un problème";
        }
        
        if($categoryId === 0 || !is_int($categoryId))
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
    
    public function verifyRecipe(array $post, string $action) :array
    {
        $errors = [];

        $verifyNews = $this->verifyNews($post, $action);

        foreach($verifyNews["errors"] as $key => $error)
        {
            $errors[] = $error;
        }
        
        if(isset($post["recipeId"]) && intval($post["recipeId"]) !== 0)
        {
            $recipeId = intval($post["recipeId"]);
        }
        else
        {
            $recipeId = 0;
        }
        
        if(isset($post["product_id"]) && $post["product_id"] !== 0)
        {
            $inputProductId = $this->clean_input($post["product_id"]);
            $productId = intval($inputProductId);
        }
        else
        {
            $inputProductId = 0;
            $productId = 0;
        }

        if(isset($post["ingredients"]) && $post["ingredients"] !== 0)
        {
            $ingredients = $this->clean_input($post["ingredients"]);
        }
        else
        {
            $ingredients = "";
        }
        
        if(isset($post["steps"]) && $post["steps"] !== 0)
        {
            $steps = $this->clean_input($post["steps"]);
        }
        else
        {
            $steps = "";
        }


        if($productId === 0 || !is_int($productId))
        {
            $errors[] = "Veuillez selectionner un produit";
        }
        
        if(strlen($inputProductId) > 5)
        {
            $errors[] = "Veuillez selectionner un produit valide";
        }
        
        if($ingredients === "" || strlen($ingredients) < 2)
        {
            $errors[] = "Veuillez renseigner les ingredients";
        }
        
        if(strlen($ingredients) > 2048)
        {
            $errors[] = "Veuillez entrer une liste d'ingredients plus courte (max 2047 caractères)";
        }

        if(!is_string($ingredients))
        {
            $errors[] = "Veuillez entrer des ingredients valides";
        }
        
        if($steps === "" || strlen($steps) < 2)
        {
            $errors[] = "Veuillez renseigner les étapes de la recette";
        }
        
        if(strlen($steps) > 2048)
        {
            $errors[] = "Veuillez entrer des étapes plus courtes (max 2047 caractères)";
        }

        if(!is_string($steps))
        {
            $errors[] = "Veuillez entrer des étapes valides";
        }
        
        $news = $verifyNews["news"];
        $newsId = $news->getId();

        $recipe = new Recipe($recipeId, $newsId, $productId, $ingredients, $steps);
        $recipe->setCategoryId($verifyNews["news"]->getCategoryId());
        $recipe->setName($verifyNews["news"]->getName());
        $recipe->setMediaId($verifyNews["news"]->getMediaId());
        $recipe->setContent($verifyNews["news"]->getContent());
        
        $verifyRecipe = [
            "errors" => $errors,
            "action" => $action,
            "news" => $news,
            "recipe" => $recipe
        ];
        
        return $verifyRecipe;
    }
}