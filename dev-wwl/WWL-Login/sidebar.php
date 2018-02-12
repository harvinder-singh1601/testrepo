<div class="otherAsideNav">
					<ul>
						<li <?php  if(strstr($_SERVER["SCRIPT_NAME"],"game-account.php")){ echo 'class="active"'; }?>><a href="game-account.php">Account</a></li>
						<li <?php  if((strstr($_SERVER["SCRIPT_NAME"],"game-draft-publish.php")) or (strstr($_SERVER["SCRIPT_NAME"],"played-game.php"))){ echo 'class="active"'; }?>><a href="game-draft-publish.php">Your Games</a>
							<ul class="your-games">
								<li <?php  if(strstr($_SERVER["SCRIPT_NAME"],"game-draft-publish.php")){ echo 'class="active"'; }?>><a href="game-draft-publish.php">Drafts</a></li>
								<li <?php  if(strstr($_SERVER["SCRIPT_NAME"],"game-draft-publish.php")){ echo 'class="active"'; }?>><a href="game-draft-publish.php">Published Games</a></li>
								<li <?php  if(strstr($_SERVER["SCRIPT_NAME"],"played-game.php")){ echo 'class="active"'; }?>><a href="played-game.php">Played Games</a></li>
							</ul>
						</li>
						<li <?php  if(strstr($_SERVER["SCRIPT_NAME"],"game-mycharity.php")){ echo 'class="active"'; }?>><a href="game-mycharity.php">Your Charities</a>
						
                            <ul class="your-games">
								<li <?php  if(strstr($_SERVER["SCRIPT_NAME"],"game-mycharity.php")){ echo 'class="active"'; }?>><a href="" data-toggle="modal" data-target="#charityModal">Add Charity</a></li>
							</ul>
            </li>
						<li <?php  if(strstr($_SERVER["SCRIPT_NAME"],"game-manager-calender.php")){ echo 'class="active"'; }?>><a href="game-manager-calender.php">Your Calender</a></li>
						<li <?php  if(strstr($_SERVER["SCRIPT_NAME"],"game-earning.php")){ echo 'class="active"'; }?>><a href="game-earning.php">Your Earnings</a></li>
					</ul>
				</div>