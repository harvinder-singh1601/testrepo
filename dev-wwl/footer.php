		<footer>
			<div class="row">
				<div class="col-sm-5">
					<nav class="footerNav">
						<ul>
							<li><a href="game-draft-publish.php">Games Management</a></li>
							<li><a href="game-manager-calender.php">Calendar</a></li>
							<li><a href="game-manager-faq.php">FAQ</a></li>
							<li><a href="#">Support</a></li>
						</ul>
					</nav>
				</div>

				<div class="col-sm-3">
					<div class="foot">
						<!-- <p>WinWinLabs, All rights reserved.</p>
						<a>Terms And Conditions</a> -->
					</div>
				</div>

				<div class="col-sm-4">
					<nav class="footerNav" style="float: right">
						<ul>
							<li><a>Terms And Conditions</a></li>
							
						</ul>
					</nav>
				</div>
			</div>
		</footer>
		
	</div><!--Main Area-->
	


    
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
	<script src="assets/js/bootstrap.min.js"></script>
	<script src="assets/js/custom.js"></script>
    <script>
    <?php
if($openstripe==1)
{
    ?>
     $('#purchase-credit').modal('show');
    <?php
    
}
?>
    </script>
  </body>
</html>