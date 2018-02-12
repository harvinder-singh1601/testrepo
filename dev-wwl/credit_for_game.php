<?php
session_start();
include 'dbConfig.php';
//usercredits

$totalcredits_cr="select sum(Credits) as credits_cr from payments where status=1 and User_ID='".$_SESSION['userSession']."'";
$cr_rs=mysqli_query($db,$totalcredits_cr) or die("Cannot Execute query".mysqli_error($db));
$cr_row=mysqli_fetch_array($cr_rs);
$total_credit_cr=$cr_row['credits_cr'];

$totalcredits_db="select sum(Credits) as credits_cr from payments where status=2 and User_ID='".$_SESSION['userSession']."'";
$db_rs=mysqli_query($db,$totalcredits_db) or die("Cannot Execute query".mysqli_error($db));
$db_row=mysqli_fetch_array($db_rs);
$total_credit_db=$db_row['credits_cr'];
 $mycredits=$total_credit_cr-$total_credit_db;


$user_id= $_SESSION['userSession'];
$game=$_REQUEST['game'];
$credit=$_REQUEST['credits'];
$game="select * from game where id='".$game."'";
$game_rs=mysqli_query($db,$game) or die("Cannot Execute Query".mysqli_error($db));
$game_row=mysqli_fetch_array($game_rs);
$status=$game_row['credit_cost']." credits deduct for game ".$game_row['name'];

if($mycredits>=$game_row['credit_cost'])
{
    $totalcredits=$mycredits-$game_row['credit_cost'];
    $date = date('Y-m-d H:i:s');
  $q="INSERT INTO payments(Credits,User_ID,Date,Notes,Status,game_id,item_number,txn_id,payment_gross,currency_code,payment_status,total_credits) VALUES('".$game_row['credit_cost']."','".$_SESSION['userSession']."','".$date."','".$status."','2','".$game_row['id']."','','','0','','','".$totalcredits."')";
$insert = mysqli_query($db,$q) or die("Cannot Execute query".mysqli_error($db).$q);
$recid=mysqli_insert_id($db);
$transaction=$recid.uniqid();
 $update="update payments set txn_id='".$transaction."' where payment_id='".$recid."'";
mysqli_query($db,$update) or die("Cannot Execute Query".mysqli_error($db));

 $insert_game="insert into users_game (`User_ID`,`Game_ID`,`Date`) values('".$_SESSION['userSession']."','".$game_row['id']."',now())";
mysqli_query($db,$insert_game) or die("Cannot Execute query".mysqli_error($db).$insert_game);

 $count="select count(*) as user from users_game where Game_ID='".$game_row['id']."'";
$count_rs=mysqli_query($db,$count) or die("Cannot Execute Query".mysqli_error($db));
$count_row=mysqli_fetch_array($count_rs);

  $number_of_user=$count_row['user'];
  
  
  if ($_REQUEST['charity2']!= null  ){
		  
           $user_charity="select * from charity_under_user where ID='".$_REQUEST['charity2']."'";
          $user_charity_rs=mysqli_query($db,$user_charity) or die("Cannot Execute Query".mysqli_error($db));
          $user_charity_row=mysqli_fetch_array($user_charity_rs);
	  echo $charitysql2 = "INSERT INTO user_charity (charity_id, user_id,game_id,name,Contact_personnel,Phonenumber,Address,Tax_ID,non_profit_501c3,Approved)
		VALUES (".$_REQUEST['charity2'].",".$_SESSION['userSession'].",".$game_row['id'].",'".$user_charity_row['name']."','".$user_charity_row['Contact_personnel']."','".$user_charity_row['Phonenumber']."','".$user_charity_row['Address']."','".$user_charity_row['Tax_ID']."','".$user_charity_row['non_profit_501c3']."','".$user_charity_row['Approved']."')";
		 if ($db->query($charitysql2) === TRUE) {
		 
		} else {
			echo "Error: " . $charitysql2 . "<br>" . $db->error;
		}
 }
  
  	
//echo "wincredit=".$game_row['win_credit']."   ".$game_row['credit_cost']."  ".$number_of_user;
 $winprice=$game_row['win_credit']+($number_of_user*$game_row['credit_cost']);
 $update="update game set value_of_the_game='".$winprice."' where id='".$game_row['id']."'";
mysqli_query($db,$update) or die("Cannot Execute query".mysqli_error($db).$update);

}
else
{
    echo "1";
}
        