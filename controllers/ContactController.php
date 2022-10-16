<?php

class ContactController extends AbstractController
{
    
    /**
     * va chercher le template Contact
     * @param 
     * @return void
     */

    public function index() :void
    {
        $token = $this->generateToken(25);
        $_SESSION["tokenForAdminHome"] = $token;
        
        $template = "contact";
        $this->render($template, ["token" => $token]);
    }
    
    /**
     * reçoit le formulaire de contact, le vérifie et si tout est bon l'insert dans la base de données
     * sinon renvoie un tableau d'erreurs
     * @param $post
     * @return void
     */
    
    public function sentMessage(array $post) :void
    {
        if(isset($_POST))
        {
            $errors = [];
            $validation = "";
            
            $contactToken = trim($post["contactToken"]);
            
            if($contactToken !== $_SESSION["tokenForAdminHome"])
            {
                $errors[] = "une erreur s'est produite lors de l'envoi du formulaire";
            }
            
            $name = $this->clean_input($_POST["name"]);
            if($name === "")
            {
                $errors[] = "Veuillez rentrer votre nom";
            }
            
            $firstName = $this->clean_input($_POST["first_name"]);
            if($firstName === "")
            {
                $errors[] = "Veuillez rentrer votre prénom";
            }
            
            $email = $this->clean_input($_POST["email"]);
            if($email === "")
            {
                $errors[] = "Veuillez rentrer votre email";
            }
            
            $inputTel = $this->clean_input($_POST["tel"]);
            $tel = intval($inputTel);
            if($inputTel === "")
            {
                $errors[] = "Veuillez rentrer votre numéro de téléphone";
            }

            $message = $this->clean_input($_POST["message"]);
            if($message === "")
            {
                $errors[] = "Veuillez écrire un message";
            }
            
            $contact = [
                "name" => $name,
                "first_name" => $firstName,
                "email" => $email,
                "tel" => $tel,
                "message" => $message
                ];

            if($errors === [])
            {
                $sentMessage = new Contact(null, $name, $firstName, $email, $tel, $message);
                $this->ctm->createContact($sentMessage);
                $validation = "Nous avons bien reçu votre message et vous répondrons dans les meilleurs délais";
                $template = "contact";
                $this->render($template, ["validation" => $validation]);
            }
            else
            {
                $template = "contact";
                $this->render($template, ["errors" => $errors, "contact" => $contact, "token" => $contactToken]);
            }
        }
    }
}