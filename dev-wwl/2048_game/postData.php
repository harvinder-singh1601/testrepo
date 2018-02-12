<?php
require_once 'config.php';
session_start();
if ($_REQUEST) {
    $id = 1;
    $game="select * from game where id='".$_REQUEST['game_id']."'";
    $game_rs=mysqli_query($conn,$game) or die("Cannot Execute Query".mysqli_error($conn));
    $game_row=mysqli_fetch_array($game_rs);
	if (isset($_REQUEST['bestScore'])) 
    {
	   $select="select * from game_history where user_id='".$_SESSION['userSession']."' and game_id='".$_REQUEST['game_id']."'";
       $select_rs=mysqli_query($conn,$select) or die("Cannot Execute Query".mysqli_error($conn));
       if(mysqli_num_rows($select_rs)>0)
       {
        $select_row=mysqli_fetch_array($select_rs);
		 $sql  = "UPDATE game_history SET Score = '".$_REQUEST["bestScore"]."' WHERE id = '".$select_row['id']."'";
		$result = mysqli_query($conn, $sql);
        }
        else
        {
            $insert="insert into game_history(user_id,game_type,game_id,credit_deducted,Score) values ('".$_SESSION['userSession']."','2','".$_REQUEST['game_id']."','".$game_row['credit_cost']."','".$_POST['bestScore']."')";
        mysqli_query($conn,$insert) or die('Cannot Execute Query'.mysqli_error($conn));
        }
	} 
    else 
    {
	   $select="select * from game_history where user_id='".$_SESSION['userSession']."' and game_id='".$_REQUEST['game_id']."'";
       $select_rs=mysqli_query($conn,$select) or die("Cannot Execute Query".mysqli_error($conn));
       if(mysqli_num_rows($select_rs)>0)
       {
          $select_row=mysqli_fetch_array($select_rs);
          $sql  = "UPDATE game_history SET Score = '$_POST[score]', 2048_won = '$_POST[won]',completed_in='".$_REQUEST['timecount']."' WHERE id = '".$select_row['id']."'";
		   $result = mysqli_query($conn, $sql) or die("Cannot Execute".mysqli_error($conn));
          
       }
       else
       {
        $insert="insert into game_history(user_id,game_type,game_id,credit_deducted) values ('".$_SESSION['userSession']."','2','".$_REQUEST['game_id']."','".$game_row['credit_cost']."')";
        mysqli_query($conn,$insert) or die('Cannot Execute Query'.mysqli_error($conn));
       }
		// $sql  = "UPDATE 2048_user SET score = '$_POST[score]', over = '$_POST[over]', won = '$_POST[won]', size='$_POST[size]' WHERE id = '$id'";
		//$result = mysqli_query($conn, $sql);
	}
}