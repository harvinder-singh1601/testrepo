<?php
error_reporting(0);
session_start();
include 'dbConfig.php';
$con="";
$scriptname="play-game.php";
$num_rec_per_page=10;
if($_REQUEST['id']!="")
{
    $con=" and  g.Type='".$_REQUEST['id']."'";
}
if($_REQUEST['min']!="" and $_REQUEST['max']!="")
{
    $con.=" and (g.credit_cost >='".$_REQUEST['min']."' and g.credit_cost <='".$_REQUEST['max']."')";
}
if($_REQUEST['valuemin']!="" and $_REQUEST['valuemax']!="")
{
    $con.=" and (g.value_of_the_game >='".$_REQUEST['valuemin']."' and g.value_of_the_game <='".$_REQUEST['valuemax']."')";
}
if($_REQUEST['ratingval']!="")
{
    if($_REQUEST['ratingval']==0)
    $con.=" and g.id not IN (select game_id from user_game_rate)";
    else
     $con.=" and g.id IN (select game_id from user_game_rate group by game_id having round(avg(rating),0) ='".$_REQUEST['ratingval']."')";
    
}
if($_REQUEST['charityval']!="0")
{
   
     $con.=" and g.id IN (select game_id from user_charity where charity_id='".$_REQUEST['charityval']."' and name!='')";
    
}
/*if($_REQUEST['charity']>0)
{
    $con.=" and g.id in ( select game_id from user_charity where charity_id='".$_REQUEST['charity']."')";
}*/
    {

  $user_id= $_SESSION['userSession'];
  if (isset($_GET["page"])) { $page  = $_GET["page"]; } else { $page=1; }; 
   $start_from = ($page-1) * $num_rec_per_page; 
  if($_REQUEST['page']=="gamelist")
   $sql = "SELECT g.id as id,g.Publish as Publish,g.game_desc as game_desc,g.Game_Image as gameimage,g.name as name, g.type as type ,g.user_id as user_id, g.credit_cost as cost,g.value_of_the_game as valueofthegame, g.win_credit as winc ,g.game_desc as gdesc from game g where g.user_id=".$user_id." ".$con."  order by g.credit_cost asc";
  else
  $sql = "SELECT g.id as id,g.Publish as Publish,g.game_desc as game_desc,g.Game_Image as gameimage,g.name as name, g.type as type ,g.user_id as user_id, g.credit_cost as cost,g.value_of_the_game as valueofthegame, g.win_credit as winc ,g.game_desc as gdesc from game g where g.user_id!=".$user_id." and g.Publish='Yes' and g.Status='Running' and g.id not in (select Game_ID from users_game where User_ID='".$user_id."') ".$con."  order by g.credit_cost asc LIMIT $start_from, $num_rec_per_page";
  
//  echo $sql;
$result = $db->query($sql);
 
if (mysqli_num_rows($result)>0) {
?>

                   
                   
                    <?php   // output data of each row
$modalwin=1;
    $countrow=0;
    while($row = $result->fetch_assoc())  
    {
        $modalval="";
        $val="";
        $charity="select uc.name as name from user_charity as uc where uc.user_id='".$row['user_id']."' and uc.game_id='".$row['id']."'";
        
        $charity_rs=mysqli_query($db,$charity) or die("Cannot Execute Query".mysqli_error($db));
        if(mysqli_num_rows($charity_rs)>0)
        {
            $charity_row=mysqli_fetch_array($charity_rs);
            $charitydata=$charity_row["name"];
        }
        else
        {
            $charitydata=" - ";
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
                $rating_rs=mysqli_query($db,$rating) or die("Cannot Execute Query".mysqli_error($db));
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
				<?php if($countrow==0){?>	<div class="play-row"><?php } ?>
               <?php
               $countrow=$countrow+1;
               ?>
               <!-- Play game pop up -->
						<div class="each-play-game" data-toggle="modal" data-target="#playGame<?php echo $modalwin;?>">
							<div class="epg-content">
								<div class="epgImage">
									<img src="<?php echo $image?>" alt="Draft Image1">
								</div>
								<div class="epgInfo">
									<h5 class="epgName"><?php echo $row["name"]?></h5>
                                    <div class="epgCreditEarned">
										<label>Game Type</label>
										<p><?php echo $type_game;?></p>
									</div>
									<div class="epgCreditEarned">
										<label>Credits Earned</label>
										<p>1000</p>
									</div>
                                    
									<div class="epgValue">
										<label>Value</label>
                                        <?php
                                        $modalval=$val;
                                        ?>
										<p><?php echo $val;?></p>
									</div>
									<div class="epgCharity">
										<label>Charity</label>
										<p><?php echo $charitydata;?></p>
									</div>
								</div>
							</div>
						</div>
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

							<h4>Amount to be <br>Donated to Charity</h4>
							<span>30,000.00</span>
						<!--	<div class="highScore">
								<h2>High Score</h2>
								<div class="hsChart">
									<div class="eachScorer-head">
										<h3>Name</h3>
										<h3>Time</h3>
									</div>
									<div class="eachScorer">
										<label>Bob</label>
										<p>30 Sec</p>
									</div>
									<div class="eachScorer">
										<label>Josh</label>
										<p>32 Sec</p>
									</div>
									<div class="eachScorer">
										<label>Dan</label>
										<p>40 Sec</p>
									</div>
									<div class="eachScorer">
										<label>Sally</label>
										<p>48 Sec</p>
									</div>
									<div class="eachScorer">
										<label>Jill</label>
										<p>52 Sec</p>
									</div>
								</div>
                                
                                
							</div>
                            -->
                            <div class="gameCredit">
								<h3>Select Charity</h3>
                                <span>
                          <?php  echo "<select style='color: #ff6666;width: 95%;font-size:14px;' id='charity2".$row['id']."' name='charity2".$row['id']."' style='border-radius:2px;padding:2px;'>";
                  echo "<option value=''>Select Charity</option>";
                  $charity="select * from charity_under_user where User_ID='".$_SESSION['userSession']."' and approved='Yes'";
                  $charity_rs=mysqli_query($db,$charity) or die("Cannot Execute query".mysqli_error($db));
                  while($charity_row=mysqli_fetch_array($charity_rs))
                  {
                    echo "<option value='".$charity_row['ID']."'>".$charity_row['name']."</option>";
                    }
                  
                  ECHO "</select><br><a style='color:#ffffff;' href='#' data-id='".$row['id']."' data-toggle='modal' data-target='#charityModal' class='charitymodal'><font size='1px'><b>Add Charity</b></font></a><br>";
                  ?>
                  </span>
							</div>
                            <?php
               // echo "op=".$row['winner_option'];
                if($row['winner_option']==1)
                {
                    ?>
                        <div class="gameCredit">
								<h3>Game End Date:</h3>
                                <span>
                        
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
                if($row['winner_option']==2)
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
                if($row['winner_option']==3)
                {
                    ?>
                    <div class="gameCredit">
								<h3>Game End Date:</h3>
                                <span>
                        
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
							<div class="yourCredit">
								<h3>Your Credits</h3>
								<span><?php echo $mycredits?></span>
							</div>
							<div class="gameCredit">
								<h3>Valued Game Credits</h3>
								<span><?php echo $modalval;?></span>
							</div>
							<div class="playCredit">
								<h3>Credits to Play</h3>
								<span><?php echo $row["cost"]?></span>
                                <input type="hidden" name="cost_<?php echo $row['id']?>" id="cost_<?php echo $row['id']?>" value="<?php echo $row["cost"]?>">
							</div>
                            
							<button class="play-btn" type="button" onclick='play("<?php echo $row['id'] ?>",1,0,"<?php echo $row['type']?>")'>Play</button>

						</div>
					</div>
				</div>
			</div>
		</div>
				<?php if($countrow==5){?>	</div> <?php }?>
                
				
<?php
if($countrow==5)
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
?>
<nav class="pg-pagination">
				    	<ul>
                        <?php 
                        $sql1 = "SELECT g.id as id,g.Publish as Publish,g.game_desc as game_desc,g.Game_Image as gameimage,g.name as name, g.type as type ,g.user_id as user_id, g.credit_cost as cost,g.value_of_the_game as valueofthegame, g.win_credit as winc ,g.game_desc as gdesc from game g where g.user_id!=".$user_id." and g.Publish='Yes' and g.Status='Running' and g.id not in (select Game_ID from users_game where User_ID='".$user_id."') ".$con."  order by g.credit_cost asc";
  
                        $rs_result = mysqli_query($db,$sql1); //run the query
                          $total_records = mysqli_num_rows($rs_result);  //count number of records
                         $total_pages = ceil($total_records / $num_rec_per_page); 
                        
                        //echo "<a href='pagination.php?page=1'>".'|<'."</a> "; // Goto 1st page  
                        $pre=$page-1;
                        if($pre==0)
                        {
                            $pre=1;
                        }
                        $next=$page+1;
                        if($page!=$total_pages)
                        {
                            $next=$page+1;
                        }
                        else
                        {
                            $next=$page;
                        }
                        ?>
                        <li class="prev">
			      				<a href="<?php echo $scriptname?>?page=<?php echo $pre;?>&id=<?php echo $_REQUEST['id']?>&min=<?php echo $_REQUEST['min']?>&max=<?php echo $_REQUEST['max']?>&valuemin=<?php echo $_REQUEST['valuemin']?>&valuemax=<?php echo $_REQUEST['valuemax']?>&ratingval=<?php echo $_REQUEST['ratingval']?>&charityval=<?php echo $_REQUEST['charityval']?>">
			        				<i class="fa fa-chevron-left"></i>
			      				</a>
			    			</li>
                        <?php
                        for ($i=1; $i<=$total_pages; $i++) { 
                            ?>
                            <li <?php if($i==$page) echo "class='active' "?> ><a href="<?php echo $scriptname?>?page=<?php echo $i;?>&id=<?php echo $_REQUEST['id']?>&min=<?php echo $_REQUEST['min']?>&max=<?php echo $_REQUEST['max']?>&valuemin=<?php echo $_REQUEST['valuemin']?>&valuemax=<?php echo $_REQUEST['valuemax']?>&ratingval=<?php echo $_REQUEST['ratingval']?>&charityval=<?php echo $_REQUEST['charityval']?>"><?php echo $i;?></a></li>
                            <?php
                                    //echo "<a href='pagination.php?page=".$i."'>".$i."</a> "; 
                        }; 
                       // echo "<a href='pagination.php?page=$total_pages'>".'>|'."</a> "; // Goto last page
                        ?>
                        <li class="next">
			      				<a href="<?php echo $scriptname?>?page=<?php echo $next;?>&id=<?php echo $_REQUEST['id']?>&min=<?php echo $_REQUEST['min']?>&max=<?php echo $_REQUEST['max']?>&valuemin=<?php echo $_REQUEST['valuemin']?>&valuemax=<?php echo $_REQUEST['valuemax']?>&ratingval=<?php echo $_REQUEST['ratingval']?>&charityval=<?php echo $_REQUEST['charityval']?>">
			        				<i class="fa fa-chevron-right"></i>
			      				</a>
			    			</li>

			    		<!--	<li data-toggle="tab">
				    			<span>Go to</span>
				    			<input type="text">
			    			</li>
                            -->
				  		</ul>
					</nav>
<?php
 
} else {
    
    echo "<center><font color='#ff6666'>No Games Yet</font></center>";
}
   //echo $sql;
 // $DBcon->close();
?>
                  
                  <!--   </div> -->
              
              
    <?php
}
?>