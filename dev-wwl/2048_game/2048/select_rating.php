<?php
session_start();
include_once '../../dbconnect.php';
if (!isset($_SESSION['userSession'])) {
  header("Location: login.php");
}
if(!empty($_GET['game_id'])){
    $game_id = $_GET['game_id'];
        
    $query2 = "SELECT AVG(rating) as average FROM user_game_rate WHERE game_id = ".$game_id;
    $result = $DBcon->query($query2);
    //$result=mysqli_query($DBcon,$query2) or die("Cannot Execute Query".mysqli_error($DBcon));
    $ratingRow = $result->fetch_assoc();
 
    //Return json formatted rating data
    echo json_encode($ratingRow);
}
?>