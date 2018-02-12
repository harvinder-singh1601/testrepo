<?php
session_start();
require_once 'dbconnect.php';
include_once 'track.php';

if (!isset($_SESSION['userSession'])) {
	header("Location: login.php");
} else if (isset($_SESSION['userSession'])!="") {
	header("Location: index.php");
}

if (isset($_GET['logout'])) {

	$user_id= $_SESSION['userSession'];
 	 $country =  $array['geobytescountry'];
 $zone= $array['geobytestimezone'];
 $ip = $array['geobytesipaddress'];
 $sql = "INSERT INTO tracking_user (user_id, ip, location,timezone,activity)
VALUES (".$user_id.", '".$ip."','".$country."', '".$zone."',2)";

if ($DBcon->query($sql) === TRUE) {
    echo "New record created successfully";
} else {
    echo "Error: " . $sql . "<br>" . $DBcon->error;
}

	session_destroy();
	unset($_SESSION['userSession']);
	
	header("Location: login.php");
}


?>

