<?php

include "connectionDB.php";
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
if (!$_SESSION['id']) {
    header("Location:login.php");
}

echo '<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>';

echo "<div class='container fs-4'  >";
echo "<h1 class='d-flex justify-content-center pt-3 mb-5'>  <b>All users</b>  </h1>";


try {


    $db = new Database('localhost', 'phplabs', 'root', '12345');
    $conn = $db->connect();


    if ($conn) {

        $loginedUser = $db->selectUser('users', "id",$_SESSION["id"]);


        echo "Welcome {$loginedUser["FirstName"]}";
        echo "<a class='btn btn-primary ms-3' href='logout.php'>Logout</a>";


        $users = $db->select('users');

        echo "<table class='table'> <tr> <th> id</th>
        <th> FirstName </th>  <th> LastName </th>
        <th> Email </th>  <th> Gender </th> <th> username </th> <th> department </th> <th> address </th>
        <th> country </th> <th> skills </th> <th> image </th>
        <th> Edit </th> <th> Delete</th>
        </tr>";

        foreach ($users as $user) {
            echo '<tr>';
            foreach ($user as $key => $data) {
                if ($key === "image") {
                    echo "<td><img width='50' src='{$data}'></td>";
                } else if ($key === "password") {

                } else {
                    echo "<td> {$data}</td>";
                }

            }

            echo " <td> <a class='btn btn-warning' href='newFormUpdate.php?id={$user["id"]}'> Edit</a></td>
            <td> <a class='btn btn-danger' href='deleteuser.php?id={$user["id"]}'> Delete</a></td>
 
        </tr>";
        }

        echo "</table>";


    } else {
        header("Location:login.php?message=connection error");
    }


} catch (Exception $e) {
    echo $e->getMessage();
}


?>

<a href="register.php" class="btn btn-primary">Add new user </a>
