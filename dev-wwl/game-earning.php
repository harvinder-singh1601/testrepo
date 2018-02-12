<?php 
include 'dbConfig.php';
$page_title = "Game Earnings";
$page_description = "Display Game Earnings";
include("header.php"); 
?>
			
			<!--==Other Tab Pages==-->
			<div class="otherPages">
				<!--Tab Aside Nav-->
			<?php include "sidebar.php";?>
				
				<!--Game Earning Area-->
				<div class="game-earning-area">
					<div class="game-earning-content">
						<div class="row">
							<div class="col-sm-9">
								<div class="gecLeft">
									<div class="earning-chart">
										<!--there will be earning chart-->
									</div>

									<div class="earningChart-control">
										<div class="eccLeft">
											<ul>
												<li class="ecc-overall in"> 
													<div class="ecc-select">
														<ul>
															<li class="active">
																<img src="assets/img/log-ico/remember-cross.png" alt="tick-ico">
															</li>
															<li>
																<img src="assets/img/log-ico/remember-tick.png" alt="tick-ico">
															</li>
														</ul>
													</div>
													<p>Earnings Overall</p>
												</li>
												<li class="ecc-eMonth">
													<div class="ecc-select">
														<ul>
															<li>
																<img src="assets/img/log-ico/remember-cross.png" alt="tick-ico">
															</li>
															<li class="active">
																<img src="assets/img/log-ico/remember-tick.png" alt="tick-ico">
															</li>
														</ul>
													</div>
													<p>Earnings this Month</p>
												</li>
												<li class="ecc-Charities">
													<div class="ecc-select">
														<ul>
															<li>
																<img src="assets/img/log-ico/remember-cross.png" alt="tick-ico">
															</li>
															<li class="active">
																<img src="assets/img/log-ico/remember-tick.png" alt="tick-ico">
															</li>
														</ul>
													</div>
													<p>Charities</p>
												</li>
											</ul>
										</div>
										<div class="eccRight">
											<button type="button">Purchase Credits</button>
											<button type="button">Deposit Credits</button>
										</div>
									</div>

									<div class="earningsBankInfo">
										<div class="each-ebi">
											<label>Bank Account 1</label>
											<p>80% Deposited = $1500 </p>
										</div>
										<div class="each-ebi">
											<label>Bank Account 2</label>
											<p>20% Deposited = $500 </p>
										</div>
										<div class="each-ebi">
											<label>Default Charity</label>
											<p>Extra Life</p>
										</div>
									</div>
								</div>
							</div>
							<div class="col-sm-3">
								<div class="gecRight">
									<div class="month-earningsInfo">
										<div class="thisMonthName">
											<h2>September</h2>
										</div>
										<div class="mei-totalCredit">
											<h3>Total Credits</h3>

											<div class="thisMonthCredit">
												<h3>This Month</h3>
												<span>500</span>
											</div>
										</div>
										
										<div class="mei-earnedCredit">
											<h4>Credits Earned</h4>
											<span>450</span>
										</div>

										<div class="mei-creditDonate">
											<h4>Credits Donated</h4>
											<span>250</span>
										</div>
									</div>
								</div>
							</div>
						</div>

					</div>
				</div>
				<!--tab Indicator-->	
			
			</div>
				
		</div>


								<?php include("footer.php"); ?>

