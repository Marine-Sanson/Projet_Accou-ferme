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
        
        $am = new AdminManager();
        $user = $am->connectAdmin($username);

        if($user !== null){
            if($username === $user[0]["name"] && password_verify($password, $user[0]["password"]))
            {
                $_SESSION["connectAdmin"] = true;
                $this->render("adminMenu");            }
            }
            else
            {
                $this->render("admin");
            }
    }
}