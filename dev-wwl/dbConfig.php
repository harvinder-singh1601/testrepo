<?php
//Database credentials
/*$dbHost = 'typit.net';
$dbUsername = 'Howsit_admin';
$dbPassword = '0004edb6700b6';
$dbName = 'Howsit_db';
*/


$dbhost = 'localhost';

 $dbUsername = 'root';

$dbPassword = 'goEDU2018!!';

$dbName = 'winwinlabs_database';

//Connect with the database
$db = new MySQLi($dbHost, $dbUsername, $dbPassword, $dbName);
//Display error if failed to connect
if ($db->connect_errno) {
    printf("Connect failed: %s\n", $db->connect_error);
    exit();
}
function getusername($id)
{
    echo $select="select * from tbl_users where User_ID='".$id."'";
    $select_rs=mysqli_query($db,$select) or die("Cannot Execute Query1".mysqli_error($db));
    $select_row=mysqli_fetch_array($select_rs);
    echo $select_row['username'];
}

//$db=mysqli_connect($dbHost, $dbUsername, $dbPassword, $dbName) or die("cannot connect");
//echo "done";
?>
