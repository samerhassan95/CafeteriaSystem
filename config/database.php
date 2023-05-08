<?php

define("DB_HOST", "localhost:3306");
define("DB_USER", "samer");
define("DB_PASS", "samerhassan11");
define("DB_DATABASE", "cafe");
return new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_DATABASE, DB_USER, DB_PASS);
