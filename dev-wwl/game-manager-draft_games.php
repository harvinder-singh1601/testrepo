<?php 
include 'dbConfig.php';
$page_title = "Game Product";
$page_description = "View Game Details";
include("header.php"); 
 $user_id= $_SESSION['userSession'];
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
$sql = "SELECT g.id as id,g.Min_credits as Min_credits, g.winner_option as winner_option,g.Publish as Publish,g.game_desc as game_desc,g.name as name, g.type as type,g.Game_Image as gameimage ,g.user_id as user_id, g.credit_cost as cost,g.value_of_the_game as valueofthegame, g.win_credit as winc ,g.game_desc as gdesc,g.Publish_Date as publishdate,g.End_Day as End_Day,g.End_Hour as End_Hour,g.End_Minute as End_Minute from game g where g.id='".$_REQUEST['id']."' order by g.credit_cost asc";

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

	
			<!--==Other Tab Pages==-->
			<div class="otherPages">
				
				<!--product-->
 				<div id="faq-account">
					<div class="container">
								<div class="single-page">
									<div class="single-page-row" id="detail-21">
										<div class="col-md-6 single-top-left">

											<div class="flexslider">
												<a href="game-draft-publish.php">Previous Page</a>
												<ul class="slides">
													<li data-thumb="">
													   <div class="thumb-image"> <img src="<?php echo $image?>" data-imagezoom="true" class="img-responsive" alt=""> </div>
													</li>
												</ul>
											</div>
										</div>
										<div class="col-md-6 single-top-right">
											<h3 class="item_name"><?php echo $row['name']?></h3>
										
											<span style="color:blue;">Game Status - <?php if($row['Publish']=='Yes'){ echo "Live"; }else { echo "Draft";}?></span>
											
											<div class="single-rating">
                                            <?php if($row['Publish']=='Yes')
                                            {?>
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
                                                  
                                                  $review="select * from game_feedback where game_id='".$row['id']."'";
                                                  $review_rs=mysqli_query($DBcon,$review) or die("Cannot Execute Query".mysqli_error($DBcon));
                                                  ?>
													
													<li><?php if(mysqli_num_rows($review_rs)>0)echo mysqli_num_rows($review_rs); else echo "0";?> reviews</li>
													<li style="color:#778899;margin-left: 20px"><i class="fa fa-eye" aria-hidden="true"></i> 100</li>
													<li style="margin-left: 20px;color:#77750b">Active Players: <?php if($activeuser_row['totalactive']>0)echo $activeuser_row['totalactive'];else echo "0";?></li>
												</ul>
                                                <?php
                                            }
                                            ?>
											</div>
											
											<div class="single-price">
												<ul>
													<li><span style="font-size:20px">Current Value:</span> <?php echo $row['valueofthegame']?></li>
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
											
											<div class="single-price">
												<ul>
                                                <?php
                                               $creditsql="select * from game_credit where game_id='".$row['id']."'";
                                               $credit_rs=mysqli_query($DBcon,$creditsql) or die("Cannot Execute Query".mysqli_error($DBcon));
                                               $credit_row=mysqli_fetch_array($credit_rs);
                                               $charity=$credit_row['charity_percentage'];
                                               $charity_percentage=$credit_row['charity_percentage']/100;
                                               $valueofthegame=$row['valueofthegame'];
                                               $charityvalue=$valueofthegame*$charity_percentage;
                                               ?>
													<li style="color:green"><span style="font-size:20px"><i class="fa fa-gift" aria-hidden="true"></i><?php echo $charitydata?>: </span><?php echo $charityvalue?><span style="font-size:20px"> Donated</span></li>
													<li>Charity Status: <p style="color:blue">
                                                        <?php if($approve=="Yes")
                                                        {
                                                            echo "Approved";
                                                        }
                                                        else if($approve=="Declined")
                                                        {
                                                            echo "Declined";
                                                        }
                                                        else
                                                        {
                                                            echo "Not Approved";
                                                        }?> </p></li>
												</ul>
											</div>
                                            <?php
                                            //if game is a quiz then compute if there is a question or not
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
                                            ?>
											

											<p class="single-price-text"><?php echo $row['game_desc'];?></p>
                                            <?php if($row['Publish']!='Yes')
                                            {
                                            
                                            if(($approve=="Yes") and $quiz==0)
                                            {
                                                ?>
                                                <button class="w3ls-cart" onclick='publish("<?php echo $row['id']?>")' name='publish'><i class="fa fa-trash" aria-hidden="true"></i>Publish</button>;
                                              <?php
                                              
                                            }
                                            else if($quiz==1)
                                            {
                                                ?>
                                                 <button class="w3ls-cart" onclick='showmsgquiz()'  name='publish'><i class="fa fa-trash" aria-hidden="true"></i>Publish</button>;
                                                <?php
                                            }
                                            else
                                            {
                                                ?>
                                                <button class="w3ls-cart" onclick='showmsg()'  name='publish'><i class="fa fa-trash" aria-hidden="true"></i>Publish</button>;
                                                <?php
                                            }
											?>
											
											<button class="w3ls-cart w3ls-cart-like" onclick="showdemo('<?php echo base64_encode($row['id'])?>')"><i class="fa fa-picture-o" aria-hidden="true"></i> Preview</button>
											<button type="button" onclick='go("<?php echo $row['id']?>","<?php echo $row['type']?>")' class="w3ls-cart w3ls-cart-like" ><i class="fa fa-pencil-square-o" aria-hidden="true"></i>Edit</button>
											<?php
                                            }
                                            else
                                            {
                                                ?>
                                                <button type="submit" class="w3ls-cart" ><i class="fa fa-television fa-lg" aria-hidden="true"></i> Live</button>
                                                <?php
                                            }
                                            ?>
										</div>
									   <div class="clearfix"> </div>
									</div>
                                    <?php if($row['Publish']=='Yes')
                                {?>
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
                                    <?php
                                    }
                                    ?>
								</div>

								<!-- collapse-tabs -->
                                <?php if($row['Publish']=='Yes')
                                {?>
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
                                <?php
                                }
                                ?>
					</div>
				<!-- //product -->

				</div>
			</div>
		</div>
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
        document.location="game-manager-draft_games.php?publishid="+id;
    }
    
}
function showdemo(id)
{
    document.location="demo.php?id="+id;
}
                        </script>

