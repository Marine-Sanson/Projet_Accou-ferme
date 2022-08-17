<?php

abstract class AbstractController
{
    protected BasketManager $bm;
    protected CategoryManager $cm;
    protected MediaManager $mm;
    protected NewsManager $nm;
    protected ProductManager $pm;
    protected RecipeManager $rm;
    protected UserManager $um;
    protected VarietyManager $vm;

// fonction qui initialise chacun des managers de façon à les rendre accessibles ensuite
    public function init(BasketManager $bm, CategoryManager $cm, MediaManager $mm, NewsManager $nm, ProductManager $pm, RecipeManager $rm, UserManager $um, VarietyManager $vm)
    {
        $this->bm = $bm;
        $this->cm = $cm;
        $this->mm = $mm;
        $this->nm = $nm;
        $this->pm = $pm;
        $this->rm = $rm;
        $this->um = $um;
        $this->vm = $vm;
    }

    protected function render(string $template, array $data = null){
        
        $data = $data;
        require "templates/layout.phtml";

    }
    
}