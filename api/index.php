this is a test file
<?php
include_once '../config/database.php';
include_once '../config/database_old.php';

$start = microtime(true);
# the new way
$i = 0;
while($i<100){


$database = Database::getInstance()->getConnection();
$i++;
}
$new_time = microtime(true) - $start;

$start = microtime(true);
# the old way
$i = 0;
while($i < 100){

$old_database = new Database_Old();
$old_database_connection = $old_database->getConnection();
$old_time = microtime(true) - $start;
$i++;
}

printf('New connection takes==> %s ms' .PHP_EQL, $new_time * 1000);
printf('New connection takes==> %s ms' .PHP_EQL, $old_time * 1000);
printf('You saved %s ms' .PHP_EQL, ($old_time - $new_time) * 1000);
printf('New connection takes %s%% of old connection' .PHP_EQL, ($new_time/$old_time) * 100);