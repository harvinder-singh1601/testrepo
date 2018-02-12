<?php 
$page_title = "Game Play Panel";
$page_description = "Page to Play Games";
include("header.php"); 
$select="select * from game where id='".base64_decode($_REQUEST['id'])."'";
$select_rs=mysqli_query($DBcon,$select) or die("Cannot Execute Query".mysqli_error($DBcon));
$select_row=mysqli_fetch_array($select_rs);
?>

			
			<!--==Other Tab Pages==-->
			<div class="otherPages play" style="height:92% !important">
				<!--Tab Aside Nav-->
                <?php
                if($select_row['Type']==3)
                 {?>
                  <iframe id="iframegame1" style="padding: 5px;" src="quiz_game.php?game_id=<?php echo base64_decode($_REQUEST['id'])?>" name="bestgameever" width="1100" height="1000" frameborder="0" scrolling="no"></iframe>

                 <?php
                 }
                 else if($select_row['Type']==2)
                 {
                    ?>
                    <iframe id="iframegame1" style="padding: 5px;" src="2048_game/2048/2048.php?game_id=<?php echo base64_decode($_REQUEST['id'])?>" name="bestgameever" width="1100" height="1000" frameborder="0" scrolling="no"></iframe>
<?php
                 }
                 else
                 {
                 ?>
               <iframe id="iframegame1" style="padding: 5px;" src="puzzle_1.php?id=<?php echo base64_decode($_REQUEST['id'])?>" name="bestgameever" width="1100" height="1000" frameborder="0" scrolling="no"></iframe>
<?php
}
?>

				
				
			</div>
				<!--tab Indicator-->	
			
			</div>
				
		</div>

<?php include("footer.php"); ?>

		

