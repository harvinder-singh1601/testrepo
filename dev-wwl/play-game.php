<?php
$page_title = "Play Games";
$page_description = "Games-Active";
include("header.php");
include 'dbConfig.php';
$scriptname="play-game.php";
$num_rec_per_page=10;
$totalcredits_cr="select sum(Credits) as credits_cr from payments where status=1 and User_ID='".$_SESSION['userSession']."'";
$cr_rs=mysqli_query($DBcon,$totalcredits_cr) or die("Cannot Execute query".mysqli_error($DBcon));
$cr_row=mysqli_fetch_array($cr_rs);
$total_credit_cr=$cr_row['credits_cr'];

$totalcredits_db="select sum(Credits) as credits_cr from payments where status=2 and User_ID='".$_SESSION['userSession']."'";
$db_rs=mysqli_query($DBcon,$totalcredits_db) or die("Cannot Execute query".mysqli_error($DBcon));
$db_row=mysqli_fetch_array($db_rs);
$total_credit_db=$db_row['credits_cr'];
$mycredits=$total_credit_cr-$total_credit_db;
?>
<input type="hidden" name="mycredits_value" id="mycredits_value" value="<?php echo $mycredits;?>">
<input type="hidden" name="gameid" id="gameid" value="">


			<!--==Play Game Page==-->
			<div id="play-game-area">

				<div class="play-game" style="display: block;">
               <center> <div id="imagediv" style="display: none;"> <img  src="images/loading.gif" ></div></center>
                <div id="play-game">


   <?php
   $user_id= $_SESSION['userSession'];
   if (isset($_GET["page"])) { $page  = $_GET["page"]; } else { $page=1; };
$start_from = ($page-1) * $num_rec_per_page;
$con="";
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
if(($_REQUEST['charityval']!="0")and ($_REQUEST['charityval']!=""))
{

     $con.=" and g.id IN (select game_id from user_charity where charity_id='".$_REQUEST['charityval']."' and name!='')";

}
  $sql = "SELECT g.id as id,g.Min_credits as Min_credits, g.winner_option as winner_option,g.Game_Image as gameimage ,g.game_desc as game_desc,g.name as name, g.type as type ,g.user_id as user_id, g.credit_cost as cost,g.value_of_the_game as valueofthegame, g.win_credit as winc ,g.game_desc as gdesc,g.Publish_Date as publishdate,g.End_Day as End_Day,g.End_Hour as End_Hour,g.End_Minute as End_Minute  from game g where g.user_id!=".$user_id." and g.Publish='Yes' and g.Status='Running' and g.id not in (select Game_ID from users_game where User_ID='".$user_id."') ".$con." order by g.credit_cost asc LIMIT $start_from, $num_rec_per_page";

$result = $DBcon->query($sql);

