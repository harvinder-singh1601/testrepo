<?php
session_start();
include_once '../../dbconnect.php';
if (!isset($_SESSION['userSession'])) {
  header("Location: login.php");
}
if(!empty($_POST['rating'])){
    $game_id = $_POST['game_id'];
    $ratingNum = 1;
    $ratingPoints = $_POST['rating'];
    	$user_id= $_SESSION['userSession'];
 
        //Insert rating data into the database
        $query = "INSERT INTO user_game_rate (user_id,game_id,rating ) VALUES('".$user_id."','".$game_id."','".$ratingPoints."')";
        $insert = $DBcon->query($query);
		echo $insert;
   
    
    //Fetch rating deatails from database
    $query2 = "SELECT * FROM user_game_rate WHERE game_id = ".$game_id;
    $result = $DBcon->query($query2);
    $ratingRow = $result->fetch_assoc();
  if($ratingRow){
        $ratingRow['status'] = 'ok';
    }else{
        $ratingRow['status'] = 'err';
    }
    //Return json formatted rating data
    echo json_encode($ratingRow);
}
if(!empty($_POST['feedback'])){
    $game_id = $_POST['game_id'];
	 $feedback = $_POST['feedback'];
    	$user_id= $_SESSION['userSession'];
 
        //Insert rating data into the database
        $query = "INSERT INTO game_feedback (user_id,game_id,feedback) VALUES('".$user_id."','".$game_id."','".$feedback."')";
        $insert = $DBcon->query($query);
	  
    //Fetch rating deatails from database
    $query2 = "SELECT * FROM game_feedback WHERE user_id = ".$user_id;
    $result = $DBcon->query($query2);
    $ratingRow = $result->fetch_assoc();
  if($ratingRow){
   echo     $ratingRow['status'] = 'Feedback sent, thank you for giving us your feedback.';
    }else{
 echo       $ratingRow['status'] = 'err';
    }
    //Return json formatted rating data
   // echo json_encode($ratingRow);
}
?>