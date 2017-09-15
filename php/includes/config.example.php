<?php

if(count(get_included_files()) === 1) exit("Direct access not permitted.");

// You should duplicate this file as config.php and save it in the same folder. Set the values to constants to their appropriate values

define('DB_HOST', 'localhost');
define('DB_PORT', 3306);
define('DB_USER', 'example');
define('DB_PASS', 'example');
define('DB_NAME', 'example');
define('DB_TYPE', 'mysql');  // mysql or pgsql
