<?php

define("DB_HOST", "localhost:3906");
define("DB_USER", "root");
define("DB_PASS", "");
define("DB_DATABASE", "php_cafe");        
return new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_DATABASE, DB_USER, DB_PASS);