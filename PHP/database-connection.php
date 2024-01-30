<?php


// functions for connecting to database

function connectDB(){
    static $connection;
    if(!isset($connection)) {
        $connection = connect();
    }      
    return $connection;
}

function connect() {
    $host = getenv('DB_HOST', true) ?: "database host, like: testi22.treok.io";
    $port = getenv('DB_PORT', true) ?: 3306; 
    $dbname = getenv('DB_NAME', true) ?: "database name"; 
    $user = getenv('DB_USERNAME', true) ?: "database's owners username"; 
    $password = getenv('DB_PASSWORD', true) ?: "database's owners password"; 

    $connectionString = "mysql:host=$host;dbname=$dbname;port=$port;charset=utf8";

    try {       
            $pdo = new PDO($connectionString, $user, $password);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $pdo;
    } catch (PDOException $e){

            //message for error with the database connection
        
            echo "Virhe tietokantayhteydessä: " . $e->getMessage();
            die();
    }
}