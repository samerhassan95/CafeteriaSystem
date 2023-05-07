<?php
echo '
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>';

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <title>Document</title>
</head>
<style>
  .logout-btn {
    background-color: #212529;
    border-color: #e59285;
    color: white;
    font-size: 1rem;
    font-weight: 500;
    padding: 0.5rem 1rem;
    border-radius: 0.25rem;
    transition: all 0.2s ease-in-out;
    margin-left: 6%;
  }

  .logout-btn:hover {
    background-color: #c05d4c;
    border-color: #c05d4c;
  }

  .navbar-dark .navbar-nav .nav-link {
    color: white;
  }

  .navbar-dark .navbar-nav .nav-link:hover {
    color: #e59285;
  }

  .nav-link1 {
    color: white;
  }

  .nav-logo {
    width: 22%;
    margin-left: 30px;
    margin-bottom: 5%
  }

  .navbar-nav .account-icon a {
    display: flex;
    align-items: center;
    color: white;
    text-decoration: none;
    position: relative;
    left: 8.8rem;
  }

  .navbar-nav .account-icon a:hover {
    color: #e59285;
  }

  .navbar-nav .account-icon i {
    font-size: 1.5rem;
    margin-right: 0.5rem;
    position: relative;

  }


  .collapse {
    margin-right: 20%
  }

  .navbar-nav .account-icon {
    display: flex;
    align-items: center;

  }

  .logout {
    position: relative;
    left: 8.3rem;
  }
</style>

<body>
  <nav class="navbar navbar-expand-lg bg-light">
    <div class="container-fluid ">
      <a class="navbar-brand" href="#">
        <img class="nav-logo" src="http://localhost/cafeITI/public/images/logo2.png" alt="Logo">
<!--        <img class="nav-logo" src="public/images/logo2.png" alt="Logo">-->
      </a>
      <button class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#navbarNav">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ms-md-auto gap-2 justify-content-center">
          <li class="nav-item dropdown rounded">
            <a class="nav-link1 nav-link" href="http://localhost/cafeITI/views/auth/admin/adminPage.php"><i class="bi bi-house-fill me-2"></i>Home</a>
          </li>
          <li class="nav-item dropdown rounded">
            <a class="nav-link2 nav-link" href=""><i class="bi bi-card-image me-2"></i>Products</a>
          </li>
          <li class="nav-item dropdown rounded">
            <a class="nav-link3 nav-link" href="http://localhost/cafeITI/views/auth/admin/users/displayUsers.php" id="shopDropdown"><i class="bi bi-cart4 me-2"></i>Users</a>
          </li>
            <li class="nav-item dropdown rounded">
                <a class="nav-link3 nav-link" href="http://localhost/cafeITI/views/auth/admin/orders/displayOrders.php" id="shopDropdown"><i class="bi bi-cart4 me-2"></i>Orders</a>
            </li>
<!--          <li class="nav-item dropdown rounded">-->
<!--            <a class="nav-link4 nav-link dropdown-toggle" href="http://localhost/cafeITI/views/auth/admin/users/" id="pagesDropdown" data-bs-toggle="dropdown"><i class="bi bi-file-earmark-text-fill me-2"></i>Manual Order</a>-->
<!--          </li>-->
          <li class="nav-item rounded">
            <a class="nav-link5 nav-link" href="#"><i class="bi bi-people-fill me-2"></i>Checks</a>
          </li>
          <li class="nav-item rounded">
            <a class="nav-link6 nav-link" href="#"><i class="bi bi-telephone-fill me-2"></i>Contact</a>
          </li>
          <li class="nav-item dropdown rounded">
          <li class="account-icon">
            <a href="#">
              <i class="fa fa-user"></i>
              <?php if (isset($_SESSION["admin"])) {
                echo "Admin";
              } else {
                echo "User";
              } ?>
            </a>
          </li>
          <a href="../logout.php" class="logout btn btn-primary logout-btn">Logout</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>
</body>