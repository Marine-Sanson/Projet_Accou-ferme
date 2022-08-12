<?php

abstract class AbstractController
{
    protected function render(string $template, array $data = null){
        
        require "templates/layout.phtml";

    }
}