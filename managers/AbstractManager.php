<?php

abstract class AbstractManager
{
    protected PDO $db;
    
    // fonction qui initialise la connexion à la DB
    function __construct()
    {
        $this->db = new PDO(
        'mysql:host=localhost;bdname=marinesanson_projet_accou-ferme;charset=utf8',
        'root',
        'root'
        );
    }
    
    // getter de la DB
    public function getDb()
    {
        return $this->db;
    }
}

?>