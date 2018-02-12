<?php 
include 'dbConfig.php';
$page_title = "Game Manager";
$page_description = "Drafted-Published-Games";
include("header.php"); 
if($_REQUEST['publishid'])
{
    //echo "date=".date("Y-m-d H:i");
	$update="update game set Publish='Yes',Publish_Date='".date("Y-m-d H:i")."' where id='".$_REQUEST['publishid']."'";
	mysqli_query($DBcon,$update) or die("Cannot Execute Query".mysqli_error($DBcon));
	?>
	<script>
		document.location="game-draft-publish.php";
	</script>
	<?php
}
?>



<!--==Other Tab Pages==-->
<div class="otherPages">
	<!--Tab Aside Nav-->
	<?php include "sidebar.php";?>
	
	<div id="game-dp-area">

		<!--Game Manager-->	
		<div id="gameDP">
			<!--Draft Section-->
			<div class="drafts">
				<h2>Drafts</h2>
				<?php
				$user_id= $_SESSION['userSession'];
				$sql = "SELECT g.id as id,g.Min_credits as Min_credits, g.winner_option as winner_option,g.Publish as Publish,g.game_desc as game_desc,g.name as name, g.type as type,g.Game_Image as gameimage ,g.user_id as user_id, g.credit_cost as cost,g.value_of_the_game as valueofthegame, g.win_credit as winc ,g.game_desc as gdesc,g.Publish_Date as publishdate,g.End_Day as End_Day,g.End_Hour as End_Hour,g.End_Minute as End_Minute from game g where g.user_id='".$user_id."' and g.Publish!='Yes' order by g.credit_cost asc";

				$result = $DBcon->query($sql) or die("Cannot Execute query".mysqli_error($DBcon));
				if ($result != null) {
					?>
					<div class="dContent">
						<div class="dContent-inner">
							<?php
							$modalwin=1;
							$countrow=0;
							while($row = $result->fetch_assoc()) {
								
								$charity="select uc.name as name ,uc.Approved as approve from user_charity as uc where  uc.user_id='".$row['user_id']."' and uc.game_id='".$row['id']."'";
								$charity_rs=mysqli_query($DBcon,$charity) or die("Cannot Execute Query".mysqli_error($DBcon));
								if(mysqli_num_rows($charity_rs)>0)
								{
									$charity_row=mysqli_fetch_array($charity_rs);
									$charitydata=$charity_row["name"];
									$approve=$charity_row["approve"];
								}
								else
								{
									$charitydata=" - ";
									$approve="No";
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
									
									
									<?php if($countrow==0){?>	<div class="row"><?php } ?>
										<?php
										$countrow=$countrow+1;
										?>
									<!--	<div class="col-xs-4 item list-style" data-toggle="modal" data-target="#playGame<?php echo $modalwin;?>">
									-->  <div class="col-xs-4 item list-style" onclick="view('<?php echo $row['id']?>')">
										<div class="each-draft">
											<div class="each-dContent">
												<div class="dcImage">
													<img src="<?php echo $image?>" alt="Draft Image1">
												</div>
												<div class="dcInfo">
													<div class="dgType">
														<label>Type of Game</label>
														<p><?php echo $type_game?></p>
													</div>
													<div class="dgTitle">
														<label>Game Title</label>
														<p><?php echo $row['name']?></p>
													</div>
													<div class="dgCharity">
														<label>Charity</label>
														<p><?php echo $charitydata?></p>
													</div>
													
													
													
													<div class="dgCredit">
														<label>Credit Amount</label>
														<p><?php echo $val?></p>
													</div>
													<div class="dgtoPlay">
														<label>Amount to Play</label>
														<p><?php echo $row["cost"]?></p>
													</div>
													<?php
													if($row["publishdate"]!='0000-00-00 00:00:00' )
														{
															?>
															<div class="dgDate">
																<label>Publish Date</label>
																<p><?php echo date("'M-d-Y H:i a'",strtotime($row["publishdate"]));?></p>
															</div>
															<?php
															
														}
														?>
														
													</div>
												</div>
											</div>
										</div>
										
										
										<!-- draft pop up -->
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
															<h2>Supported <br> Charity</h2>
															<h3><?php echo $charitydata;?></h3>
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
															<h3>Charity Status</h3>
															<span style="font-size: 12px;">
																<p><?php if($approve=="Yes")
																{
																	echo "Charity Approved";
																}
																else if($approve=="Declined")
																{
																	echo "Charity Declined";
																}
																else
																{
																	echo "Charity Not Approved";
																}?>  
															</span>
														</div>
														
														
														<?php
               // echo "op=".$row['winner_option'];
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
																if($row['type']==3)
																{
                                    //check if quiz is there then any quiz inserted or not on this game
																	$quiz="select * from Quiz where game_id='".$row['id']."'";
																	$quiz_rs=mysqli_query($DBcon,$quiz) or die("Cannot Execute Query".mysqli_error($DBcon));
																	if(mysqli_num_rows($quiz_rs)>0)$quiz=0;
																	else $quiz=1;
																	
																}
																else
																{
																	$quiz=0;
																}
																
																echo "<button class='play-btn'  style='font-size:14px;' id = 'Play1' onclick='go(".$row['id'].",".$row['type'].")' name='".$row['id']."'> Edit Game</button>";
																
																echo "<button class='play-btn'  style='font-size:14px;' id = 'Play1' onclick=showdemo('".base64_encode($row['id'])."')> Preview</button>";
																
																
																
																if(($approve=="Yes") and $quiz==0)
																{
																	echo "<button class='play-btn'  style='font-size:14px;' id = 'Play1' onclick='publish(".$row['id'].")' name='".$row['id']."'> Publish Game</button>";
																}
																else if($quiz==1)
																{
																	echo "<button  class='play-btn' style='font-size:14px;' id = 'Play1' onclick='showmsgquiz()' name='".$row['id']."'> Publish Game</button>";
																}
																else
																{
																	echo "<button class='play-btn'  style='font-size:14px;' id = 'Play1' onclick='showmsg()' name='".$row['id']."'> Publish Game</button>";
																}
																?>
																
						<!--	<button class="play-btn" type="button" onclick='play("<?php echo $row['id'] ?>",1,0,"<?php echo $row['type']?>")'>Play</button>
						-->
					</div>
				</div>
			</div>
		</div>
	</div>
	
	<?php if($countrow==3){?>	</div> <?php }?>
	
	<?php
	if($countrow==3)
	{
		$countrow=0;
	}
	$modalwin=$modalwin+1;
}
//end while loop
if($countrow!=0)
{
	echo "</div>";
}
?>
</div>
</div>
<?php

}
?>
<div class="item-style">
	<a href="" class="dList in"><i class="fa fa-th-list"></i></a>
	<a href="" class="dGrid"><i class="fa fa-th-large"></i></a>
</div>
</div>

<!--Published Section-->
<div class="publishedG">
	<h2>Published Games</h2>
	<?php
	$sql = "SELECT g.id as id,g.Min_credits as Min_credits, g.winner_option as winner_option,g.Publish as Publish,g.game_desc as game_desc,g.name as name, g.type as type,g.Game_Image as gameimage ,g.user_id as user_id, g.credit_cost as cost,g.value_of_the_game as valueofthegame, g.win_credit as winc ,g.game_desc as gdesc,g.Publish_Date as publishdate,g.End_Day as End_Day,g.End_Hour as End_Hour,g.End_Minute as End_Minute from game g where g.user_id='".$user_id."' and g.Publish='Yes' order by g.credit_cost asc";

	$result = $DBcon->query($sql) or die("Cannot Execute query".mysqli_error($DBcon));
	if ($result != null) {
		?>
		
		
		<div class="pContent">
			<div class="pContent-inner">
				<?php
				$modalwin=1;
				$countrow=0;
				while($row = $result->fetch_assoc()) {
					
					$charity="select uc.name as name ,uc.Approved as approve from user_charity as uc where  uc.user_id='".$row['user_id']."' and uc.game_id='".$row['id']."'";
					$charity_rs=mysqli_query($DBcon,$charity) or die("Cannot Execute Query".mysqli_error($DBcon));
					if(mysqli_num_rows($charity_rs)>0)
					{
						$charity_row=mysqli_fetch_array($charity_rs);
						$charitydata=$charity_row["name"];
						$approve=$charity_row["approve"];
					}
					else
					{
						$charitydata=" - ";
						$approve="No";
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
						
						
						<?php if($countrow==0){?>	<div class="row"><?php } ?>
							<?php
							$countrow=$countrow+1;
							?>
							
										<!--<div class="col-xs-4 item" data-toggle="modal" data-target="#publishedGame<?php echo $modalwin;?>">
										--><div class="col-xs-4 item" onclick="view('<?php echo $row['id']?>')">	
											<div class="each-publish">
												<div class="each-pContent">
													<div class="pcImage">
														<img src="<?php echo $image?>" alt="Draft Image1">
													</div>
													<div class="pcInfo">
														<h5 class="pcgName"><?php echo $row['name']?></h5>
														<div class="pCreditEarned">
															<label>Cost to play</label>
															<p><?php echo $row["cost"]?></p>
														</div>
														<div class="pValue">
															<label>Value</label>
															<p><?php echo $val?></p>
														</div>
														<div class="pCharity">
															<label>Charity</label>
															<p><?php echo $charitydata?></p>
														</div>
													</div>
												</div>
											</div>
											<div class="pStats">
												<p>Stats</p>
											</div>
										</div>
										<!-- published pop up -->
										<style>    
										#publishedGame<?php echo $modalwin?> .modal-dialog {
											width: 82%;
											margin: 7.4vh auto 0;
										}
									</style>
									<div class="playGame" id="playGame-area">
										<div class="modal fade"  id="publishedGame<?php echo $modalwin;?>" >
											<div class="modal-dialog">
												<div class="pgContent">
													<div class="pgLeft">
														<div class="supported-charity">
															<h2>Supported <br> Charity</h2>
															<h3><?php echo $charitydata;?></h3>
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
															<h3>Charity Status</h3>
															<span style="font-size: 12px;">
																<p><?php if($approve=="Yes")
																{
																	echo "Charity Approved";
																}
																else if($approve=="Declined")
																{
																	echo "Charity Declined";
																}
																else
																{
																	echo "Charity Not Approved";
																}?>  
															</span>
														</div>
														
														
														<?php
               // echo "op=".$row['winner_option'];
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
																
																
																
																<button class="play-btn" type="button">Live</button>

															</div>
														</div>
													</div>
												</div>
											</div>
											
											<?php if($countrow==3){?>	</div> <?php }?>
											
											<?php
											if($countrow==3)
											{
												$countrow=0;
											}
											$modalwin=$modalwin+1;
											
										}
//end while
										if($countrow!=0)
										{
											echo "</div>";
										}
									}
//end if
									?>
								</div>
							</div>
							<div class="item-style">
								<a href="" class="pList"><i class="fa fa-th-list"></i></a>
								<a href="" class="pGrid in"><i class="fa fa-th-large"></i></a>
							</div>
						</div>
					</div>
				</div>
				<!--tab Indicator-->	
				
			</div>
			
		</div>


		<!--== Footer Area==-->		
		<?php include("footer.php"); ?>
		<script>
			function showmsgquiz()
			{
				alert("Please first add quiz ");
				
			}
			function go(id,type)
			{
				if(type==1)
				{
					document.location="edit_game_puzzle.php?id="+id;
				}
				else if(type==2)
				{
					document.location="edit_game_2048.php?id="+id;
				}
				else
				{
					document.location="edit_game_quiz.php?id="+id;
				}
				
			}
			function showmsg()
			{
				alert("Your Charity is not yet approved so you are not able to publish this game");
				
			}
			function publish(id)
			{
				var ans=confirm("Are You Sure you want to make this game Live");
				if(ans==true)
				{
					document.location="game-draft-publish.php?publishid="+id;
				}
				
			}
			function showdemo(id)
			{
				document.location="demo.php?id="+id;
			}
			function view(id)
			{
				document.location="game-manager-draft_games.php?id="+id;
			}
		</script>

