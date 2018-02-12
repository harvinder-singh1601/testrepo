<?php
include 'dbConfig.php';
$page_title = "Charity-Manager";
$page_description = "View and Add Charities";
include("header.php");
?>
			<!--==Other Tab Pages==-->
			<div class="otherPages">
				<!--Tab Aside Nav-->
				<?php include "sidebar.php"?>

				<div id="game-dp-area">

					<!--Game Manager-->
					<div id="gameDP">
						<!--Draft Section-->
						<div class="drafts">
							<h2>Pending</h2>
							<div class="dContent">
								<div class="dContent-inner">
									<div class="row">
										<div class="col-xs-4 item list-style">
											<div class="each-draft">
												<div class="each-dContent">
													<div class="dcImage">
														<img src="assets/img/dcimage-1.png" alt="Draft Image1">
													</div>
													<div class="dcInfo">
														<div class="dgType">
															<label>Type of Game</label>
															<p>Puzzle</p>
														</div>
														<div class="dgTitle">
															<label>Game Title</label>
															<p>???</p>
														</div>
														<div class="dgCharity">
															<label>Charity</label>
															<p>American Red Cross</p>
														</div>
														<div class="dgCredit">
															<label>Credit Amount</label>
															<p>1000</p>
														</div>
														<div class="dgtoPlay">
															<label>Amount to Play</label>
															<p>100</p>
														</div>
														<div class="dgDate">
															<label>Game Title</label>
															<p>Publish Date</p>
														</div>
													</div>
												</div>
											</div>
										</div>


									</div>

								</div>
							</div>
							<div class="item-style">
								<a href="" class="dList in"><i class="fa fa-th-list"></i></a>
								<a href="" class="dGrid"><i class="fa fa-th-large"></i></a>
							</div>
						</div>

						<!--Published Section-->
						<div class="publishedG">
							<h2>Approved</h2>
							<div class="pContent">
								<div class="pContent-inner">
                  <?php
                   $show_charity="select * from charity_under_user where  User_ID='".$_SESSION['userSession']."'";
                  $rs_charity=mysqli_query($DBcon,$show_charity) or die("Cannot Execute Query".mysqli_error());
                  $j=1;
                  $countrow=0;
                  while($row_charity=mysqli_fetch_array($rs_charity))
                  {
                     ?>
                     <?php if($countrow==0){?>	<div class="row"><?php } ?>
                      <?php $countrow=$countrow+1; ?>
										<div class="col-xs-4 item">
											<div class="each-publish">
												<div class="each-pContent">
													<div class="pcImage">
                            <?php
                            if($row_charity['Image']!="")
                            {
                            ?>
                            <img width="50px" height="50px" src='<?php echo $row_charity['Image']?>'>
                            <?php
                            }

                            else{ ?>
														<img src="assets/img/dcimage-1.png" alt="Draft Image1">
                          <?php } ?>
													</div>
													<div class="pcInfo">
														<h5 class="pcgName" id='type_row<?php echo $j;?>'><?php echo $row_charity['name']?></h5>
														<div class="pCreditEarned">
															<label>Address</label>
															<p><?php echo $row_charity['Address']?></p>
														</div>
														<div class="pValue">
															<label>Contact Personnel</label>
															<p><?php echo $row_charity['Contact_personnel']?></p>
														</div>
														<div class="pCharity">
															<label>Non-profit-501c3</label>
															<p><?php echo $row_charity['non_profit_501c3']?></p>
														</div>
													</div>
												</div>
											</div>
											<div class="pStats">
												<p>Stats</p>
											</div>
										</div>
                  <?php if($countrow==3){?>	</div> <?php }?>
                  <?php
                  if($countrow==3)
                  {
                      $countrow=0;
                  }
                  }
                  if($countrow!=0)
                  {
                      echo "</div>";
                  }
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

        				<!--Add new Charity popup: Style as revenue popup-->
        		<div class="charityModalpoup" id="charityModal-area">
        			<div class="modal fade"  id="charityModal">
        				<div class="modal-dialog">
        					<div class="paywithdraw-Content">
        						<div class="pw-header">
        					        <button type="button" class="close" data-dismiss="modal">&times;</button>
        					        <h2 class="modal-title">Add Charity</h2>
        					    </div>

        				      <div class="pw-form">
        				      	<div class="efItem">
        					        <label>Charity Image:</label>
        							<div class="gIconPreview">
        								<img src="assets/img/dcimage-1.png" alt="Game Image">
        								<label>
        									Upload Image
        									<input type="file">
        								</label>
        							</div>
        				        </div>

        				        <div class="efItem">
        					        <label>Charity Name:</label>
                      				<input type="text" onkeyup="showResult(this.value,'resultmodal','modal')" name="charity_game_name" id="charity_game_name" required value="">
        				        </div>

        				        <div class="efItem">
        					        <label>Charity Address:</label>
                      				<input type="text" name="charity_address" id="charity_address" value="">
        				        </div>

        				        <div class="efItem">
        					        <label>Charity Contact Personnel:</label>
                      				<input type="text" name="charity_contact" id="charity_contact" value="">
        				        </div>

        				        <div class="efItem">
        					        <label>Charity Phone:</label>
                      				<input type="text" name="charity_phone" id="charity_phone" value="">
        				        </div>

        				        <div class="efItem">
        					        <label>Charity Tax ID:</label>
                      				<input type="text" name="charity_tax" id="charity_tax" value="">
        				        </div>


        				        <div class="efItem">
        					        <label>Charity Description:</label>
                      				<input type="text" name="charity_description" id="charity_description" value="">
        				        </div>
        				        <div class="efItem">
        					        <label>Non-Profit-501c3:</label>
        					        <div class="custom-tick">
                      					<input type="checkbox" name="charity_non-profit" id="charity_non-profit" value="1">
                      				</div>
        				        </div>
        				        <button type="submit">Add Charity</button>
        				      </div>

        					</div>
        				</div>
        			</div>
        		</div>
        	</div>
        </div>

		<!--== Footer Area==-->
    <?php include("footer.php"); ?>
