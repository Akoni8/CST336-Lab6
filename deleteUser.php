<?php

include 'databaseConnection.php';
$dbConn = getDatabaseConnection("heroku_ec49987c2231ba0");

    $sql = "DELETE FROM user
            WHERE id = " .$_GET['userId'];
    
    $stmt = $dbConn->prepare($sql);
    $stmt->execute();
  
  header("Location: admin.php");
    
?>