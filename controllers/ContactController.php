<?php

require "./models/Contact.php";

class ContactController extends AbstractController
{
    public function index() :void
    {
        $template = "contact";
        $this->render($template);
    }
    
    public function sentMessage(array $post) :void
    {
        if(isset($_POST))
        {
            $errors = [];
            $validation = [];
            
            $name = $this->test_input($_POST["name"]);
            if($name === "")
            {
                $errors[] = "Veuillez renter votre nom";
            }
            
            $firstName = $this->test_input($_POST["first_name"]);
            if($firstName === "")
            {
                $errors[] = "Veuillez renter votre prénom";
            }
            
            $email = $this->test_input($_POST["email"]);
            
            $inputTel = $this->test_input($_POST["tel"]);
            $tel = intval($inputTel);
            if($inputTel === "")
            {
                $errors[] = "Veuillez renter votre numéro de téléphone";
            }

            $message = $this->test_input($_POST["message"]);
            if($message === "")
            {
                $errors[] = "Veuillez écrire un message";
            }
            
            $contact = [
                "name" => $name,
                "first_name" => $firstName,
                "email" => $email,
                "tel" => $inputTel,
                "message" => $message
                ];

            if($errors === [])
            {
                $sentMessage = new Contact(null, $name, $firstName, $email, $tel, $message);
                $this->ctm->createContact($sentMessage);
                $validation[] = "Nous avons bien reçu votre message et vous répondrons dans les meilleurs délais";
                $template = "contact";
                $this->render($template, ["validation" => $validation]);
            }
            else
            {
                $template = "contact";
                $this->render($template, ["errors" => $errors, "contact" => $contact]);
            }
        }
    }
    
}