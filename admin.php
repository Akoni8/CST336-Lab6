<?php
session_start();

if (!isset($_SESSION['username'])) {  //checks whether the admin is logged in
    header("Location: index.php");
}

function userList(){
include 'databaseConnection.php';
$dbConn = getDatabaseConnection("heroku_ec49987c2231ba0");
  
  $sql = "SELECT *
          FROM User";
  $stmt = $dbConn->prepare($sql);
  $stmt->execute();
  $records = $stmt->fetchAll(PDO::FETCH_ASSOC);
   
  //print_r($records);
  return $records;
    
}

?>

<!DOCTYPE html>
<html>
    <head>
        <title>Admin Main Page </title>
        <link rel="stylesheet" href="styles.css" type="text/css" />
        <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
        <script>
            function confirmDelete() {
                return confirm("Are you sure you want to delete this user?");
            }
        </script>
    </head>
    <body>
        <div id="container">
            <h1> Admin Main </h1>
            <h2> Welcome <?=$_SESSION['adminName']?>!</h2>
            
          
            
            <form action="addUser.php">
                <input type="submit" value="Add new user" />
            </form>
            <br />
            <form action="logout.php">
                <input type="submit" value="Logout!" />
            </form>
            
            <?php
                 $users = userList();
                 foreach($users as $user) {
                     echo $user['firstName'] . " " . $user['lastName'] . "<br />";
                     echo "[<a href='updateUser.php?userId=".$user['id']."'> Update </a>] <br />";
                     echo "[<a onclick='return confirmDelete()' href='deleteUser.php?userId=".$user['id']."'> Delete </a>] <br />";
                 }
             ?>
        </div>
    </body>
</html>