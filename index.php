<?php
$db = require "config/database.php";

if ($db) {
    var_dump("data connected");
}

exit;

header('Location:public/lab5/register.php');