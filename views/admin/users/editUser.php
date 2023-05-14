<?php
echo '
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
';

include($_SERVER["DOCUMENT_ROOT"] . "/CafeteriaSystem/views/layouts/navbar.php");

error_reporting(E_ERROR | E_PARSE);
## Get the old data
if (isset($_GET['id'])) {
    $id = $_GET['id'];
//    include($_SERVER["DOCUMENT_ROOT"] . "/CafeteriaSystem/controllers/user_controller.php");

    $UserController = new UserController();
    $row = $UserController->getUserById($id);
} else {
    var_dump("HEma");
}

if (isset($_GET["errors"])) {
    $errors = json_decode($_GET["errors"], true);
} else {
    $errors = [];
}

include($_SERVER["DOCUMENT_ROOT"] . "/CafeteriaSystem/controllers/room_controller.php");
$roomController = new roomController();
$rooms = $roomController->index();

?>

<head>
    <meta charset="UTF-8">
    <title>Edit form </title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="css/bootstrap.css" rel="stylesheet"/>
    <link href="css/font-awesome.css" rel="stylesheet"/>
    <link rel="stylesheet" href="http://localhost/cafeITI/public/styles/editUser.css">
</head>

<body>
<div class="container">

    <form action="/CafeteriaSystem/controllers/admin/userActions/addUserValid.php?method=edit&id=<?php echo $row['id'] ?>"
          method="post" enctype="multipart/form-data" style="margin: auto;">
        <p class="text-center h1 fw-bold mb-5 mx-1 mx-md-4 mt-4">Update User <?php echo $row['username']; ?></p>
        <div class="form-row">
            <div class="form-group col-lg-6">
                <div class="input-group mt-2">
            <span class="input-group-prepend input-group-text">
              <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                   class="bi bi-person-circle" viewBox="0 0 16 16">
                <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0z"/>
                <path fill-rule="evenodd"
                      d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8zm8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1z"/>
              </svg>
            </span>
                    <input type="text" class="form-control" name="username" placeholder="username"
                           value="<?php echo $row['username']; ?>">
                </div>
                <span class="text-danger"> <?php if (isset($errors['username'])) echo $errors['username']; ?></span>
            </div>
            <div class="form-group col-lg-6">
                <div class="input-group mt-2">
            <span class="input-group-prepend input-group-text">
              <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                   class="bi bi-envelope-at" viewBox="0 0 16 16">
                <path d="M2 2a2 2 0 0 0-2 2v8.01A2 2 0 0 0 2 14h5.5a.5.5 0 0 0 0-1H2a1 1 0 0 1-.966-.741l5.64-3.471L8 9.583l7-4.2V8.5a.5.5 0 0 0 1 0V4a2 2 0 0 0-2-2H2Zm3.708 6.208L1 11.105V5.383l4.708 2.825ZM1 4.217V4a1 1 0 0 1 1-1h12a1 1 0 0 1 1 1v.217l-7 4.2-7-4.2Z"/>
                <path d="M14.247 14.269c1.01 0 1.587-.857 1.587-2.025v-.21C15.834 10.43 14.64 9 12.52 9h-.035C10.42 9 9 10.36 9 12.432v.214C9 14.82 10.438 16 12.358 16h.044c.594 0 1.018-.074 1.237-.175v-.73c-.245.11-.673.18-1.18.18h-.044c-1.334 0-2.571-.788-2.571-2.655v-.157c0-1.657 1.058-2.724 2.64-2.724h.04c1.535 0 2.484 1.05 2.484 2.326v.118c0 .975-.324 1.39-.639 1.39-.232 0-.41-.148-.41-.42v-2.19h-.906v.569h-.03c-.084-.298-.368-.63-.954-.63-.778 0-1.259.555-1.259 1.4v.528c0 .892.49 1.434 1.26 1.434.471 0 .896-.227 1.014-.643h.043c.118.42.617.648 1.12.648Zm-2.453-1.588v-.227c0-.546.227-.791.573-.791.297 0 .572.192.572.708v.367c0 .573-.253.744-.564.744-.354 0-.581-.215-.581-.8Z"/>
              </svg>
            </span>
                    <input type="email" class="form-control" name="email" placeholder="email"
                           value="<?php echo $row['email']; ?>">
                </div>
                <span class="text-danger"> <?php if (isset($errors['email'])) echo $errors['email']; ?></span>
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-lg-6">
                <div class="input-group mt-2">
            <span class="input-group-prepend input-group-text">
              <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                   class="bi bi-person-fill-lock" viewBox="0 0 16 16">
                <path d="M11 5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm-9 8c0 1 1 1 1 1h5v-1a1.9 1.9 0 0 1 .01-.2 4.49 4.49 0 0 1 1.534-3.693C9.077 9.038 8.564 9 8 9c-5 0-6 3-6 4Zm7 0a1 1 0 0 1 1-1v-1a2 2 0 1 1 4 0v1a1 1 0 0 1 1 1v2a1 1 0 0 1-1 1h-4a1 1 0 0 1-1-1v-2Zm3-3a1 1 0 0 0-1 1v1h2v-1a1 1 0 0 0-1-1Z"/>
              </svg>
            </span>
                    <input type="password" class="form-control" name="password" placeholder="password"
                           value="<?php echo $row['password']; ?>" required/>
                </div>
                <span class="text-danger"> <?php if (isset($errors['password'])) echo $errors['password']; ?></span>
            </div>
            <div class="form-group col-lg-6">
                <div class="input-group mt-2">
            <span class="input-group-prepend input-group-text">
              <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                   class="bi bi-person-fill-lock" viewBox="0 0 16 16">
                <path d="M11 5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm-9 8c0 1 1 1 1 1h5v-1a1.9 1.9 0 0 1 .01-.2 4.49 4.49 0 0 1 1.534-3.693C9.077 9.038 8.564 9 8 9c-5 0-6 3-6 4Zm7 0a1 1 0 0 1 1-1v-1a2 2 0 1 1 4 0v1a1 1 0 0 1 1 1v2a1 1 0 0 1-1 1h-4a1 1 0 0 1-1-1v-2Zm3-3a1 1 0 0 0-1 1v1h2v-1a1 1 0 0 0-1-1Z"/>
              </svg>
            </span>
                    <input type="password" class="form-control" name="confirm" placeholder="confirm password"  value="<?php echo $row['password']; ?>" required/>
                </div>
                <span class="text-danger"> <?php if (isset($errors['confirm'])) echo $errors['confirm']; ?></span>
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-lg-6" style="margin-top:8px;">
                <select class="form-select" name="room_id">
                    <option value="0">Select Room Number</option>
                    <?php
                    foreach ($rooms as $room) {
                        echo "<option value='{$room["id"]}' id='{$room['id']}' " . ($row['room_id'] == $room['id'] ? "selected" : "") . ">{$room['name']}</option>";
                    }
                    ?>
                </select>
                <div class="text-danger"> <?php if (isset($errors['room_id'])) echo $errors['room_id']; ?></div>
            </div>
            <div class="form-group col-lg-6">
                <div class="input-group mt-2">
            <span class="input-group-prepend input-group-text">
              <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                   class="bi bi-person-circle" viewBox="0 0 16 16">
                <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0z"/>
                <path fill-rule="evenodd"
                      d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8zm8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1z"/>
              </svg>
            </span>
                    <input type="number" class="form-control" name="ext_attr" placeholder="Ext"
                           value="<?php echo $row['ext_attr']; ?>">
                </div>
                <span class="text-danger"> <?php if (isset($errors['ext_attr'])) echo $errors['ext_attr']; ?></span>
            </div>
        </div>
        <div class="form-group">
            <label for="is_admin">User Role</label>
            <select name="is_admin" id="is_admin" class="form-select">
                <option value="0" <?php if ($row['is_admin'] == 0) {
                    echo 'selected';
                } ?>>User
                </option>
                <option value="1" <?php if ($row['is_admin'] == 1) {
                    echo 'selected';
                } ?>>Admin
                </option>
            </select>
        </div>
        <div class="form-row">
            <div class="form-group col-lg-12">
                <div class="mb-3">

                    <input class="form-control" type="file" id="formFile" name="img">
                </div>
            </div>
        </div>
        <br>
        <div>
            <button type="submit" name="sub" value="submit" class="btn btn-info">Save</button>
        </div>
    </form>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p"
        crossorigin="anonymous"></script>