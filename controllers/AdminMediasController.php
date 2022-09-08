<?php

class AdminMediasController extends AbstractController
{
    public function index()
    {
        if($_SESSION["connectAdmin"] === true)
        {

            if(isset($_POST["submit"]))
            {
                if(isset($_FILES["fileToUpload"]))
                {
                    $_FILES["fileToUpload"]["alt"] = $_POST["alt"];
                    
                    $uploader = new FileUploader();

                    $media = $uploader->upload($_FILES["fileToUpload"]);
                    
                    $this->mm->createMedia($media);
                    
                    $this->render("adminMedias", ["media" => $media]);
                }
            }
            else
            {
                $this->render("adminMedias", []);
            }
        }
        else
        {
            $this->render("admin");
        }
    }
    
}