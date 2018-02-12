<?php 
include 'dbConfig.php';
$page_title = "Played Games";
$page_description = "Game-History";
include("header.php"); 
?>
	
			
			
			<!--==Other Tab Pages==-->
			<div class="otherPages">
				<!--Tab Aside Nav-
				<div class="otherAsideNav">
					<ul>
						<li><a href="game-account.php">Account</a></li>
						<li class="active"><a href="game-draft-publish.php">Your Games</a>
							<ul class="your-games">
								<li><a href="game-draft-publish.php">Drafts</a></li>
								<li><a href="game-draft-publish.php">Published Games</a></li>
								<li class="active"><a href="played-game.php">Played Games</a></li>
							</ul>
						</li>
						<li><a href="charity.php">Your Charities</a></li>
						<li><a href="">Your Calender</a></li>
						<li><a href="">Your Earnings</a></li>
					</ul>
				</div>
                -->
                <?php include "sidebar.php";?>

				
				<div id="game-played-area">
					<div id="gm-played">
						<h2>Played Games</h2>
						<div class="gpContent">
							<div class="gpContent-inner">
								<div class="row">
<?php 
  $user_id= $_SESSION['userSession'];
  $sql = "SELECT g.id as id,g.Game_Image as gameimage ,g.game_desc as game_desc,g.name as name, g.type as type ,g.user_id as user_id, g.credit_cost as cost,g.value_of_the_game as valueofthegame, g.win_credit as winc ,g.game_desc as gdesc,g.Status as status from game g where  g.id  in (select Game_ID from users_game where User_ID='".$user_id."') order by g.id desc";

$result = $DBcon->query($sql);
 
