<?php
/**
 * @author : Gaellan
 * @Marine Sanson
 */

class AboutController extends AbstractController
{
    public function index() :void
    {
        $template="about";

        $this->render($template);
    }
}
