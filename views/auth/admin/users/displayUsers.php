<?php
echo '
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>';

// $db = require_once('../../config/database.php');

require($_SERVER["DOCUMENT_ROOT"] . "/cafeITI/views/navbar.php");

require($_SERVER["DOCUMENT_ROOT"] . "/cafeITI/controllers/user_controller.php");

$UserController = new UserController();
$users = $UserController->index();


// if ($db) {
//   $query = 'SELECT * FROM `cafeteria`.`users`;';
//   $stmt = $db->prepare($query);
//   $result = $stmt->execute();
//   if ($result) {
//     $users = $stmt->fetchAll(PDO::FETCH_OBJ);
//   }
// }

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Cafeteria Users</title>
</head>
<style>
  h1 {
    text-align: center;
  }

  .container {
    margin-top: 40px;
  }

  .button {
    position: relative;
    right: 14rem;
    top: 0.4rem;
  }
</style>
<script>
  // Edit in the navbar which we included
  // document.querySelector('.nav-logo').src = '../../public/images/logo4.png';
  // document.querySelector('.nav-link1').href = '../home.php'; // Home
  // document.querySelector('.nav-link2').href = '#'; // Products
  // document.querySelector('.nav-link3').href = './displayUsers.php'; // Users
  // document.querySelector('.nav-link4').href = '#'; // Manual Order
  // document.querySelector('.nav-link5').href = '#'; // Checks
  // document.querySelector('.nav-link5').href = '#'; // Contact
</script>

<body>
  <div class="container">
    <h1 class="text-center bg-dark text-white py-3 fw-bold"> <a href="addUser.php" class="button btn btn-primary mb-3">Add User</a>Cafeteria Users Accounts</h1>

    <table class="table table-hover table-dark">
      <thead>
        <tr>
          <th>#</th>
          <th>username</th>

          <th>email</th>
          <th>Image</th>
          <th>Room No</th>
          <th>Exit</th>
          <th>Edit</th>
          <th>Delete</th>

        </tr>
      </thead>
      <tbody>
        <?php foreach ($users as $user) { ?>
          <tr>
            <th><?= $user['id'] ?></th>
            <td><?= $user['username'] ?></td>
            <td><?= $user['email'] ?></td>
            <td><img src="<?= $user['image'] ?>" width="50px" height="50px"></td>
            <td><?= $user['room_id'] ?></td>
            <td><?= $user['ext_attr'] ?></td>

            <td>
              <a href="editUser.php?id=<?= $user['id'] ?>" class="btn btn-primary">Edit</a>

            </td>
            <td>
              <a href="deleteUser.php?id=<?= $user['id'] ?>" class="btn btn-danger">Delete</a>
            </td>
          </tr>
        <?php } ?>
      </tbody>
    </table>
  </div>
</body>

</html>