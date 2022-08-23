<?php
/**
 * @author : Gaellan
 * @Marine Sanson
 */

class HomeController extends AbstractController
{
    public function index(array $post)
    {
        $this->render("home");
    }
}
