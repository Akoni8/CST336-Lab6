<?php

include 'databaseConnection.php';
$dbConn = getDatabaseConnection("heroku_ec49987c2231ba0");

    function departmentList(){
      
        global $dbConn;
        
        $sql = "SELECT * FROM Departments ORDER BY name";
        $stmt = $dbConn->prepare($sql);
        $stmt->execute();
        $records = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $records;
    }


if (isset($_GET['addUser'])) {  //the add form has been submitted

    $sql = "INSERT INTO User
             (firstName, lastName, email, role, phone, deptId) 
             VALUES
             (:fName, :lName, :email, :role, :phone, :deptId)";
    $np = array();
    
    $np[':fName'] = $_GET['firstName'];
    $np[':lName'] = $_GET['lastName'];
    $np[':email'] = $_GET['email'];
    $np[':phone'] = $_GET['phone'];
    $np[':role'] = $_GET['role'];
    $np[':deptId'] = $_GET['deptId'];
    
    $stmt=$dbConn->prepare($sql);
    $stmt->execute($np);
    
    echo "<span class='update'd>User was added!</span>";
    
}

?>


<!DOCTYPE html>
<html>
    <head>
        <title>Admin: Add new user</title>
        <link rel="stylesheet" href="styles.css" type="text/css" />
        <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    </head>
    <body>

        <div id="container">
            <h1> Adding New User </h1>
            <h2> Tech Checkout System: Adding a New User </h2>
            <form method="GET">
                First Name:<input type="text" name="firstName" />
                <br />
                Last Name:<input type="text" name="lastName"/>
                <br/>
                Email: <input type= "email" name ="email"/>
                <br/>
                Phone Number: <input type ="text" name= "phone"/>
                <br />
               Role: 
               <select name="role">
                    <option value=""> - Select One - </option>
                    <option value="Staff">Staff</option>
                    <option value="Student">Student</option>
                    <option value="Faculty">Faculty</option>
                </select>
                <br />
                Department: 
                <select name="deptId">
                    <option value="" > Select One </option>
                    
                    <?php
                        $departments = departmentList();
                        
                        foreach($departments as $department) {
                           echo "<option value='".$department['id']."'> " . $department['name']  . "</option>";  
                        }
                    ?>
                </select>
                <br />
                <input type="submit" value="Add User" name="addUser">
            </form>
            <a class="link" href="admin.php ">Back to Admin Page</a>
        </div>
        
    </body>
</html>