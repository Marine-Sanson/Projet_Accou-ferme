<?php

class AdminContactController extends AbstractController
{
    public function index() :void
    {
        if($_SESSION["connectAdmin"] === true)
        {
            $messages = $this->ctm->getAllPendingMessages();

            $this->render("adminContacts", ["messages" => $messages]);
        }
        else
        {
            $this->render("admin");
        }
    }
    
    public function closeMessage(array $post) :void
    {
        $id = intval($post["answered_id"]);
        $this->ctm->answeredMessage($id);

        $messages = $this->ctm->getAllPendingMessages();
        $this->render("adminContacts", ["messages" => $messages]);
    }
    
}