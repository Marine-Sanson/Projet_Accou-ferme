<?php

class AdminController extends AbstractController
{
    public function index()
    {
        $this->render("admin");
    }
    
    public function loginCheck(array $post)
    {
        // reçoit le formulaire
        $username = $_POST["username"];
        $password = $_POST["password"];
        
        $um = new UserManager();
        $user = $um->connectUser($username);
        
        if($user !== null){
            if($password === $user["password"]){
                $_SESSION["user"] = $user;
                $this->render("_adminMenu");            }
            }
            else
            {
                $this->render("admin");
            }
        
        $this->render("admin");
    }
}