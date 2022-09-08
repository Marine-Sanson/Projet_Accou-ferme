<?php

abstract class AbstractController
{
    protected OrderManager $om;
    protected CategoryManager $cm;
    protected MediaManager $mm;
    protected NewsManager $nm;
    protected ProductManager $pm;
    protected RecipeManager $rm;
    protected AdminManager $am;
    protected VarietyManager $vm;

// fonction qui initialise chacun des managers de façon à les rendre accessibles ensuite
    public function init(OrderManager $om, CategoryManager $cm, MediaManager $mm, NewsManager $nm, ProductManager $pm, RecipeManager $rm, AdminManager $am, VarietyManager $vm)
    {
        $this->om = $om;
        $this->cm = $cm;
        $this->mm = $mm;
        $this->nm = $nm;
        $this->pm = $pm;
        $this->rm = $rm;
        $this->am = $am;
        $this->vm = $vm;
    }

    protected function renderPartial(string $template, array $values)
    {
        $data = $values;
        
        require "templates/".$template.".phtml";
    }
    
    protected function render(string $template, array $data = null){
        
        $data = $data;
        require "templates/layout.phtml";

    }
    
    protected function basketToArray(StdClass $data) :array
    {
        $tmp = (array) $data;
        $items = [];
        
        foreach($tmp["items"] as $key => $item)
        {
            $tmpItem = (array) $item;
            $items[] = $tmpItem;
        }
        
        $tmp["items"] = $items;
        return $tmp;
    }

}