<?php 
include 'dbConfig.php';
$page_title = "Game Product";
$page_description = "View Game Details";
include("header.php"); 
$totalcredits_cr="select sum(Credits) as credits_cr from payments where status=1 and User_ID='".$_SESSION['userSession']."'";
$cr_rs=mysqli_query($DBcon,$totalcredits_cr) or die("Cannot Execute query".mysqli_error($DBcon));
$cr_row=mysqli_fetch_array($cr_rs);
$total_credit_cr=$cr_row['credits_cr'];

$totalcredits_db="select sum(Credits) as credits_cr from payments where status=2 and User_ID='".$_SESSION['userSession']."'";
$db_rs=mysqli_query($DBcon,$totalcredits_db) or die("Cannot Execute query".mysqli_error($DBcon));
$db_row=mysqli_fetch_array($db_rs);
$total_credit_db=$db_row['credits_cr'];
$mycredits=$total_credit_cr-$total_credit_db;
$sql = "SELECT g.id as id,g.credit_cost as creditcost,g.Min_credits as Min_credits, g.winner_option as winner_option,g.Publish as Publish,g.game_desc as game_desc,g.name as name, g.type as type,g.Game_Image as gameimage ,g.user_id as user_id, g.credit_cost as cost,g.value_of_the_game as valueofthegame, g.win_credit as winc ,g.game_desc as gdesc,g.Publish_Date as publishdate,g.End_Day as End_Day,g.End_Hour as End_Hour,g.End_Minute as End_Minute from game g where g.id='".$_REQUEST['id']."' order by g.credit_cost asc";

