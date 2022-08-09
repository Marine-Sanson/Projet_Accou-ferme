<?php

class DBConnect
{
    private PDO $db;
    
    function __construct()
    {
        $this->db = new PDO(
        'mysql:host=db.3wa.io;port=3306;dbname=marinesanson_projet_accou-ferme;charset=UTF8mb4',
        'marinesanson',
        '5f7c3646a479ca2518aadd0dbe6ac514'
        );
    }
}

?>