<?php

include('../../controllers/user_controller.php');
$userController = new UserController();
$id = $_GET['id'];
$result = $userController->update($id);
if($result['status']== 'success'){
    header("location:../../views/auth/admin/users/displayUsers.php");
}
else {
    if(isset($result['formData'])){
        $redirect_url = "Location:../../views/auth/admin/users/editUser.php?id={$id}&errors={$result['formData']}";
        header($redirect_url);
    }
}

//http://localhost/cafeITI/controllers/admin/edit.php?id=1&errors={%22confirm%22:%22Password%20isn%27t%20matched%22}

//http://localhost/cafeITI/views/auth/admin/users/edit.php?id=1&errors={%22confirm%22:%22Password%20isn%27t%20matched%22}