if ($result != null) {
    
  // output data of each row
$modalwin=1;
    while($row = $result->fetch_assoc()) {
        
        $payment="select * from payments where game_id='".$row['id']."' and user_id='".$user_id."' and Status='1'";
        $payment_rs=mysqli_query($DBcon,$payment) or die("Cannot execute query".mysqli_error($DBcon));
        
        $game_history="select * from game_history where game_id='".$row['id']."' and user_id='".$user_id."'";
        $history_rs=mysqli_query($DBcon,$game_history) or die("Cannot Execute Query".mysqli_error($DBcon));
        $history_row=mysqli_fetch_array($history_rs);
        //$charity="select c.name as name from user_charity as uc,charity_under_user as c where uc.charity_id=c.id and uc.user_id='".$row['user_id']."' and uc.game_id='".$row['id']."'";
        $charity="select uc.name as name from user_charity as uc where uc.user_id='".$row['user_id']."' and uc.game_id='".$row['id']."'";
        
        $charity_rs=mysqli_query($DBcon,$charity) or die("Cannot Execute Query".mysqli_error($DBcon));
        if(mysqli_num_rows($charity_rs)>0)
        {
            $charity_row=mysqli_fetch_array($charity_rs);
            $charitydata=$charity_row["name"];
        }
        else
        {
            $charitydata=" - ";
        }
        
        //player Charity
        
        $playercharity="select uc.name as name from user_charity as uc where uc.user_id='".$user_id."' and uc.game_id='".$row['id']."'";
        
        $playercharity_rs=mysqli_query($DBcon,$playercharity) or die("Cannot Execute Query".mysqli_error($DBcon));
        if(mysqli_num_rows($charity_rs)>0)
        {
            $playercharity_row=mysqli_fetch_array($playercharity_rs);
            $playercharitydata=$playercharity_row["name"];
        }
        else
        {
            $playercharitydata=" - ";
        }
        
        if($row['valueofthegame']==0)$val=$row['winc'];
        else $val=$row['valueofthegame'];
        if($row["type"]==0 or $row["type"]==1){
          $type_game = 'Puzzle';}
        elseif($row["type"]==2){$type_game = '2048';}
        elseif($row["type"]==3){$type_game = 'Quiz';}
        
        if(($row['gameimage']!="") and file_exists($row['gameimage']))
        {
            $image=$row['gameimage'];
            
        }
        else
        {
            $image="http://iheartdogs.com/wp-content/uploads/2015/01/4577137586_5f4cf7fbd3_z.jpg";
            
        }
        
        $rating="select round(AVG(rating),0)as rating from user_game_rate where  game_id='".$row['id']."'";
                $rating_rs=mysqli_query($DBcon,$rating) or die("Cannot Execute Query".mysqli_error());
                $rating_row=mysqli_fetch_array($rating_rs);
                if(mysqli_num_rows($rating_rs)>0)
                {
                    $rate=$rating_row['rating'];
                }
                else
                {
                    $rate=0;
                }
?>
								<!--	<div class="col-xs-6 item"  data-toggle="modal" data-target="#playGame<?php echo $modalwin;?>">-->
                                    <div class="col-xs-6 item" onclick="view('<?php echo $row['id']?>')">
										<div class="each-gp">
											
											<div class="gpImage">
												<img src="<?php echo $image?>" alt="Draft Image1">
											</div>
											<div class="gpInfo">
												<div class="gpType">
													<label>Type of Game</label>
													<p><?php echo $type_game?></p>
												</div>
												<div class="gpTitle">
													<label>Game Title</label>
													<p><?php echo  $row["name"]?></p>
												</div>
												<div class="gpCharity">
													<label>Charity</label>
													<p><?php echo $charitydata;?></p>
												</div>
												<div class="gpCredit">
													<label>Credit Amount</label>
													<p><?php echo $val;?></p>
												</div>
												<div class="gptoPlay">
													<label>Amount to Play</label>
													<p><?php echo $row["cost"]?></p>
												</div>
												<div class="gpDate">
													<label>Game Status</label>
													<p><?php if($row['status']!="Completed") echo "Live ";else echo "Finish"?></p>
												</div>
											</div>
										</div>
									</div>
                                    	<!--  pop up -->
            <style>    
                        #playGame<?php echo $modalwin?> .modal-dialog {
                        width: 82%;
                        margin: 7.4vh auto 0;
                    }
                        </style>
                                    <div class="playGame" id="playGame-area">
			<div class="modal fade"  id="playGame<?php echo $modalwin;?>" >
				<div class="modal-dialog">
					<div class="pgContent">
						<div class="pgLeft">
							<div class="supported-charity">
								<h4>Creater Charity</h4>
								<span style='font-size: 12px;'><?php echo $charitydata;?></span>
							</div>
                            <div class="supported-charity">
								<h4>Player  Charity</h4>
								<span style='font-size: 12px;'><?php echo $playercharitydata;?></span>
							</div>

						<?php
                   $creditsql="select * from game_credit where game_id='".$row['id']."'";
                   $credit_rs=mysqli_query($DBcon,$creditsql) or die("Cannot Execute Query".mysqli_error($DBcon));
                   $credit_row=mysqli_fetch_array($credit_rs);
                   $charity=$credit_row['charity_percentage'];
                   $charity_percentage=$credit_row['charity_percentage']/100;
                   $valueofthegame=$row['valueofthegame'];
                   $charityvalue=$valueofthegame*$charity_percentage;
                   ?>
							<h4>Credit to be <br>Donated to Charity</h4>
							<span><?php echo $charityvalue;?></span>
                            <div class="gameCredit">
               <?php   if(mysqli_num_rows($history_rs)>0)
                  {
                    echo "<h3>Game Completed </h3> <span style='font-size: 12px;'><p>Yes</p></span></div>";
                    echo "<div class='playCredit'><h3>Time </h3><span style='font-size: 12px;'><p>".$history_row['completed_in']." sec</p></span></div>";
                    
                    
                  }
                  else
                  {
                    echo "<h3>Game Completed</h3><span style='font-size: 12px;'><p>No</p></span></div>";
                  }
							?>
						
						
                            
                            <?php
                echo "op=".$row['winner_option'];
                if(($row['winner_option']==1) and ($row["publishdate"]!='0000-00-00 00:00:00' ))
                {
                    ?>
                        <div class="gameCredit">
								<h3>Game End Date:</h3>
                                <span style="font-size: 12px;">
                        
                        <?php
                        
                        
                        $startTime = $row['publishdate'];
                        
                        $cenvertedTime = date('Y-m-d H:i:s',strtotime('+'.$row['End_Day'].' day +'.$row['End_Hour'].' hour +'.$row['End_Minute'].' minutes',strtotime($startTime)));
                        
                        echo date('M-d-Y H:i a',strtotime($cenvertedTime));
                        ?>
                        </span>
                        </div>
                    <?php
                    
                }
                ?>
                <?php
                if(($row['winner_option']==2) and ($row['Min_credits']!='' ))
                {
                    ?>
                         <div class="gameCredit">
								<h3>Min Credit For Game End:</h3>
                                <span>
                        
                        <?php
                        
                        
                        
                        echo $row['Min_credits'];
                        ?>
                        </span>
                        </div>
                    <?php
                    
                }
                ?>
                 <?php
                if(($row['winner_option']==3) and ($row["publishdate"]!='0000-00-00 00:00:00' ))
                {
                    ?>
                    <div class="gameCredit">
								<h3>Game End Date:</h3>
                                <span style="font-size: 12px;">
                        
                        <?php
                        
                        
                        $startTime = $row['publishdate'];
                        
                        $cenvertedTime = date('Y-m-d H:i:s',strtotime('+'.$row['End_Day'].' day +'.$row['End_Hour'].' hour +'.$row['End_Minute'].' minutes',strtotime($startTime)));
                        
                        echo date('M-d-Y H:i a',strtotime($cenvertedTime));
                        ?>
                        </span>
                        </div>
                        <div class="gameCredit">
								<h3>Min Credit For Game End:</h3>
                                <span>
                        
                        <?php
                        
                        
                        
                        echo $row['Min_credits'];
                        ?>
                        </span>
                        </div>
                    <?php
                    
                }
                ?>

							
						</div>
						<div class="pgCenter">
							<img src="<?php echo $image?>" alt="Draft Image1">
						</div>	
						<div class="pgRight">
							
							<div class="gameCredit">
								<h3>Valued Game Credits</h3>
								<span><?php echo $val;?></span>
							</div>
							<div class="playCredit">
								<h3>Credits to Play</h3>
								<span><?php echo $row["cost"]?></span>
                                <input type="hidden" name="cost_<?php echo $row['id']?>" id="cost_<?php echo $row['id']?>" value="<?php echo $row["cost"]?>">
							</div>
                          <?php  
                            if(mysqli_num_rows($history_rs)>0)
                          {
                            
                            if($row["type"]==3)
                            {
                                 echo "<div class='playCredit'><h3>Score(%)</h3><span style='font-size: 12px;'><p>".$history_row['quiz_percentage']."</p></span></div>";
                            }
                            else if($row["type"]==2)
                            {
                                 echo "<div class='playCredit'><h3>Score</h3><span style='font-size: 12px;'><p>".$history_row['Score']."</p></span></div>";
                            }
                            else
                            {
                                echo "<div class='playCredit'><h3>Steps</h3><span style='font-size: 12px;'><p>".$history_row['steps']."</p></span></div>";
                            }
                            
                            if(mysqli_num_rows($payment_rs)>0)
                            {
                                $payment_row=mysqli_fetch_array($payment_rs);
                                echo  "<div class='playCredit'><h3>You Earn(Credits)</h3><span style='font-size: 12px;'><p>".$payment_row['Credits']."</p></span></div>";
                            }
                          }
                          ?>
                            
						<!--	<button class="play-btn" type="button" onclick='play("<?php echo $row['id'] ?>",1,0,"<?php echo $row['type']?>")'>Play</button>
-->
						</div>
					</div>
				</div>
			</div>
		</div>
<?php
$modalwin=$modalwin+1;
}
}
?>
									
									
								</div>	
								
								
							</div>
						</div>
						<div class="item-style">
							<a href="" class="gpList in"><i class="fa fa-th-list"></i></a>
							<a href="" class="gpGrid"><i class="fa fa-th-large"></i></a>
						</div>
					</div>
				</div>
				<!--tab Indicator-->	
				<div class="tab-indicator">
					<ol>
						<li>
						  <a href="play-game.php">
							<img src="assets/img/play.png" alt="Play Games">
						  </a>
						</li>
						<li>
						  <a href="#"  data-toggle="modal" data-target="#gameCreation">
							<img src="assets/img/creation.png" alt="Game Creation">
						  </a>
						</li>
						<li class="active">
						  <a href="game-draft-publish.php">
						    <img src="assets/img/manager.png" alt="Game Manager">
						  </a>
						</li>
						<li>
						  <a href="#">
							<img src="assets/img/credits.png" alt="Credits">
						  </a>
						</li>
						<li>
						  <a href="charity.php">
							<img src="assets/img/charities.png" alt="Charities">
						  </a>
						</li>
					</ol>
				</div>
			</div>
				
		</div>


		<!--Game Creation Popup-->
		<div class="gameCreation" id="gameCreation-area">
			<div class="modal fade"  id="gameCreation">
				<div class="modal-dialog">
					<div class="gcContent">
						<h2>What game do you<br> wish to make?</h2>

						<div class="row">
							<div class="col-xs-4">
								<div class="each-gc">
									<a href="">
										<div class="gcImage">
											<img src="assets/img/game_type.png" alt="Game image">
										</div>
										<h3>Puzzle</h3>
									</a>
								</div>
							</div>
							<div class="col-xs-4">
								<div class="each-gc">
									<a href="">
										<div class="gcImage">
											<img src="assets/img/game_number.png" alt="Game image">
										</div>
										<h3>2048</h3>
									</a>
								</div>
							</div>
							<div class="col-xs-4">
								<div class="each-gc">
									<a href="">
										<div class="gcImage">
											<img src="assets/img/quiz.png" alt="Game image">
										</div>
										<h3>QUIZ</h3>
									</a>
								</div>
							</div>
						</div>

					</div>

				</div>
			</div>
		</div>

		<!--== Footer Area==-->			
		<?php include("footer.php"); ?>
<script>
function view(id)
{
    document.location="game-manager-played_games.php?id="+id;
}
</script>
