<?php

function getDatabaseConnection($dbname){
    $host = 'us-cdbr-iron-east-05.cleardb.net';
    $username = "b4b2c44328820e";
    $password = "27966c6b";
    
    //Creates a database connection
    $dbConn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    
    // Setting Errorhandling to Exception
    $dbConn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
    
    return $dbConn;    
}



?>