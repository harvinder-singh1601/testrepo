<?php include_once 'header.php';
include 'dbConfig.php';
$select="select * from game where id='".base64_decode($_REQUEST['id'])."'";
$select_rs=mysqli_query($DBcon,$select) or die("Cannot Execute Query".mysqli_error($DBcon));
$select_row=mysqli_fetch_array($select_rs);


 ?>
<div style="overflow: hidden;height: 550px;overflow-y: scroll;width:100%;padding-left:122px;">
 <div id="game4" align = "center" style="display:block">
 
 <?php
 if($select_row['Type']==3)
 {
   $quiz="select * from Quiz where game_id='".base64_decode($_REQUEST['id'])."'";
   $quiz_rs=mysqli_query($DBcon,$quiz) or die("Cannot Execute Query".mysqli_error($DBcon));
   if(mysqli_num_rows($quiz_rs)>0)
   {
    $quiz_row=mysqli_fetch_array($quiz_rs);
    ?>
    <iframe id="iframegame1" src="quizdemo.php?id=<?php echo $quiz_row['Quiz_id']?>&gameid=<?php echo base64_decode($_REQUEST['id']);?>" name="bestgameever" width="1100" height="1000" frameborder="0" scrolling="no"></iframe></div>
<?php
   }
   else
   {
    echo "First Add Quiz";
   }
    
 }
 else if($select_row['Type']==2)
 {
    ?>
    <iframe id="iframegame1" src="2048_game/2048/demo_2048.php?id=<?php echo base64_decode($_REQUEST['id'])?>" name="bestgameever" width="1100" height="1000" frameborder="0" scrolling="no"></iframe></div>

    <?php
 }
 else
 {?>
    <iframe id="iframegame1" src="demogame.php?id=<?php echo base64_decode($_REQUEST['id'])?>" name="bestgameever" width="1100" height="1000" frameborder="0" scrolling="no"></iframe></div>

 <?php
 }
 ?>
 </div>
 </div>
 
 
<?php
include "footer.php";
?>

