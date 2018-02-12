<?php 
error_reporting(0);
session_start();
include_once 'dbconnect.php';
if (!isset($_SESSION['userSession'])) {
  header("Location: login.php");
}
//echo "game-".$_REQUEST['game_id'];
// $image=$_FILES['file']['tmp_name'];
if(isset($_FILES['file2']['tmp_name']))
{
    /*list($width, $height) = getimagesize($_FILES['file2']['tmp_name']);
    
    if(($width<640) or ($height<425))
    {
        echo "1:Please Upload The Game icon larger or exact 540*420";
        
    }*/
    
    $file2="upload_images/games/icon/".time()."_".$_FILES['file2']['name'];    
    move_uploaded_file($_FILES['file2']['tmp_name'],$file2) or die ("Cannot upload Image2");
    $source_properties = getimagesize($file2);
    $image_type = $source_properties[2]; 
    if( $image_type == IMAGETYPE_JPEG ) {   
        $image_resource_id = imagecreatefromjpeg($file2);  
        $target_layer = make_thumb($image_resource_id,$source_properties[0],$source_properties[1]);
        imagejpeg($target_layer,$file2);
   }     
   elseif( $image_type == IMAGETYPE_GIF )  {  
    $image_resource_id = imagecreatefromgif($file2);
    $target_layer = make_thumb($image_resource_id,$source_properties[0],$source_properties[1]);
    imagegif($target_layer,$file2);
    }
    elseif( $image_type == IMAGETYPE_PNG ) {
        $image_resource_id = imagecreatefrompng($file2); 
        $target_layer = make_thumb($image_resource_id,$source_properties[0],$source_properties[1]);
        imagepng($target_layer,$file2);
        }
    
   
    
   }     
 
else
{
    $file2="";
    
}   
if(isset($_FILES['file']['tmp_name']))
{
    $file1="upload_images/games/".time()."_".$_FILES['file']['name'];    
    move_uploaded_file($_FILES['file']['tmp_name'],$file1) or die ("Cannot upload Image1");
    
    $source_properties = getimagesize($file1);
    $image_type = $source_properties[2]; 
    if( $image_type == IMAGETYPE_JPEG ) {   
        $image_resource_id = imagecreatefromjpeg($file1);  
        $target_layer = fn_resize($image_resource_id,$source_properties[0],$source_properties[1]);
        imagejpeg($target_layer,$file1);
   }     
   elseif( $image_type == IMAGETYPE_GIF )  {  
    $image_resource_id = imagecreatefromgif($file1);
    $target_layer = fn_resize($image_resource_id,$source_properties[0],$source_properties[1]);
    imagegif($target_layer,$file1);
    }
    elseif( $image_type == IMAGETYPE_PNG ) {
        $image_resource_id = imagecreatefrompng($file1); 
        $target_layer = fn_resize($image_resource_id,$source_properties[0],$source_properties[1]);
        imagepng($target_layer,$file1);
        }
 }
