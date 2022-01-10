<?php
    define("DB_VERT", "localhost");
    define("DB_BRUKER", "root");
    define("DB_PASS", "");
    define("DB_NAVN", "webapp");

    try{
        //Forsøker å koble til database
        $pdo = new PDO("mysql:host=" . DB_VERT . ";dbname=" . DB_NAVN, DB_BRUKER, DB_PASS);
        //echo "Tilkobling til database OK";
    }catch (PDOException $e) {
        echo "Feil ved tilkobling til databasen: " . $e->getMessage();
    }
