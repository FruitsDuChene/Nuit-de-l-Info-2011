<?php

define('TIME_ZONE', 'Europe/Paris');
setlocale (LC_ALL, 'fr_FR.utf8','fr_FR', 'fr'); 

// Use of url rewriting
define('URL_REWRITING', 'app');
//define('URL_REWRITING', false);

define('DEBUG',true);

define('DB_DSN_PDO', 'mysql:host=localhost;dbname=nuitinfo');
define('DB_USER', 'root');
define('DB_PASSWORD', '');

define('APP_ID', '103910166392941');
define('APP_SECRET', 'e2abcb42986f48f8f6765c5786a04e0d');
?>
