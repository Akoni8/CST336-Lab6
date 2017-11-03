<?php
session_start();   //starts or resumes a session
function loginProcess() {
    include 'databaseConnection.php';
    $dbConn = getDatabaseConnection("heroku_ec49987c2231ba0");
    
    if (isset($_POST['loginForm'])) {  //checks if form has been submitted
            $username = $_POST['username'];
            $password = sha1($_POST['password']);
            
            $sql = "SELECT *
                    FROM Admin
                    WHERE username = :username 
                    AND   password = :password ";
            
            $namedParameters = array();
            $namedParameters[':username'] = $username;
            $namedParameters[':password'] = $password;

            $stmt = $dbConn->prepare($sql);
            $stmt->execute($namedParameters);
            $record = $stmt->fetch();
            
            if (empty($record)) {
                echo "<p class ='wrong'>Wrong Username or Password </p>";
            } 
            else {
               $_SESSION['username'] = $record['username'];
               $_SESSION['adminName'] = $record['firstName'] . "  " . $record['lastName'];
               header("Location: admin.php"); //redirecting to admin.php
            }
    }
}

?>

<!DOCTYPE html>
<html>
    <head>
        <title> Admin Login  </title>
        <link rel="stylesheet" href="styles.css" type="text/css" />
        <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    </head>
    <body>
        <div id="container">
            <h1> Admin Login </h1>
            <form method="post">
                Username: <input type="text" name="username"/> <br />
                Password: <input type="password" name="password" /> <br />
                <input type="submit" name="loginForm" value="Login!"/>
            </form>
        </div>
            <br />
            <?=loginProcess()?>
    </body>
</html>