else
{
    $file1="";
    
}    



 

 $gname =isset($_REQUEST['name']) ? $_REQUEST['name'] : '';
 $credit_cost =isset($_POST['credit_cost']) ? $_POST['credit_cost'] : '';
  $win_credit =isset($_POST['win_credit']) ? $_POST['win_credit'] : '';
  $time_limit =isset($_POST['timelimit']) ? $_POST['timelimit'] : '';
 $charity_id =isset($_POST['charity_id']) ? $_POST['charity_id'] : '';
  $game_desc =isset($_POST['desc']) ? $_POST['desc'] : '';
  $game_type =isset($_POST['type']) ? $_POST['type'] : '';
  $game_steps =isset($_POST['step']) ? $_POST['step'] : '';
  $level=isset($_POST['level']) ? $_POST['level'] : '';
  $charity =isset($_POST['charity']) ? $_POST['charity'] : '';
  $winwin =isset($_POST['winwin']) ? $_POST['winwin'] : '';
    $winner =isset($_POST['winner']) ? $_POST['winner'] : '';
  $creator_earnings =isset($_POST['creator_earnings']) ? $_POST['creator_earnings'] : '';
  
 
		$user_id= $_SESSION['userSession']; 
        $sql="";    
        if($file1!="")
        {
            $sql=",Image='".$file1."'";
        }
        if($file2!="")
        {
            $sql.=",Game_Image='".$file2."'";
        }
        
           echo $gamesql="update game set name='".$gname."',Type='".$game_type."',credit_cost='".$credit_cost."',win_credit='".$win_credit."',game_desc='".$game_desc."',time_limit='".$time_limit."',user_id='".$user_id."',Steps='".$game_steps."',Level='".$level."',End_Day='".$_REQUEST['day']."',End_Hour='".$_REQUEST['hour']."',End_Minute='".$_REQUEST['minute']."',Min_credits='".$_REQUEST['min_credit']."',winner_option='".$_REQUEST['winner_option']."',Quiz_rules='".$_REQUEST['gamerule']."',value_of_the_game='".$win_credit."'".$sql." where id='".$_REQUEST['game_id']."'";                                                                                                                  
	  mysqli_query($DBcon,$gamesql) or die("Cannot Execute Query".mysqli_error($DBcon));
  
		//$DBcon->query($gamesql); 
             //game_credit distribution
            $GLOBALS['game_id'] = $_REQUEST['game_id'];
           $earningssql="update game_credit set charity_percentage='".$charity."',winwin_percentage='".$winwin."',creator_percentage='".$creator_earnings."',winner_percentage='".$winner."' where game_id='".$GLOBALS['game_id']."'";
          mysqli_query($DBcon,$earningssql) or die("Cannot Execute Query".mysqli_error($DBcon));
		                    
		 if ($charity_id != null  ){
		  
          $user_charity="select * from charity_under_user where ID='".$charity_id."'";
          $user_charity_rs=mysqli_query($DBcon,$user_charity) or die("Cannot Execute Query".mysqli_error($db));
          $user_charity_row=mysqli_fetch_array($user_charity_rs);
		  
           $delete="delete from user_charity where user_id='".$user_id."' and game_id='".$GLOBALS['game_id']."'";
          mysqli_query($DBcon,$delete) or die("Cannot Execute query".mysqli_error($DBcon));
          
	  $charitysql2 = "INSERT INTO user_charity (charity_id, user_id,game_id,name,Contact_personnel,Phonenumber,Address,Tax_ID,non_profit_501c3,Approved)
		VALUES (".$charity_id.",".$user_id.",".$GLOBALS['game_id'].",'".$user_charity_row['name']."','".$user_charity_row['Contact_personnel']."','".$user_charity_row['Phonenumber']."','".$user_charity_row['Address']."','".$user_charity_row['Tax_ID']."','".$user_charity_row['non_profit_501c3']."','".$user_charity_row['Approved']."')";
		 if ($DBcon->query($charitysql2) === TRUE) {
		  
          if(($user_charity_row['Approved']=="No") or ($user_charity_row['Approved']=="Declined"))
          {
            if($_REQUEST['enddate'])
            {
                $enddate=" <br><br>We are not saving your publish date becuse you charity is not approved by admin so first your charity will approve then plaese select the publish date.";
            }
            else
            {
                $enddate="";
            }
            $getuser="select * from tbl_users where user_id='".$_SESSION['userSession']."'";
            $getuser_rs=mysqli_query($DBcon,$getuser) or die("Cannot Execute Query".mysqli_error($DBcon));
            $getuser_row=mysqli_fetch_array($getuser_rs);
                 $subject ="Charity Used in Game-".$_POST['name']." Not Approved";
		              $to =$getuser_row['email'];
                     $mailContent = "";
                     $mailContent .= "Hello,<br><br> 
                     Thanks For Creating a game but the charity-".$user_charity_row['name']." used in this Game - ".$_POST['name']." is not apprved by our site admin so you are not able to publish this game.".$enddate."<br><br> When they approve it we will confirm you on mail and then you will make your game live<br><br>Thanks,<br><br>Team WinWin";
                     $headers.= "From: support@winwin.com\n";
              		$headers.= "MIME-Version: 1.0\n";
              		$headers.= "Content-type: text/html; charset=iso-8859-1\n";
                    mail($to,$subject,$mailContent,$headers);
                    echo "1";
                    $update="update game set Publish_Date='' where id='".$GLOBALS['game_id']."'";
                mysqli_query($DBcon,$update) or die("Cannot Execute Query".mysqli_error($DBcon));
          }
          else
          {
            if($_REQUEST['enddate'])
            {
                //$update="update game set Publish_Date='".date("Y-m-d ",strtotime($_REQUEST['enddate']))."' where id='".$GLOBALS['game_id']."'";
              
                 $update="update game set Publish_Date=STR_TO_DATE('".$_REQUEST['enddate']."', '%m/%d/%Y %h:%i %p') where id='".$GLOBALS['game_id']."'";
               
              
               
                mysqli_query($DBcon,$update) or die("Cannot Execute Query".mysqli_error($DBcon));
            }
            echo "2";
          }
		 
		} else {
			echo "Error: " . $charitysql2 . "<br>" . $DBcon->error;
		}
 }
?>
  <?php  $DBcon->close();
  function make_thumb($image_resource_id,$width,$height) {

	$target_width =640;
$target_height =425;
$target_layer=imagecreatetruecolor($target_width,$target_height);
imagecopyresampled($target_layer,$image_resource_id,0,0,0,0,$target_width,$target_height, $width,$height);
return $target_layer;
    
}
function fn_resize($image_resource_id,$width,$height) {
$target_width =1000;
$target_height =450;
$target_layer=imagecreatetruecolor($target_width,$target_height);
imagecopyresampled($target_layer,$image_resource_id,0,0,0,0,$target_width,$target_height, $width,$height);
return $target_layer;
}
  
  ?>