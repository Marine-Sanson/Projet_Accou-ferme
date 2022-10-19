<?php

class LegalController extends AbstractController
{

    /**
     * va chercher les produits du moment, la dernière info et la dernière recette et les renvoi
     * pour affichage sur la page Home
     *
     * @return void
     */
     
    public function index() :void
    {
        $template = "legal";

        $this->render($template);
    }
}