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
            $name = $this->test_input($_POST["name"]);
            $firstName = $this->test_input($_POST["first_name"]);
            $email = $this->test_input($_POST["email"]);
            $inputTel = $this->test_input($_POST["tel"]);
            $tel = intval($inputTel);
            $message = $this->test_input($_POST["message"]);

            $sentMessage = new Contact(null, $name, $firstName, $email, $tel, $message);
        
            $this->ctm->createContact($sentMessage);
        
            $template = "sent";
            $this->render($template);

        }
    }
    
}