$result = $DBcon->query($sql) or die("Cannot Execute query".mysqli_error($DBcon));
$row = $result->fetch_assoc();
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
       
       //player Charity
        
        $playercharity="select uc.name as name from user_charity as uc where uc.user_id='".$_SESSION['userSession']."' and uc.game_id='".$row['id']."'";
        
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
<input type="hidden" name="mycredits_value" id="mycredits_value" value="<?php echo $mycredits;?>">
<input type="hidden" name="gameid" id="gameid" value="<?php echo $_REQUEST['id'];?>">

	
			<!--==Other Tab Pages==-->
			<div class="otherPages">
				
				<!--product-->
 				<div id="faq-account">
					<div class="container">
								<div class="single-page">
									<div class="single-page-row" id="detail-21">
										<div class="col-md-6 single-top-left">

											<div class="flexslider">
												<a href="played-game.php">Previous Page</a>
												<ul class="slides">
													<li data-thumb="">
													   <div class="thumb-image">  <img src="<?php echo $image?>" data-imagezoom="true" class="img-responsive" alt=""> 
													</li>
												</ul>
											</div>
										</div>
										<div class="col-md-6 single-top-right">
											<h3 class="item_name"><?php echo $row['name']?></h3>
											
											<div class="single-rating">
												<ul>
                                                <?php
                                                  for($j=1;$j<=$rate;$j=$j+1)
                                                  {
                                                    ?>
                                                    <li><i class="fa fa-star" aria-hidden="true"></i></li>
                                                    <?php
                                                  }
                                                  for($m=$j-1;$m<5;$m=$m+1)
                                                  {?>
                                                    <li><i class="fa fa-star-o" aria-hidden="true"></i></li>
                                                  <?php
                                                  }
                                                  
                                                  $activeuser="select count(*) as totalactive from users_game where Game_ID='".$row['id']."'";
                                                  $activeuser_rs=mysqli_query($DBcon,$activeuser) or die("Cannot Execute".mysqli_error($DBcon));
                                                  $activeuser_row=mysqli_fetch_array($activeuser_rs);
                                                  
                                                  $gameseen="select count(*) as totalseen from gameseenbyusers where GameID='".$row['id']."'";
                                                  $gameseen_rs=mysqli_query($DBcon,$gameseen) or die("Cannot Execute".mysqli_error($DBcon));
                                                  $gameseen_row=mysqli_fetch_array($gameseen_rs);
                                                  
                                                  $review="select * from game_feedback where game_id='".$row['id']."' and feedback !=''";
                                                  $review_rs=mysqli_query($DBcon,$review) or die("Cannot Execute Query".mysqli_error($DBcon));
                                                  ?>
													
													<li><?php if(mysqli_num_rows($review_rs)>0)echo mysqli_num_rows($review_rs); else echo "0";?> reviews</li>
													<li style="color:#778899;margin-left: 20px"><i class="fa fa-eye" aria-hidden="true"></i> <?php echo $gameseen_row['totalseen']?></li>
													<li style="margin-left: 20px;color:#77750b">Active Players: <?php if($activeuser_row['totalactive']>0)echo $activeuser_row['totalactive'];else echo "0";?></li>
												</ul>
											</div>
											<!-- <div class="single-price" style="padding-bottom: 1em">
												<ul>
													<li><span style="font-size:20px">Current Value:</span> 540</li>
													<li>Ends on: June,5th</li>
													<li>Minimum Credit: 5000</li>
													
												</ul>
											</div>
											<div style="border-bottom:1px solid #e0e0e0;"></div> -->
											<div class="single-price">
												<ul>
													<li><span style="font-size:20px">Current Value:</span>  <?php echo $row['valueofthegame']?></li>
												</ul>
											</div>
											<div class="single-rating">
												<ul>
													<?php
                                                if(($row['winner_option']==1) and ($row["publishdate"]!='0000-00-00 00:00:00' ))
                                                {
                                                    
                                                        
                                                        $startTime = $row['publishdate'];
                                                        
                                                        $cenvertedTime = date('Y-m-d H:i:s',strtotime('+'.$row['End_Day'].' day +'.$row['End_Hour'].' hour +'.$row['End_Minute'].' minutes',strtotime($startTime)));
                                                        
                                                        
                                                        ?>
                                                       	<li>Ends on: <?php echo date('M-d-Y H:i a',strtotime($cenvertedTime))?></li>
                                                    <?php
                                                    
                                                }
                                                else if(($row['winner_option']==2) and ($row['Min_credits']!='' ))
                                                {
                                                        ?>
                                                        	<li>Minimum Credit: <?php echo $row['Min_credits']?></li>
                                                    <?php
                                                    
                                                }
                                                 if(($row['winner_option']==3) and ($row["publishdate"]!='0000-00-00 00:00:00' ))
                                                {
                                                   
                                                        $startTime = $row['publishdate'];
                                                        
                                                        $cenvertedTime = date('Y-m-d H:i:s',strtotime('+'.$row['End_Day'].' day +'.$row['End_Hour'].' hour +'.$row['End_Minute'].' minutes',strtotime($startTime)));
                                                        ?>
                                                        <li>Ends on: <?php echo date('M-d-Y H:i a',strtotime($cenvertedTime))?></li>
                                                        
                                                        <li style="padding-left: 50px">Minimum Credit: <?php echo $row['Min_credits']?></li>
                                                    <?php
                                                    
                                                }
                                                ?>
													
													
												</ul>
											</div>
											
											    <?php
                                               $creditsql="select * from game_credit where game_id='".$row['id']."'";
                                               $credit_rs=mysqli_query($DBcon,$creditsql) or die("Cannot Execute Query".mysqli_error($DBcon));
                                               $credit_row=mysqli_fetch_array($credit_rs);
                                               $charity=$credit_row['charity_percentage'];
                                               $charity_percentage=$credit_row['charity_percentage']/100;
                                               $valueofthegame=$row['valueofthegame'];
                                               $charityvalue=$valueofthegame*$charity_percentage;
                                               $charityvalue=$charityvalue/2;
                                               ?>
													
                                            <div class="single-price">
												<ul>
													<!-- this will be Creator charity -->
													<li style="color:green"><span style="font-size:20px"><i class="fa fa-gift" aria-hidden="true"></i><?php echo $playercharitydata;?>: </span><?php echo $charityvalue?><span style="font-size:20px"> Donated</span></li>
													<!--  -->
													<li>Creator Charity: <p style="color:blue"><?php echo $charitydata?></p></li>
												</ul>
											</div>
											<div style="border-bottom:1px solid #e0e0e0;"></div> -->

											<?php
                                            $game_history="select * from game_history where game_id='".$row['id']."' and user_id='".$_SESSION['userSession']."'";
                                            $history_rs=mysqli_query($DBcon,$game_history) or die("Cannot Execute Query".mysqli_error($DBcon));
                                            $history_row=mysqli_fetch_array($history_rs);
                                            ?>

											<p class="single-price-text"><?php echo $row['game_desc'];?></p>
                                            <?php
                       if(mysqli_num_rows($history_rs)>0)
                          {
                           
                             echo '<button type="submit" class="w3ls-cart" ><i class="fa fa-clock-o" aria-hidden="true"></i></i>Time: '.$history_row['completed_in'].' sec</button>';
                         
                            if($row["type"]==3)
                            {
                                echo '<button class="w3ls-cart w3ls-cart-like"><i class="fa fa-id-card" aria-hidden="true"></i></i>Score(%): '.$history_row['quiz_percentage'].'</button>';
                            }
                            else if($row["type"]==2)
                            {
                                echo '<button class="w3ls-cart w3ls-cart-like"><i class="fa fa-id-card" aria-hidden="true"></i></i>Score: '.$history_row['Score'].'</button>';
                                
                            
                            }
                            else
                            {
                                echo '<button class="w3ls-cart w3ls-cart-like"><i class="fa fa-id-card" aria-hidden="true"></i></i>Steps: '.$history_row['steps'].'</button>';
                                
                            }
                            $payment="select * from payments where game_id='".$row['id']."' and user_id='".$_SESSION['userSession']."' and Status='1'";
                            $payment_rs=mysqli_query($DBcon,$payment) or die("Cannot execute query".mysqli_error($DBcon));
                            
                            if(mysqli_num_rows($payment_rs)>0)
                            {
                                $payment_row=mysqli_fetch_array($payment_rs);
                                echo '<button style="width:32%;margin-left:5px;" type="submit" class="w3ls-cart" ><i aria-hidden="true"></i></i>You Earn(Credits): '.$payment_row['Credits'].' </button>';
                         
                                
                            }
                          }
                                            ?>
                                            
											</div>
									   <div class="clearfix"> </div>
									</div>
									<div class="single-page-icons social-icons">
										<ul>
											<li><h4>Share on</h4></li>
											<li><a href="#" class="fa fa-facebook icon facebook"> </a></li>
											<li><a href="#" class="fa fa-twitter icon twitter"> </a></li>
											<li><a href="#" class="fa fa-google-plus icon googleplus"> </a></li>
											<li><a href="#" class="fa fa-dribbble icon dribbble"> </a></li>
											<li><a href="#" class="fa fa-rss icon rss"> </a></li>
										</ul>
									</div>
								</div>

								<!-- collapse-tabs -->
								<div class="collpse tabs">
									<h3 class="w3ls-title">About this Game</h3>
									<div class="panel-group collpse" id="accordion" role="tablist" aria-multiselectable="true">
										
										<div class="panel panel-default">
											<div class="panel-heading" role="tab" id="headingThree">
												<h4 class="panel-title">
													<a class="collapsed pa_italic" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
														<i class="fa fa-check-square-o fa-icon" aria-hidden="true"></i> reviews (<?php if(mysqli_num_rows($review_rs)>0)echo mysqli_num_rows($review_rs); else echo "0";?>) <span class="fa fa-angle-down fa-arrow" aria-hidden="true"></span> <i class="fa fa-angle-up fa-arrow" aria-hidden="true"></i>
													</a>
												</h4>
											</div>
                                            <div id="collapseThree" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree">
											
                                            <?php
                                            while($review_row=mysqli_fetch_array($review_rs))
                                            {
                                                if(trim($review_row['feedback'])!="")
                                                {
                                            ?>
												<div class="panel-body">
													<?php echo $review_row['feedback'];?>
												</div>
											
                                            <?php
                                            }
                                            }
                                            ?>
                                            </div>
										</div>
										
									</div>
								</div>
					</div>
				<!-- //product -->

				</div>
			</div>
		</div>
        <div class="gameCreation" id="gameCreation-area" >
			<div class="modal fade"  id="charityModal">
				<div class="modal-dialog">
					<div class="gcContent" style="border: 2px solid #ff6666;">
						<h2>Add Charity</h2>

						<div class="row">
							<div class="col-xs-12">
								<div class="each-gc">
								<div class="playCredit">
								<h3>Charity Name : </h3>
								<span><?php
                  $charityval="SELECT * FROM charity";
                  $charityval_rs=mysqli_query($db,$charityval) or die("Cannot Execute Query".mysqli_error($db));
                  ?>
                  <select  style="color:#ff6666;width:100%; border-radius:5px;padding:5px;" name="charity_game_name" id="charity_game_name">
                  <?php
                  while($charityval_row=mysqli_fetch_array($charityval_rs))
                  {
                    echo "<option value='".$charityval_row['id']."'>".$charityval_row['name']."</option>";
                  }
                  ?>

                  </select></span>
                                </div>
                                <input type="hidden" name="box" id="box" value="">
                                <button style="line-height:2em" class="play-btn"  type="button" onclick='addcharity()'>Submit</button>

								</div>
							</div>

						</div>

					</div>

				</div>
			</div>
		</div>
        
						<?php include("footer.php"); ?>

