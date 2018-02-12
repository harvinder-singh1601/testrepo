<?php
$page_title = "Game Account";
$page_description = "Games-Account";
include("header.php");
?>

			<!--==Other Tab Pages==-->
			<div class="otherPages">
				<!--Tab Aside Nav-->
				<?php include "sidebar.php" ?>


				<div id="game-account">
					<div class="account-area">
						<div class="gm-user-info">
							<div class="gmu-image">
								<img src="assets/img/log-ico/user-loged.png" alt="">
							</div>
							<div class="gmu-name">
								<label>Name</label>
								<input type="text" placeholder="Bob Ross" required>
							</div>
							<div class="gmu-add">
								<label>Address</label>
								<textarea placeholder="1234 Painters Way San francisco Ca, 90000" required></textarea>
							</div>
						</div>
						<div class="first-bank-row">
							<div class="ub-info">
								<label>Bank account 1</label>
								<input type="text" placeholder="Chase Checking">
							</div>
							<div class="ub-btn">
								<button>Show</button>
							</div>
						</div>
						<div class="second-bank-row">
							<div class="a-charity-info">
								<p>Default Charity</p>
							</div>
							<div class="ub-info">
								<label>Bank account 2</label>
								<input type="text" placeholder="Elevations Savings">
							</div>
							<div class="ub-btn">
								<button>Hide</button>
							</div>
						</div>
						<div class="extra-life">
							<input class="extraLife" type="text" placeholder="Extra Life">
							<input class="el-1" type="text" placeholder="123456789">
							<input class="el-2"type="text" placeholder="123456">
						</div>
					</div>
				</div>

				<!--tab Indicator-->
			
			</div>

		</div>


		<?php include("footer.php"); ?>
