<?php
function getDatabaseConnection($dbname){
    $host = 'localhost';
    $username = "root";
    $password = "Maxsan08";
    
    //Creates a database connection
    $dbConn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    
    // Setting Errorhandling to Exception
    $dbConn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
    
    return $dbConn;    
}