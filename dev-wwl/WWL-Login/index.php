<?php
$page_title = "Home";
$page_description = "Home-Page";
include("header.php");
?>



<!-- dashboard -->
			<div class="dashboard-container">
				<div class="main-content">
					<!-- top bar -->
					<div class="row">
						<div class="col-sm-3 top-bars orange">
							<div class="top-bars-content">
								<h3>100</h3>
								<p>Visitors</p>
							</div>
						</div>
						<div class="col-sm-3 top-bars red">
							<div class="top-bars-content">
								<h3>32K</h3>
								<p>Followers</p>
							</div>
						</div>
						<div class="col-sm-3 top-bars green">
							<div class="top-bars-content">
								<h3>55K</h3>
								<p>Following</p>
							</div>
						</div>
						<div class="col-sm-3 top-bars green-sea">
							<div class="top-bars-content">
								<h3>20K</h3>
								<p>Charities Supported</p>
							</div>
						</div>
					</div>
					<!-- spline chart -->
					<div class="spline-chart">
						<div class="row">
							<div class="col-sm-8">
								<div class="row">
									<div class="col-sm-8">
										<h3 class="spline-title">Revenue</h3>
									</div>
									<div class="col-sm-5">
										<div class="sorting-btn-spline">
											<div class="btn-group" role="group" aria-label="...">
											  <button type="button" class="btn btn-default">Week</button>
											  <button type="button" class="btn btn-default">Month</button>
											  <button type="button" class="btn btn-default">Year</button>
											</div>
										</div>
									</div>
								</div>
								<div id="chart-container">FusionCharts XT will load here!</div>
							</div>
							<div class="col-sm-4 spline-chart-col-4">
								<div id="donutchart"></div>
							</div>
						</div>
					</div>
					<!-- pie chart and notification -->
					<div class="row">
						<div class="col-sm-6">
								<div class="sorting-btn-donation">
									<div class="btn-group" role="group" aria-label="...">
									  <button type="button" class="btn btn-default">Week</button>
									  <button type="button" class="btn btn-default">Month</button>
									  <button type="button" class="btn btn-default">Year</button>
									</div>
								</div>
								<div id="columnchart_material"></div>
						</div>
						<div class="col-sm-6 notification">
							<h4 class="notification-h4">Notifications</h4>
							<div class="list-group">
							  <a href="#" class="list-group-item active">
							    <h4 class="list-group-item-heading">List group item heading</h4>
							    <p class="list-group-item-text">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s</p>
							  </a>
							  <a href="#" class="list-group-item">
							    <h4 class="list-group-item-heading">List group item heading</h4>
							    <p class="list-group-item-text">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s</p>
							  </a>
							  <a href="#" class="list-group-item">
							    <h4 class="list-group-item-heading">List group item heading</h4>
							    <p class="list-group-item-text">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s</p>
							  </a>
							  <a href="#" class="list-group-item">
							    <h4 class="list-group-item-heading">List group item heading</h4>
							    <p class="list-group-item-text">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s</p>
							  </a>
							</div>
						</div>
					</div>
				</div>
				<!-- main content ends -->

			<!-- dashboard ends -->
			</div>
	</div>
  
	<!-- spline js -->
	<script type="text/javascript" src="https://static.fusioncharts.com/code/latest/fusioncharts.js"></script>
	<script type="text/javascript" src="https://static.fusioncharts.com/code/latest/themes/fusioncharts.theme.fint.js?cacheBust=56"></script>
	<!-- google chart js -->
	<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
	<script type="text/javascript" src="assets/js/custom-spline.js"></script>


		<!--== Footer Area==-->
		<?php include("footer.php"); ?>
