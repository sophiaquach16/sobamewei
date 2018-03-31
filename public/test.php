<?php
/**
 * Created by PhpStorm.
 * User: Mel
 * Date: 2018-03-30
 * Time: 12:22 AM
 */

require_once __DIR__ . '/../vendor/autoload.php';

$user = array(
    'first_name' => 'MongoDB',
    'last_name' => 'Fan',
    'tags' => array('developer','user')
);
// Configuration
$dbhost = 'localhost';
$dbname = 'test';

// Connect to test database
$m = new MongoDB\Client("mongodb://127.0.0.1:27017");
if($m != null) echo "connected successfully";
$db = $m->$dbname;

// Get the users collection
$c_users = $db->users;

// Insert this new document into the users collection
$c_users->insertOne($user);

?>


