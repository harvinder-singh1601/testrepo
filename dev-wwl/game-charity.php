<?php 
$page_title = "Game Charity";
$page_description = "View Game Charities";
include("header.php"); 
?>

			<!--==Charity Page==-->
			<section class="charity-area">
				<div class="charity-tab">
					<h2>Choose one of our spotlight charities</h2>
					<ul class="charity-indicator">
						<li class="active">
							<a data-toggle="tab" href="#american-red">
								<img src="assets/img/charities/american-red-ico.png" alt="ico">
								<p>American Red Cross</p>
							</a>
						</li>
						<li>
							<a data-toggle="tab" href="#charity-water">
								<img src="assets/img/charities/american-red-ico.png" alt="ico">
								<p>Charity: Water</p>
							</a>
						</li>
						<li>
							<a data-toggle="tab" href="#heart-asso">
								<img src="assets/img/charities/american-red-ico.png" alt="ico">
								<p>American Heart Association</p>
							</a>
						</li>
						<li>
							<a data-toggle="tab" href="#big-cat">
								<img src="assets/img/charities/american-red-ico.png" alt="ico">
								<p>Big Cat Rescue</p>
							</a>
						</li>
						<li>
							<a data-toggle="tab" href="#best-friends">
								<img src="assets/img/charities/american-red-ico.png" alt="ico">
								<p>Best Friends Animal Society</p>
							</a>
						</li>
					</ul>

					<div id="charity-content" class="tab-content ">
						<div id="american-red" class="tab-pane fade in active">
							<div class="each-charity">
								<div class="row">
									<div class="col-sm-3">

										<img src="assets/img/charities/american-red.png" alt="American Red Cross">
									</div>
									<div class="col-sm-9">
										<h3>American Red Cross</h3>
										<p>There will be american red cross content. <br>There will be american red cross content. <br>There will be american red cross content.</p>
									</div>
								</div>
							</div>
						</div>
						<div id="charity-water" class="tab-pane fade">
							<div class="each-charity">
								<div class="row">
									<div class="col-sm-3">
										<img src="assets/img/charities/american-red.png" alt="">
									</div>
									<div class="col-sm-9">
										<h3>Charity: Water</h3>
										<p>There will be american red cross content</p>
									</div>
								</div>
							</div>
						</div>
						<div id="heart-asso" class="tab-pane fade">
							<div class="each-charity">
								<div class="row">
									<div class="col-sm-3">
										<img src="assets/img/charities/american-red.png" alt="">
									</div>
									<div class="col-sm-9">
										<h3>American Heart Association</h3>
										<p>There will be american red cross content</p>
									</div>
								</div>
							</div>
						</div>
						<div id="big-cat" class="tab-pane fade">
							<div class="each-charity">
								<div class="row">
									<div class="col-sm-3">
										<img src="assets/img/charities/american-red.png" alt="">
									</div>
									<div class="col-sm-9">
										<h3>Big Cat Rescue</h3>
										<p>There will be american red cross content</p>
									</div>
								</div>
							</div>
						</div>
						<div id="best-friends" class="tab-pane fade">
							<div class="each-charity">
								<div class="row">
									<div class="col-sm-3">
										<img src="assets/img/charities/american-red.png" alt="">
									</div>
									<div class="col-sm-9">
										<h3>Best Friends Animal Society</h3>
										<p>There will be american red cross content. <br>There will be american red cross content. <br>There will be american red cross content.</p>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>

				<div class="findCharity">
					<label>Let us help you find a Charity.</label>
					<div class="fc-search">
						<input type="text" placeholder="Search Charity Name or Location">
					</div>
				</div>
				<div class="listCharity">
					<a href="#" data-toggle="modal" data-target="#charityPopup">Look at our list of Charities</a> 
					<!-- #charityList -->

					<a href="#" class="addOwnCharity" data-toggle="modal" data-target="#charityModal">Add your own Charity</a>
				</div>

			</section>
			
			<!--Charity List Popup-->
			<div class="charityList" id="charityList-area">
				<div class="modal fade"  id="charityList">

					<div class="modal-dialog">
						<div class="clContent">
							<div class="clHead">
								<div class="clhLeft">
									<h2>Environmental Charities</h2>
								</div>
								<div class="clhRight">
									<p>Environmental Charities focus on ways to promote preservation, appreciation, and sustainable development for the environment. <br> The two primary subgroups for this type of charity are:</p>
									<ul>
										<li>Environmental Conservation & Protection</li>
										<li>Parks and Nature Centers</li>
									</ul>

								</div>
							</div>
							<div class="clTable">
								<div class="cTableHead">
									<div class="clcName">
										<h3>Charity</h3>
									</div>
									<div class="clcDescription">
										<h3>Description</h3>
									</div>
									<div class="clcAmount">
										<h3>Amount Donated to Date</h3>
									</div>
								</div>
								<div class="clTableContent">
									<div class="clTableRow">
										<div class="clThumbs">
											<img src="assets/img/charities/american-red-ico.png" alt="">
										</div>
										<div class="clcName">
											<p>American Red Cross</p>
										</div>
										<div class="clcDescription">
											<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce aliquet erat nisi, non finibus erat cursus et. Proin a dolor quis ligula rutrum fringilla. Aenean venenatis mi vitae semper scel erisque. Etiam feugiat hendrerit ultrices. Phasellus eu </p>
										</div>
										<div class="clcAmount">
											<p>$1,234,567.000</p>
										</div>
									</div>
									<div class="clTableRow">
										<div class="clThumbs">
											<img src="assets/img/charities/american-red-ico.png" alt="">
										</div>
										<div class="clcName">
											<p>American Red Cross</p>
										</div>
										<div class="clcDescription">
											<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce aliquet erat nisi, non finibus erat cursus et. Proin a dolor quis ligula rutrum fringilla. Aenean venenatis mi vitae semper scel erisque. Etiam feugiat hendrerit ultrices. Phasellus eu </p>
										</div>
										<div class="clcAmount">
											<p>$1,234,567.000</p>
										</div>
									</div>
									<div class="clTableRow">
										<div class="clThumbs">
											<img src="assets/img/charities/american-red-ico.png" alt="">
										</div>
										<div class="clcName">
											<p>American Red Cross</p>
										</div>
										<div class="clcDescription">
											<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce aliquet erat nisi, non finibus erat cursus et. Proin a dolor quis ligula rutrum fringilla. Aenean venenatis mi vitae semper scel erisque. Etiam feugiat hendrerit ultrices. Phasellus eu </p>
										</div>
										<div class="clcAmount">
											<p>$1,234,567.000</p>
										</div>
									</div>
									<div class="clTableRow">
										<div class="clThumbs">
											<img src="assets/img/charities/american-red-ico.png" alt="">
										</div>
										<div class="clcName">
											<p>American Red Cross</p>
										</div>
										<div class="clcDescription">
											<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce aliquet erat nisi, non finibus erat cursus et. Proin a dolor quis ligula rutrum fringilla. Aenean venenatis mi vitae semper scel erisque. Etiam feugiat hendrerit ultrices. Phasellus eu </p>
										</div>
										<div class="clcAmount">
											<p>$1,234,567.000</p>
										</div>
									</div>
									<div class="clTableRow">
										<div class="clThumbs">
											<img src="assets/img/charities/american-red-ico.png" alt="">
										</div>
										<div class="clcName">
											<p>American Red Cross</p>
										</div>
										<div class="clcDescription">
											<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce aliquet erat nisi, non finibus erat cursus et. Proin a dolor quis ligula rutrum fringilla. Aenean venenatis mi vitae semper scel erisque. Etiam feugiat hendrerit ultrices. Phasellus eu </p>
										</div>
										<div class="clcAmount">
											<p>$1,234,567.000</p>
										</div>
									</div>
									<div class="clTableRow">
										<div class="clThumbs">
											<img src="assets/img/charities/american-red-ico.png" alt="">
										</div>
										<div class="clcName">
											<p>American Red Cross</p>
										</div>
										<div class="clcDescription">
											<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce aliquet erat nisi, non finibus erat cursus et. Proin a dolor quis ligula rutrum fringilla. Aenean venenatis mi vitae semper scel erisque. Etiam feugiat hendrerit ultrices. Phasellus eu </p>
										</div>
										<div class="clcAmount">
											<p>$1,234,567.000</p>
										</div>
									</div>
								</div>
							</div>
							<nav class="charityList-pagination">
							    	<ul>
						   				<li class="prev">
						      				<a href="#">
						        				<i class="fa fa-chevron-left"></i>
						      				</a>
						    			</li>
						    			<li class="active" data-toggle="tab"><a href="#">1</a></li>
						    			<li data-toggle="tab"><a href="#">2</a></li>
						    			<li data-toggle="tab"><a href="#">3</a></li>
						    			<li data-toggle="tab"><a href="#">4</a></li>
						    			<li data-toggle="tab"><a href="#">5</a></li>
						    			<li class="next">
						      				<a href="#">
						      					<i class="fa fa-chevron-right"></i>
						      				</a>
						    			</li>
						    			<li data-toggle="tab">
							    			<span>Go to</span>
							    			<input type="text">
						    			</li>
							  		</ul>
							</nav>
						</div>
					</div>

				</div>
			</div>
			<!--Charity Popup-->
			<div class="charityPopup" id="charityPopup-area">
				<div class="modal fade"  id="charityPopup">

					<div class="modal-dialog">
						<div class="cpContent">
							<div class="row">
								<div class="col-xs-4">
									<div class="each-cp">
										<a href="" data-toggle="modal" data-target="#charityList" data-dismiss="modal">
											<h3>Arts & culture Charities</h3>
											<div class="cpImage">
												<img src="assets/img/game_type.png" alt="Game image">
											</div>
										</a>
									</div>
								</div>
								<div class="col-xs-4">
									<div class="each-cp">
										<a href="" data-toggle="modal" data-target="#charityList" data-dismiss="modal">
											<h3>Education Charities</h3>
											<div class="cpImage">
												<img src="assets/img/game_type.png" alt="Game image">
											</div>
										</a>
									</div>
								</div>
								<div class="col-xs-4">
									<div class="each-cp">
										<a href="" data-toggle="modal" data-target="#charityList" data-dismiss="modal">
											<h3>Health Charities</h3>
											<div class="cpImage">
												<img src="assets/img/game_type.png" alt="Game image">
											</div>
										</a>
									</div>
								</div>
							</div>

							<div class="row">
								<div class="col-xs-4">
									<div class="each-cp">
										<a href="" data-toggle="modal" data-target="#charityList" data-dismiss="modal">
											<h3>Animal Charities</h3>
											<div class="cpImage">
												<img src="assets/img/game_type.png" alt="Game image">
											</div>
										</a>
									</div>
								</div>
								<div class="col-xs-4">
									<div class="each-cp">
										<a href="" data-toggle="modal" data-target="#charityList" data-dismiss="modal">
											<h3>International NGOs</h3>
											<div class="cpImage">
												<img src="assets/img/game_type.png" alt="Game image">
											</div>
										</a>
									</div>
								</div>
								<div class="col-xs-4">
									<div class="each-cp">
										<a href="" data-toggle="modal" data-target="#charityList" data-dismiss="modal">
											<h3>Environmental Charities</h3>
											<div class="cpImage">
												<img src="assets/img/game_type.png" alt="Game image">
											</div>
										</a>
									</div>
								</div>
							</div>
						</div>
					</div>

				</div>
			</div>

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
