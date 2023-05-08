<?php
define("DB_HOST", "localhost:3306");
define("DB_USER", "root");
define("DB_PASS", "msn3459900");
define("DB_DATABASE", "cafeteria");
return new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_DATABASE, DB_USER, DB_PASS);
