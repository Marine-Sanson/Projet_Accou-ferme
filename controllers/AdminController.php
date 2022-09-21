<?php

class AdminController extends AbstractController
{
    public function index() :void
    {
        $this->render("admin");
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
        }
        else
        {
            $user = $this->am->connectAdmin($username);
            
            if(isset($user) && !empty($user) && $user !== "")
            {

                if($username !== $user[0]["name"])
                {
                    $errors[] = "identifiant incorrect"; 
                }
                else if(!password_verify($password, $user[0]["password"]))
                {
                    $errors[] = "mot de passe incorrect";
                }
                else if($username === $user[0]["name"] && password_verify($password, $user[0]["password"]))
                {
                    $_SESSION["connectAdmin"] = true;
                    $this->render("adminMenu");
                }
                else
                {
                    $errors[] = "Les identifiants ne sont pas valides"; 
                }
                
                $this->render("admin", ["errors" => $errors]);
            }
            else
            {
                $errors[] = "Les identifiants ne sont pas valides"; 
            }
        }
        $this->render("admin", ["errors" => $errors]);

    }
}