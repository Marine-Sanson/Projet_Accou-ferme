<?php

class AdminController extends AbstractController
{
    public function index() :void
    {
        if($_SESSION["connectAdmin"] === true)
            {
                $this->render("adminMenu");
            }
        else if($_SESSION["connectAdmin"] === false || empty($_SESSION["connectAdmin"]))
            {
                $errors[] = "Veuillez vous connecter";
                $this->render("admin", ["errors" => $errors]);
            }
    }
    
    public function loginCheck(array $post) :void
    {
        $errors = [];

        // reçoit le formulaire et le vérifie
        $username = $_POST["username"];
        $password = $_POST["password"];
        
        if($username === "" || $password === "")
        {
            $errors[] = "Veuillez vous connecter";
            $this->render("admin", ["errors" => $errors]);
        }
        else
        {
            $user = $this->am->connectAdmin($username);
            
            if(isset($user) && !empty($user) && $user !== "")
            {
                $_SESSION["connectAdmin"] = false;
                if($username !== $user[0]["name"] || !password_verify($password, $user[0]["password"]))
                {
                    $errors[] = "identifiant ou mot de passe incorrect";
                    $this->render("admin", ["errors" => $errors]);
                }
                else if($username === $user[0]["name"] && password_verify($password, $user[0]["password"]))
                {
                    $_SESSION["connectAdmin"] = true;
                    $this->render("adminMenu", ["errors" => $errors]);
                }
                else
                {
                    $errors[] = "Les identifiants ne sont pas valides";
                    $this->render("admin", ["errors" => $errors]);
                }
            }
            else
            {
                $errors[] = "Les identifiants ne sont pas valides";
                $this->render("admin", ["errors" => $errors]);
            }
        }
    }
    
    public function adminDisconnect(){
        unset($_SESSION["connectAdmin"]);
        session_destroy();
        
        $validation = "Vous avez été déconnecté";
        
        $this->render("admin", ["validation" => $validation]);
    }
}