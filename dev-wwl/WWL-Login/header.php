<!-- <?php
session_start();
//The session if user is inactive for 20
//minutes or more.
$expireAfter = 20;

//Check to see if our "last action" session
//variable has been set.
if(isset($_SESSION['last_action'])){
    
    //Figure out how many seconds have passed
    //since the user was last active.
    $secondsInactive = time() - $_SESSION['last_action'];
    
    //Convert our minutes into seconds.
    $expireAfterSeconds = $expireAfter * 60;
    
    //Check to see if they have been inactive for too long.
    if($secondsInactive >= $expireAfterSeconds){
        //User has been inactive for too long.
        //Kill their session.
  //       echo '<script language="javascript">';
		// echo 'alert("You will be logged out soon")';
		// echo '</script>';
        session_unset();
        session_destroy();
    }
    
}

?> -->
<?php
//Assign the current timestamp as the user's
//latest activity
$_SESSION['last_action'] = time();


include_once 'dbconnect.php';
include_once 'track.php';
if (!isset($_SESSION['userSession'])) {
	
  header("Location: login.php");
	exit;
}
if (isset($_SESSION['userSession'])) {
	if ($_SESSION['userSession']<=0) {
	header("Location: login.php");
	exit;
	}
}
?>

<!DOCTYPE html>
<html lang="en">
  <head>
	  <meta charset="utf-8"/>
	  <meta http-equiv="X-UA-Compatible" content="IE=edge">
	  <meta name="viewport" content="width=device-width, initial-scale=1"/>
	  <meta name="description" content=""/>
	  <title><?php echo $page_title; ?></title>
	  <meta http-equiv="description" content="<?php echo $page_description; ?>" />
	   <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
	  <link rel="stylesheet" href="assets/css/jquery.ui.css">
	  <link href="https://fonts.googleapis.com/css?family=Roboto:700,900" rel="stylesheet">
	  <link href="assets/css/bootstrap.min.css" rel="stylesheet"/>
	  <link href="assets/css/font-awesome.min.css" rel="stylesheet">
	  <link rel="stylesheet" href="assets/css/custom.css"  />

	 <script src="assets/js/jquery-1.10.2.min.js"></script>
	<style>
	#idlePrompt{
		 display:none;
		 font-size:28px;
		 z-index:999;
		 padding-top:30px;
		 position:absolute;
		 top:155px;
		 left:32%;
		 width:36%;
		 height:45vh;
	}
 
	#idlePrompt h3{
		padding:20px 0px 20px 0px;
		text-align:center;
	}
	#idlePrompt p{
		padding:10px 0px 10px 0px;
		text-align:center;
		font-size:14px;
	}

	#idlePrompt button {
		background: #ff5454;
		background-image: -webkit-linear-gradient(top, #ff5454, #db3737);
		background-image: -moz-linear-gradient(top, #ff5454, #db3737);
		background-image: -ms-linear-gradient(top, #ff5454, #db3737);
		background-image: -o-linear-gradient(top, #ff5454, #db3737);
		background-image: linear-gradient(to bottom, #ff5454, #db3737);
		-webkit-border-radius: 9;
		-moz-border-radius: 9;
		border-radius: 9px;
		font-family: Arial;
		color: #ffffff;
		font-size: 20px;
		padding: 10px 20px 10px 20px;
		text-decoration: none;
	}

	#idlePrompt button:hover {
		background: #db3737;
		background-image: -webkit-linear-gradient(top, #db3737, #ff5454);
		background-image: -moz-linear-gradient(top, #db3737, #ff5454);
		background-image: -ms-linear-gradient(top, #db3737, #ff5454);
		background-image: -o-linear-gradient(top, #db3737, #ff5454);
		background-image: linear-gradient(to bottom, #db3737, #ff5454);
		text-decoration: none;
	}

#thank{
	padding:10px;position:absolute;left:25%;color:red;
}
	</style>


  </head>

  <body>

	<div class="main">

		<!-- == Header Section==-->
		<header id="header">
			<div class="container">
				<div class="row">
					<div class="col-sm-5 col-xs-12">
						<div class="navArea">
							<nav class="mainnav">
								<ul>
									<li class="active"><a href="index.php" >Home</a></li>
									<li><a href="game-draft-publish.php">Games</a></li>
									<li><a href="game-charity.php">Charities</a></li>
									
								</ul>
							</nav>
						</div>
					</div>

					<div class="col-sm-2 col-xs-5">
						<div class="head">
							<img class="winwinlogo" src="assets/img/winwinlabs_logo.png">
						</div>
					</div>
 
					<div class="col-sm-5 col-xs-12">
						<div class="navArea" style="float: right; ">
							<nav class="mainnav">
								<ul>
									<li><a href="game-revenue.php">Revenue</a></li>
									<li><a href="#">How to Play</a></li>
									<li><a href = 'logout.php?logout'>Logout</a></li>

								</ul>
							</nav>
						</div>
					</div>
			

				</div>
			</div>
		</header>

		<!--==Main Content==-->
		<div class="contentArea">
		  <div id="idlePrompt" class="alert alert-warning alert-dismissable fade in">		
			<strong>Your Session is about to time out</strong>
			<p>You will automatically log out from your current session in</p>
			<h3 id="timeCur" style="padding:20px 0px 20px 0px;margin:0 auto;">60 seconds</h3>
=			<center><progress value="0" max="60" id="progressBar"></progress></center>
			<p>Press Any Key to remain logged in here! or Press Cancel</p>
			<button id="canTime">Cancel</button>
		  </div>		
		
			<div class="asideArea">
				<div class="aside-top">
					<div class="open-item">
						<div class="userInfo">
							<div class="userImg">
								<a href="profile.php" title="Update Your Profile" style="cursor:pointer;" ><img style="height:60px;" width="40px" class="imgUp img-circle img-responsive" src="<?php echo $_SESSION['userImage']; ?>"  alt="User Photo" onerror="this.src ='https://res.cloudinary.com/closebrace/image/upload/w_400/v1491315007/usericon_id76rb.png'"></a>
							</div>
							<div class="userName"> 
						<h3 class="centered"><?php echo $userRow['firstname']; echo '&nbsp'; echo $userRow['lastname']; ?></h3>

							</div>
						</div>

						<div class="asideNavBtn">
							<button><img src="assets/img/side_menu_close.png" alt=""></button>
						</div>
						<div class="side" style=" margin-left: 18px">
						  <a href="play-game.php" class="active" >
							<img src="assets/img/play.png" alt="Play Games" style="width:65px; height:65px; border-radius: 5px;padding-bottom: 10px;">
						  </a>
						  <a href="javascript:void(0)"  data-toggle="modal" data-target="#gameCreation">
							<img src="assets/img/add.png" alt="Game Creation" style="width:65px; height:65px;  border-radius: 5px;padding-bottom:10px">
						  </a>
						
						  <a href="game-account.php">
						    <img src="assets/img/manage.png" alt="Game Manager" style="width:65px; height:65px;  border-radius: 5px;padding-bottom: 10px;">
						  </a>
						
						  <a href="javascript:void(0)" data-toggle="modal" data-target="#purchase-credit">
							<img src="assets/img/credit.png" alt="Credits" style="width:65px; height:65px;  border-radius: 5px;padding-bottom: 10px; ">
						  </a>
						
						  <a href="game-charity.php">
							<img src="assets/img/charity.png" alt="Charities" style="width:65px; height:65px;  border-radius: 5px; padding-bottom: 10px;">
						  </a>
						</div>
					</div>
				</div>

			</div>

			<!--==Home Page==-->


			<!--Game Creation Popup-->
			<div class="gameCreation" id="gameCreation-area">
				<div class="modal fade"  id="gameCreation">
					<div class="modal-dialog">
						<div class="gcContent">
							<h2>What game do you<br> wish to make?</h2>

							<div class="row">
								<div class="col-xs-4">
									<div class="each-gc">
										<a href="game-create-puzzle.php">
											<div class="gcImage">
												<img src="assets/img/game_type.png" alt="Game image">
											</div>
											<h3>Puzzle</h3>
										</a>
									</div>
								</div>
								<div class="col-xs-4">
									<div class="each-gc">
										<a href="game-create-2048.php">
											<div class="gcImage">
												<img src="assets/img/game_number.png" alt="Game image">
											</div>
											<h3>2048</h3>
										</a>
									</div>
								</div>
								<div class="col-xs-4">
									<div class="each-gc">
										<a href="game-create-quiz.php">
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

<?php
//Set useful variables for paypal form
$paypalURL = 'https://www.sandbox.paypal.com/cgi-bin/webscr'; //Test PayPal API URL
//$paypalID = 'winwin@gmail.com'; //Business Email
$paypalID="dushyant108d-facilitator@gmail.com";
?>
			<div class="purchase" id="purchase-area">
				<div class="modal fade"  id="purchase-credit">
					<div class="modal-dialog">

						<div class="pc-content">
							<div class="pcHead">
								<h2>Purchase Credits</h2>
							</div>
							<div class="price-bundle">
								<a href="#">$1</a>
								<a href="#">$5</a>
								<a href="#" class="mrLess">$10</a>
								<a href="#">$50</a>
								<a href="#" class="active">$100</a>
								<a href="#" class="custom-price">
									$<input class="cp-value" type="number" min="0" />
								</a>
							</div>
                            <form action="<?php echo $paypalURL; ?>" id="payform" name="payform" method="post">
                    <!-- Identify your business so that you can collect the payments. -->
                    <input type="hidden" name="business" value="<?php echo $paypalID; ?>">

                    <!-- Specify a Buy Now button. -->
                    <input type="hidden" name="cmd" value="_xclick">

                    <!-- Specify details about the item that buyers will purchase. -->
                    <input type="hidden" name="item_name" value="<?php echo $_SESSION['userSession']?>">
                    <input type="hidden" name="item_number" value="">
                    <input type="hidden" name="amount" id="amount" value="">
                    <input type="hidden" name="currency_code" value="USD">
							<div class="payment-option">
								<label>Credit Card</label>
								<a onclick="gopaypal()" href="javascript:void(0)" target="_blank">Paypal</a>
							</div>
                            <input type='hidden' name='cancel_return' value='http://winwinlabs.com/developer/dashboard/success.php'>
                           <input type='hidden' name='return' value='http://winwinlabs.com/developer/dashboard/success.php'>
                            </form>
							<form action="" class="card-info" method="POST" id="payment-form">
                            <span style="color: red;" class="payment-errors"></span>
								<div class="card-name">
									<input type="text" autocomplete="off" name="stripename" id="stripename" placeholder="Full Name">
								</div>
								<div class="card-num">
									<input type="text" id="card-number" name="card-number" class="card-number1" autocomplete="off" placeholder="Card Number">
								</div>
								<div class="two-col">
									<div class="validity">
										<input type="text" size="2" style="width: 30%;" name="card-expiry-month" class="card-expiry-month" value="05"/>
                                        <span style="color: black;"> / </span>
                                        <input type="text" size="4" style="width: 60%;"  name="card-expiry-year" class="card-expiry-year" value="2019"/>
									</div>
									<div class="card-security">
										<input type="text" autocomplete="off" id="card-cvc" class="card-cvc" name="card-cvc" placeholder="CVC">
									</div>
                                    <input type="hidden" name="amountstripe" id="amountstripe" value="">
								</div>

								<div class="total">
									<label>Total:</label>
									<span class="total-usd">$100</span>
								</div>

								<div class="card-submit">
									<button name="stripepost" id="stripepost" type="submit">Authorize Payment</button>
								</div>
							</form>

						</div>
					</div>
				</div>

			</div>
			

            <script>
            function gopaypal()
            {
                var val=$(".total-usd").text();

                var res = val.split("$");

                document.getElementById("amount").value=res[1];
                document.payform.submit();
            }
            </script>
	
	<script>
	idleLogout();
	getImage();
	
	function getImage(){
		$.ajax({
			type:"POST",
			url:"login_check.php?p=getImage",
			dataType:"JSON",
			success:function(pp)
			{
				$(".imgUp").attr("src",pp.picUp);
				return false;
			}
		});	
	}	
	function idleLogout() {
		var t;
		var a;	
		var timeleft;	
		var abc;
		var time = 20 * 60 * 1000;
		var timeOne = 1 * 60 * 1000;

		window.onload = resetTimer;
		window.onkeypress = resetTimer;
		$("#canTime").on("click", resetTimer);
		function promptMessage() {
			clearTimeout(a);		
			$("#idlePrompt").fadeIn("slow");
			var timeleft = timeOne/1000;
			abc = 60;
				a = setInterval(function(){
				  document.getElementById("progressBar").value = 60 - --timeleft;
				  document.getElementById("timeCur").innerHTML = abc-- + " seconds";
				  if(timeleft <= 0){
					clearInterval(a);
					window.location.href = 'logout.php?logout';			
				  }
				}, 1000);
						
		}

		function resetTimer() {
			
			if($("#idlePrompt").is(":visible")){
				$("#idlePrompt").fadeOut("slow");						
			}
			clearTimeout(t);
			clearTimeout(a);
			abc = 60;
			t = setTimeout(promptMessage, time);  // time is in milliseconds
		}
	}
	
	</script>		
<script src="assets/js/jquery-1.10.2.min.js"></script>
<script type="text/javascript">
$(function(){
    var selector = '.nav12 li a';
    parentselector='.nav12 li';

     $(selector).each(function() {

    if ($(this).prop('href') == window.location.href) {

      $(this).parent().addClass('active');
    }
  });

  $(selector).click(function() {



    $(parentselector).removeClass('active');
      $(this).parent().addClass('active');

  });
});
</script>

<script type="text/javascript" src="https://js.stripe.com/v1/"></script>
<script type="text/javascript">
	    // this identifies your website in the createToken call below
	    Stripe.setPublishableKey("<?php echo $stripe['publishable_key']; ?>");
	    function stripeResponseHandler(status, response) {
	    	if (response.error) {
	            // re-enable the submit button
	            $('.submit-button').removeAttr("disabled");
	            // show the errors on the form
	            $(".payment-errors").html(response.error.message);
	        } else {
	            var form$ = $("#payment-form");
	            // token contains id, last4, and card type
	            var token = response['id'];
	            // insert the token into the form so it gets submitted to the server
	            form$.append("<input type='hidden' name='stripeToken' value='" + token + "' />");
	            //alert(token);
	                    // and submit
	            form$.get(0).submit();
	        }
	    }
	
	    $(document).ready(function() {
	        $("#payment-form").submit(function(event) {
	           $(".payment-errors").html('');
               var val1=$(".total-usd").text();

                    var res = val1.split("$");
                     //alert(res[1]);
                    document.getElementById("amountstripe").value=res[1];
	            // disable the submit button to prevent repeated clicks
	            $('.submit-button').attr("disabled", "disabled");
	            // createToken returns immediately - the supplied callback submits the form if there are no errors
	            if($('input[name="stripename"]').val()=="")
	            {
					alert("Please fill the card name");
					$('.submit-button').removeAttr("disabled");
					return false;
				}
                else if($('input[name="card-number"]').val()=="")
	            {
					alert("Please fill the card number");
					$('.submit-button').removeAttr("disabled");
					return false;
				}
                else if($('input[name="card-cvc"]').val()=="")
	            {
					alert("Please fill the card cvc");
					$('.submit-button').removeAttr("disabled");
					return false;
				}
                else if($('input[name="card-expiry-month"]').val()=="")
	            {
					alert("Please fill the card expiry month");
					$('.submit-button').removeAttr("disabled");
					return false;
				}
                else if($('input[name="card-expiry-year"]').val()=="")
	            {
					alert("Please fill the card expiry year");
					$('.submit-button').removeAttr("disabled");
					return false;
				}
				else
				{
				    
						Stripe.card.createToken({
		                number: $('.card-number1').val(),
		                cvc: $('.card-cvc').val(),
		                exp_month: $('.card-expiry-month').val(),
		                exp_year: $('.card-expiry-year').val()
		            }, stripeResponseHandler);
		            return false; // submit from callback
				}
	            
	        });
	        
	    });
	
	    </script>

