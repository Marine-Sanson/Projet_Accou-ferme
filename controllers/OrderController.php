<?php

class OrderController extends AbstractController
{
    public function index(array $post)
    {
        $this->render("_order");
    }
}

?>