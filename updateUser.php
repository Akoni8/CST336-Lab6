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
    //print_r($record);
    
    return $record;

}


 if (isset($_GET['updateUser'])) { //checks whether admin has submitted form.
     
     //echo "Form has been submitted!";
     
     $sql = "UPDATE User
             SET firstName = :fName,
                 lastName  = :lName,
                 email = :email,
                 phone = :phone,
                 role = :role
             WHERE id = :id";
     $np = array();
     
     $np[':id'] = $_GET['userId'];
     $np[':fName'] = $_GET['firstName'];
     $np[':lName'] = $_GET['lastName'];
     $np[':email'] = $_GET['email'];
     $np[':phone'] = $_GET['phone'];
     $np[':role'] = $_GET['role'];
     //$np[':deptId'] = $_GET['deptId'];
     
     $stmt = $dbConn->prepare($sql);
     $stmt->execute($np);
     
     echo "<span class='update'>Record has been updated!</span>";
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
                    <option value="Staff"  <?=($userInfo['role']=='Staff' || $userInfo['role']=='staff')?" selected":"" ?>  >Staff</option>
                    <option value="Student" <?=($userInfo['role']=='Student' || $userInfo['role']=='student')?" selected":"" ?>  >Student</option>
                    <option value="Faculty" <?=($userInfo['role']=='Faculty' || $userInfo['role']=='faculty')?" selected":"" ?>>Faculty</option>
                </select>
                <br />
                Department: 
                <select name="deptId">
                    <option value="" > - Select One - </option>
                    <option value="Computer Science"  <?=($userInfo['deptId']=='1')?" selected":"" ?>  > Computer Science</option>
                    <option value="Statistics"  <?=($userInfo['deptId']=='2')?" selected":"" ?>  >Statistics</option>
                    <option value="Design"  <?=($userInfo['deptId']=='3')?" selected":"" ?>  >Design</option>
                    <option value="Economics"  <?=($userInfo['deptId']=='4')?" selected":"" ?>  >Economics</option>
                    <option value="Drama"  <?=($userInfo['deptId']=='5')?" selected":"" ?>  >Drama</option>
                    <option value="Biology"  <?=($userInfo['deptId']=='6')?" selected":"" ?>  >Biology</option>
                </select>
                    <br />
                    <input type="submit" value="Update User" name="updateUser">
            </form>
            <a class="link" href="admin.php ">Back to Admin Page</a>
        </div>
    </body>
</html>