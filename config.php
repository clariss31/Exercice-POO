<?php

// Connexion à la base de données
class DBConnect {
    public function getPDO() {
        return new PDO(
            'mysql:host=localhost;dbname=poo;charset=utf8', 'root', ''
        );
    }
}