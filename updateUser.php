<?php

include 'databaseConnection.php';
$dbConn = getDatabaseConnection("heroku_ec49987c2231ba0");
  
function getUserInfo() {
    global $dbConn;
    
    $sql = "SELECT * 
            FROM User
            WHERE id = " . $_GET['userId']; 
    
    $stmt = $dbConn->prepare($sql);
    $stmt->execute();
    $record = $stmt->fetch(PDO::FETCH_ASSOC);
    print_r($record);
    
    return $record;

}


 if (isset($_GET['updateUser'])) { //checks whether admin has submitted form.
     
     //echo "Form has been submitted!";
     
     $sql = "UPDATE User
             SET firstName = :fName,
                 lastName  = :lName
             WHERE id = :id";
     $np = array();
     
     $np[':fName'] = $_GET['firstName'];
     $np[':lName'] = $_GET['lastName'];
     $np[':id'] = $_GET['userId'];
     
     $stmt = $dbConn->prepare($sql);
     $stmt->execute($np);
     
     echo "Record has been updated!";
     
 }


 if (isset($_GET['userId'])) {
     
    $userInfo = getUserInfo(); 
     
     
 }



?>


<!DOCTYPE html>
<html>
    <head>
        <title> Update User </title>
        <link rel="stylesheet" href="styles.css" type="text/css" />
        <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    </head>
    <body>
        <div id="container">
            <h1> Tech Checkout System: Updating User's Info </h1>
            <form method="GET">
                <input type="hidden" name="userId" value="<?=$userInfo['id']?>" />
                First Name:<input type="text" name="firstName" value="<?=$userInfo['firstName']?>" />
                <br />
                Last Name:<input type="text" name="lastName" value="<?=$userInfo['lastName']?>"/>
                <br/>
                Email: <input type= "email" name ="email" value="<?=$userInfo['email']?>"/>
                <br/>
                Phone Number: <input type ="text" name= "phone" value="<?=$userInfo['phone']?>"/>
                <br />
               Role: 
               <select name="role">
                    <option value=""> - Select One - </option>
                    <option value="Staff"  <?=($userInfo['role']=='Staff')?" selected":"" ?>  >Staff</option>
                    <option value="Student" <?=($userInfo['role']=='Student')?" selected":"" ?>  >Student</option>
                    <option value="Faculty" <?=($userInfo['role']=='Faculty')?" selected":"" ?>>Faculty</option>
                </select>
                <br />
                Department: 
                <select name="deptId">
                    <option value=""  > Select One </option>
                      <?php
                        $departments = departmentList();
                        
                        foreach($departments as $department) {
                           echo "<option value='".$department['id']."'> " . $department['name']  . "</option>";  
                        }
                    ?>
                </select>
                <input type="submit" value="Update User" name="updateUser">
                
            </form>
        </div>
    </body>
</html>