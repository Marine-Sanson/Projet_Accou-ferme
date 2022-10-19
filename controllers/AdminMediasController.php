<?php

class AdminMediasController extends AbstractController
{
    public function index(array $data) :void
    {
        if($_SESSION["connectAdmin"] === true)
        {
            if(isset($_POST["submit"]))
            {
                if(isset($_FILES))
                {
                    if(!isset($errors))
                    {
                        $errors = [];
                    }
                    
                    if(!isset($validation))
                    {
                        $validation = "";
                    }
                    
                    $_FILES["fileToUpload"]["alt"] = $_POST["alt"];
                    $uploader = new FileUploader();
                    if(isset($_FILES["fileToUpload"]["id"]) && intval($_FILES["fileToUpload"]["id"]) === 0)
                    {
                        $id = $_FILES["fileToUpload"]["id"];
                    }
                    else
                    {
                        $id = null;
                    }
                    
                    $_FILES["fileToUpload"]["url"] = getcwd() . "/uploads/" . $_FILES["fileToUpload"]["tmp_name"] . ".". $_FILES["fileToUpload"]["type"];

                    $result = $_POST;
                    
                    $newMedia = new Media($id, $_FILES["fileToUpload"]["name"], $_FILES["fileToUpload"]["tmp_name"],
                    $_FILES["fileToUpload"]["type"], $_FILES["fileToUpload"]["url"], $_FILES["fileToUpload"]["alt"]);
                    
                    $media = $uploader->upload($newMedia);
                    $errors = $media["errors"];
                    
                
                    if(isset($errors) && $errors !== [] || empty($media["fileToUpload"]) ||
                    $media["fileToUpload"] === null)
                    {
                        $allMedias = $this->mm->getAllMedias();
                        $this->render("adminMedias", ["errors" => $errors, "validation" => $validation,
                        "allMedias" => $allMedias]);
                    }
                    else
                    {
                        $img = $media["fileToUpload"][0];
                        $errors = $media["errors"];
                        $validation = $media["validation"];
                        $this->mm->createMedia($img);
                        
                        $allMedias = $this->mm->getAllMedias();

                        $this->render("adminMedias", ["img" => $img, "errors" => $errors, "validation" => $validation,
                        "allMedias" => $allMedias]);
                    }
                }
            }
            else
            {
                $allMedias = $this->mm->getAllMedias();
                $this->render("adminMedias", ["allMedias" => $allMedias]);
            }
        }
        else if($_SESSION["connectAdmin"] === false || empty($_SESSION["connectAdmin"]))
        {
            $allMedias = $this->mm->getAllMedias();
            $errors[] = "Veuillez vous connecter";
            $this->render("admin", ["errors" => $errors, "allMedias" => $allMedias]);
        }
    }
    
    public function getMediasData(int $id) : Media
    {
        $media = $this->mm->getMediaById($id);
        return $media;
    }
    
    public function deleteImage(array $post) : void
    {
        $id = intval($post["mediaId"]);

        $this->mm->deleteMedia($id);
        
        $allMedias = $this->mm->getAllMedias();
        $validation = "cette image à bien été supprimée";
        
        $this->render("adminMedias", ["validation" => $validation, "allMedias" => $allMedias]);
    }
}