if ($result != null) {
    $modalwin=1;
    $countrow=0;
    while($row = $result->fetch_assoc()) {
        $modalval="";
        $val="";
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
				<?php if($countrow==0){?>	<div class="play-row"><?php } ?>
               <?php
               $countrow=$countrow+1;
               ?>
               <!-- Play game pop up -->
						<!--<div class="each-play-game" data-toggle="modal" data-target="#playGame<?php echo $modalwin;?>">-->
                        <div class="each-play-game" onclick="view('<?php echo $row['id']?>')">
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
                  $charity_rs=mysqli_query($db,$charity) or die("Cannot Execute query");
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
                                <span style="font-size: 14px;">

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

							<button class="play-btn" type="button" onclick='play("<?php echo $row['id'] ?>",1,0,"<?php echo $row['type']?>","<?php echo $modalwin;?>")'>Play</button>

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

//end while loop
if($countrow!=0)
{
    echo "</div>";
}
}
//end if

?>



					<nav class="pg-pagination">
				    	<ul>
                        <?php
                        $sql = "SELECT g.id as id,g.Min_credits as Min_credits, g.winner_option as winner_option,g.Game_Image as gameimage ,g.game_desc as game_desc,g.name as name, g.type as type ,g.user_id as user_id, g.credit_cost as cost,g.value_of_the_game as valueofthegame, g.win_credit as winc ,g.game_desc as gdesc,g.Publish_Date as publishdate,g.End_Day as End_Day,g.End_Hour as End_Hour,g.End_Minute as End_Minute  from game g where g.user_id!=".$user_id." and g.Publish='Yes' and g.Status='Running' and g.id not in (select Game_ID from users_game where User_ID='".$user_id."') ".$con." order by g.credit_cost asc";
                        $rs_result = mysqli_query($DBcon,$sql); //run the query
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
			      				<a href="<?php echo $scriptname?>?page=<?php echo $pre?>&id=<?php echo $_REQUEST['id']?>&min=<?php echo $_REQUEST['min']?>&max=<?php echo $_REQUEST['max']?>&valuemin=<?php echo $_REQUEST['valuemin']?>&valuemax=<?php echo $_REQUEST['valuemax']?>&ratingval=<?php echo $_REQUEST['ratingval']?>&charityval=<?php echo $_REQUEST['charityval']?>">
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
                    </div>
				</div>

				<div class="play-filter">
                <div style="float: right;padding-right:12px;"><a style="color:#ff6666;" href="<?php echo $scriptname?>">Clear Filter</a>
                </div>
					<div class="pg-review">

						<h3>Reviews</h3>
						<div class="rating">
						  <label <?php if($_REQUEST['ratingval']==5) echo "class='selected'"?>   >
						    <input type="radio"  name="rating" value="5" onclick="change('5','rating')" title="5 stars"> 5
						  </label>
						  <label  <?php if($_REQUEST['ratingval']==4) echo "class='selected'"?>>
						    <input type="radio"  name="rating" value="4" onclick="change('4','rating')" title="4 stars"> 4
						  </label>
						  <label  <?php if($_REQUEST['ratingval']==3) echo "class='selected'"?>>
						    <input type="radio"  name="rating" value="3" onclick="change('3','rating')" title="3 stars"> 3
						  </label>
						  <label  <?php if($_REQUEST['ratingval']==2) echo "class='selected'"?>>
						    <input type="radio"  name="rating" value="2" onclick="change('2','rating')" title="2 stars"> 2
						  </label>
						  <label  <?php if($_REQUEST['ratingval']==1) echo "class='selected'"?>>
						    <input type="radio"  name="rating" value="1" onclick="change('1','rating')" title="1 star"> 1
						  </label>
						</div>
					</div>
                    <input type="hidden" name="ratingval" id="ratingval" value="<?php echo $_REQUEST['ratingval']?>">
					<select id="gametype" name="gametype" onchange="change('1','gametype')">
						<option value="">Type of Game</option>
                        <?php
                      $gametype="select * from gametype";
                      $gametype_rs=mysqli_query($DBcon,$gametype) or die("Cannot Execute Query".mysqli_error($DBcon));

                      ?>
                      <?php
                      while($gametyperow=mysqli_fetch_array($gametype_rs))
                      {?>
                      <option <?php if($_REQUEST['id']==$gametyperow['id']) echo 'selected';?> value="<?php echo $gametyperow['id']?>"><?php echo $gametyperow['name']?></option>


                      <?php
                      }
                      ?>
              <input type="hidden" name="gametypeval" id="gametypeval" value="<?php echo $_REQUEST['id'];?>">
						<option value="item 1"> item 1</option>
					</select>
					<div class="filter-price">
						<h3>Cost to Play</h3>
						  <input type="text" id="cost-amount" readonly>

						<div id="cost-range"></div>
					</div>

					<div class="filter-price">
						<h3>Value of Game</h3>
						  <input type="text" id="value-amount" readonly>

						<div id="value-range" ></div>
					</div>
					<!--<select>
						<option>Value of Game</option>
						<option value="item 1"> item 1</option>
					</select>


					<select>
						<option>Cost to Play</option>
						<option value="item 1"> item 1</option>
					</select>-->
					<select id="charity" name="charity" onchange="change('charity','charity')">
						<option value="0">Type of Charity</option>
						<?php
                $charity="select uc.* from user_charity as uc,game as g where uc.game_id=g.id and uc.user_id=g.user_id and g.Publish='Yes' and  uc.name !='' and g.user_id!=".$_SESSION['userSession']." and g.Status='Running' and g.id not in (select Game_ID from users_game where User_ID='".$_SESSION['userSession']."')   group by  uc.name";
                $charity_rs=mysqli_query($DBcon,$charity) or die("cannot Execute".mysqli_error($DBcon));
                while($charity_row=mysqli_fetch_array($charity_rs))
                {
                    ?>
                    <option <?php if($_REQUEST['charityval']==$charity_row['charity_id']) echo "selected";?>  value="<?php echo $charity_row['charity_id']?>"><?php echo $charity_row['name']?></option>
                    <?php
                }
                ?>
					</select>
				<!--	<div class="play-search">
						<input type="search" placeholder="Search for a Charity">
						<img src="assets/img/search-ico.png" alt="">
					</div> -->
				</div>

				<!--tab Indicator-->
				<!-- <div class="tab-indicator">
					<ol>
						<li>
						  <a href="game-draft-publish.php" >
						    <img src="assets/img/manager.png" alt="Game Manager">
						  </a>
						</li>
						<li>
						  <a href="#"  data-toggle="modal" data-target="#gameCreation">
							<img src="assets/img/creation.png" alt="Game Creation">
						  </a>
						</li>
						<li class="active">
						  <a href="play-game.php">
							<img src="assets/img/play.png" alt="Play Games">
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
			</div> -->

		</div>
</div>

		<!--charity Popup-->


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
	<!--Playing Game PopUp-->
        <div class="gamePlaying" id="gamePlaying-area">
			<div class="modal fade"  id="gamePlaying">
				<div class="modal-dialog">
                <div class="playingGameFrame" style="padding: 20px;width:100%;">
                        <iframe id="iframegame1" style="padding: 5px;" src="" name="bestgameever" width="1100" height="1000" frameborder="0" scrolling="no"></iframe>
				</div>
				</div>
			</div>
		</div>

		<!--== Footer Area==-->
		<?php include("footer.php");
  $maxcredits="select max(credit_cost) as totalcredit from game";
  $maxcredits_rs=mysqli_query($DBcon,$maxcredits) or die("Cannot Execute query".mysqli_error($DBcon));
  $maxcredits_row=mysqli_fetch_array($maxcredits_rs);

   $maxvalue="select max(value_of_the_game) as totalvalueofthegame from game";
  $maxvalue_rs=mysqli_query($DBcon,$maxvalue) or die("Cannot Execute query".mysqli_error($DBcon));
  $maxvalue_row=mysqli_fetch_array($maxvalue_rs);

   $minvalue="select min(value_of_the_game) as minvalueofthegame from game";
  $minvalue_rs=mysqli_query($DBcon,$minvalue) or die("Cannot Execute query".mysqli_error($DBcon));
  $minvalue_row=mysqli_fetch_array($minvalue_rs);

  $maxcredits="select max(credit_cost) as totalcredit from game";
  $maxcredits_rs=mysqli_query($DBcon,$maxcredits) or die("Cannot Execute query".mysqli_error($DBcon));
  $maxcredits_row=mysqli_fetch_array($maxcredits_rs);

  if($_REQUEST['min']!="" and $_REQUEST['max']!="")
  {
    $max=$_REQUEST['max'];
    $min=$_REQUEST['min'];
  }
  else
  {
    $min=0;
    $max=$maxcredits_row['totalcredit'];
  }
  if($_REQUEST['valuemin']!="" and $_REQUEST['valuemax']!="")
  {
    $valuemax=$_REQUEST['valuemax'];
    $valuemin=$_REQUEST['valuemin'];
  }
  else
  {
    $valuemin=$minvalue_row['minvalueofthegame'];
    $valuemax=$maxvalue_row['totalvalueofthegame'];
  }

  ?>

    <script>
  //For cost range
     $( function() {
      $( "#cost-range" ).slider({
        range: true,
        min: 0,
        max: '<?php echo $maxcredits_row['totalcredit']?>',
        values: [ <?php echo $min?>, <?php echo $max?>],
        slide: function( event, ui ) {
          $( "#cost-amount" ).val( ui.values[ 0 ] + " - " + ui.values[ 1 ] +" Credits" );
        }
      });
      $( "#cost-amount" ).val( "" + $( "#cost-range" ).slider( "values", 0 ) +
        " - " + $( "#cost-range" ).slider( "values", 1 ) +" Credits" );
    } );
    //For value range
     $( function() {
      $( "#value-range" ).slider({
        range: true,
        min: <?php echo $minvalue_row['minvalueofthegame']?>,
        max: <?php echo $maxvalue_row['totalvalueofthegame']?>,
        values: [ <?php echo $valuemin ?>, <?php echo $valuemax?> ],
        slide: function( event, ui ) {
          $( "#value-amount" ).val( "" + ui.values[ 0 ] + " - " + ui.values[ 1 ] +" Credits");
        }
      });
      $( "#value-amount" ).val( "" + $( "#value-range" ).slider( "values", 0 ) +
        " - " + $( "#value-range" ).slider( "values", 1 ) +" Credits" );
    } );



</script>
        <script>
        //Function for play button
            function play(a,butval,modalwin,type1,popup)
{
    var id=a;
             document.getElementById("gameid").value=a;
         var cost=parseInt(document.getElementById("cost_"+id).value);
         var mycredits=parseInt(document.getElementById("mycredits_value").value);
          var charity2=document.getElementById("charity2"+a).value;
    if(charity2!="")
    {
         if(mycredits>=cost)
         {
         var ans=confirm("If you play this game then "+cost+" credits will deduct from your account. Once the game is unlocked, you can't be stopped or reset. Continue to play the game?. Are you sure you want to proceed?");
         if(ans==true)
         {
            if(butval=="2")
            {
                 var hangoutButton = document.getElementById("closemodal"+modalwin);
                hangoutButton.click();
            }
            //alert(charity2);
            $.ajax({
        type: "POST",
        url: "credit_for_game.php",
        data:{credits:cost,game:a,charity2:charity2},
        success: function(data){
            alert(data);
            if(data!=1)
            {
         var $iframe = $('#iframegame1');
         alert(type1);
         if(parseInt(type1)==3)
         {
            var url="quiz_game.php?game_id="+document.getElementById("gameid").value;
         }
         else if(parseInt(type1)==2)
         {
            var url="2048_game/2048/2048.php?game_id="+document.getElementById("gameid").value;
         }
         else
         {
            var url="puzzle_1.php?id="+document.getElementById("gameid").value;
         }

          alert(url);
          $('#gamePlaying').modal('toggle');
          $('#playGame'+popup).modal('toggle');
          $iframe.attr('src',url);




          }
          else
          {
            alert("Sorry! You don't have sufficient Credits for this game. Please Buy Credits");
          }

         }

        });

}
}
else
{
    alert("Sorry! You don't have sufficient Credits for this game. Please Buy Credits");
    window.open("pay.php","Buy Credits","width=550,height=470,0,status=0,");
}
}
else
{
    alert("Please first Select Charity");
}
}
  //function for charity add
  function addcharity()
{
    var boxid=document.getElementById("box").value;

    var charity_name=document.getElementById("charity_game_name").value;


 if (charity_name== ''){

       alert('Please select the charity ');
 }
 else
 {
    $.ajax({
        type: "POST",
        url: "ajax_charity.php",
        data:{action:"addbyid",id:charity_name},
        success: function(data){

            var res = data.split(":");
         if(res[0]>0)
         {
            alert("Charity Added");
           //$('#logIn').modal('hide');
            //var select = document.getElementById('charity_id');
           // alert(boxid);
            $("#charity2"+boxid).append("<option value='" + res[0] + "' selected >" + res[1] + "</option>");
            document.getElementById("charityModal").style.display="none";


        }
         else
         {
            alert(data);
         }




        }
      });




}

}
//functionality on charity pop up show
$(document).on("click", ".charitymodal", function () {
     var myBookId = $(this).data('id');
     //alert(myBookId);
     $(".modal-dialog #box").val( myBookId );
     // As pointed out in comments,
     // it is superfluous to have to manually call the modal.
     // $('#addBookDialog').modal('show');
});

//function for 3 filters type of game,ratings and charity

function change(id,val)
{
     document.getElementById("imagediv").style.display="inline";
     document.getElementById("play-game").style.display="none";
    // alert(val);
    if(val=="gametype")
    {
        var charityval=document.getElementById("charity").value;
        //alert(document.getElementById("gametype").value);
        document.getElementById("gametypeval").value=document.getElementById("gametype").value;
        var ratingval=document.getElementById("ratingval").value;
        var idval=document.getElementById("gametype").value;
    }
    else if(val=="rating")
    {
        var charityval=document.getElementById("charity").value;
        document.getElementById("ratingval").value=id;
        var idval=document.getElementById("gametypeval").value;
        var ratingval=id;
    }
    else if(val=="charity")
    {
        var charityval=document.getElementById("charity").value;
        var ratingval=document.getElementById("ratingval").value;
        var idval=document.getElementById("gametypeval").value;
    }
    else
    {
        var idval=document.getElementById("gametypeval").value;
        var ratingval=document.getElementById("ratingval").value;
        var charityval=document.getElementById("charity").value;

    }
    //alert("there");
     var min = $("#cost-range").slider("option", "values")[0],
      max = $("#cost-range").slider("option", "values")[1];
      // alert("there2");
       var valuemin = $("#value-range").slider("option", "values")[0],
      valuemax = $("#value-range").slider("option", "values")[1];

    $.ajax({
        type: "POST",
        url: "search_game.php",
        data:{id:idval,val:val,min:min,max:max,valuemin:valuemin,valuemax:valuemax,page:"game",ratingval:ratingval,charityval:charityval},
        success: function(data){
             document.getElementById("imagediv").style.display="none";
            //alert(data);
            document.getElementById("play-game").style.display="inline-block";
            document.getElementById("play-game").innerHTML=data;


         }

        });


}
   $(document).ready(function() {

    $('#cost-range').slider({

    change: function(event, ui) {
        document.getElementById("imagediv").style.display="inline";
         document.getElementById("play-game").style.display="none";
        //alert(ui.value);
        var min = $("#cost-range").slider("option", "values")[0],
      max = $("#cost-range").slider("option", "values")[1];
      var id=document.getElementById("gametypeval").value;
      var ratingval=document.getElementById("ratingval").value;
      var charityval=document.getElementById("charity").value;
    //alert("min: " + min+" max: " + max);

     var valuemin = $("#value-range").slider("option", "values")[0],
      valuemax = $("#value-range").slider("option", "values")[1];

    $.ajax({
        type: "POST",
        url: "search_game.php",
        data:{min:min,val:"creditcost",max:max,id:id,valuemin:valuemin,valuemax:valuemax,page:"game",ratingval:ratingval,charityval:charityval},
        success: function(data){
            //alert(data);
             document.getElementById("imagediv").style.display="none";
             document.getElementById("play-game").style.display="inline";
            document.getElementById("play-game").innerHTML=data;


         }

        });
    }
});

$('#value-range').slider({

    change: function(event, ui) {
         document.getElementById("imagediv").style.display="inline";
          document.getElementById("play-game").style.display="none";
        //alert(ui.value);
        var valuemin = $("#value-range").slider("option", "values")[0],
      valuemax = $("#value-range").slider("option", "values")[1];

        var min = $("#cost-range").slider("option", "values")[0],
      max = $("#cost-range").slider("option", "values")[1];
      var id=document.getElementById("gametypeval").value;
      var ratingval=document.getElementById("ratingval").value;
       var charityval=document.getElementById("charity").value;
    //alert("min: " + valuemin+" max: " + valuemax);
    $.ajax({
        type: "POST",
        url: "search_game.php",
        data:{min:min,max:max,id:id,valuemin:valuemin,valuemax:valuemax,page:"game",ratingval:ratingval,charityval:charityval},
        success: function(data){
            //alert(data);
             document.getElementById("imagediv").style.display="none";
             document.getElementById("play-game").style.display="inline";
            document.getElementById("play-game").innerHTML=data;


         }

        });
    }
});

    });

$(document).on("click", ".charitymodal", function () {
     var myBookId = $(this).data('id');
     //alert(myBookId);
     $(".modal-body #box").val( myBookId );
     // As pointed out in comments,
     // it is superfluous to have to manually call the modal.
     // $('#addBookDialog').modal('show');
});
function view(id)
{
    document.location="game-manager-play_games.php?id="+id;
}
        </script>
