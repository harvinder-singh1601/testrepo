<?php 
session_start();
include_once 'dbconnect.php';
include_once 'track.php';
if (!isset($_SESSION['userSession'])) {
  header("Location: login.php");
}
$timecount =isset($_POST['timecount']) ? $_POST['timecount'] : '';
 $stepCount =isset($_POST['stepCount']) ? $_POST['stepCount'] : '';
  $game_chosen =isset($_POST['game_chosen']) ? $_POST['game_chosen'] : '';
    $game_id =isset($_POST['game_id']) ? $_POST['game_id'] : '';
  $game_type="";
	switch($game_chosen){
		case "default":
		{$game_type=1;}
		break;
		case "upload_img":
		{$game_type=2;}
		break;
		case "take_snap":
		{$game_type=3;}
		break;
	}
	if($game_id != null){
		$gsql = "SELECT win_credit ,credit_cost ,time_limit,user_id  from game where id=".$game_id;
 $gamesql = $DBcon->query($gsql);
$gameRow=$gamesql->fetch_array();
 
 $creditsql = "SELECT charity_percentage ,winwin_percentage ,	creator_percentage,winner_percentage  from game_credit where id=".$game_id;
 $credit_sql = $DBcon->query($creditsql);
$credit_Row=$credit_sql->fetch_array();
 $charity_percentage=$credit_Row['charity_percentage']/100;
  $winwin_percentage=$credit_Row['winwin_percentage']/100;
   $creator_percentage=($credit_Row['creator_percentage'])/100;
    $winner_percentage=($credit_Row['winner_percentage'])/100;
	if($winner_percentage==0){
		if(($charity_percentage+$winwin_percentage+$creator_percentage)!=1)
		{
		 $winner_percentage=	1- ($charity_percentage+$winwin_percentage+$creator_percentage);
		}
	}
if(($gameRow['time_limit'] > $timecount) || ($gameRow['time_limit']== $timecount ) ){
$creditwon=$gameRow['win_credit'];


$GLOBALS['credit_earned']=$creditwon* $winner_percentage; 
 
   }else{
	   $GLOBALS['credit_earned']=0;

      } 
	   	$user_id= $_SESSION['userSession'];
		 $sql = "INSERT INTO game_history (user_id, game_type, completed_in,steps,game_id,credit_deducted,credit_earned)
		VALUES (".$user_id.", '".$game_type."','".$timecount."', '".$stepCount."','".$game_id."','".$gameRow['credit_cost']."','".$GLOBALS['credit_earned']."')";
        
		if ($DBcon->query($sql) === TRUE) {
			$creator_percent=$gameRow['credit_cost']*$creator_percentage;
			$creator_money=$gameRow['credit_cost']+ $creator_percent; 
			 
 	   $csql = "INSERT INTO creator_credit (user_id ,game_id,credit_earned)
		VALUES (".$gameRow['user_id'].", '".$game_id."','".$creator_money."')";
  if ($DBcon->query($csql) === TRUE) {
		
			echo " time:".$timecount."  stepCount:".$stepCount." game:".$game_type." earned:".$GLOBALS['credit_earned'];
  }else{
	  	echo "Error: " . $csql . "<br>" . $DBcon->error;
  }
		} else {
			echo "Error: " . $sql . "<br>" . $DBcon->error;
		}
	}else{
		echo "no game id".$game_id;
	}
	
?>