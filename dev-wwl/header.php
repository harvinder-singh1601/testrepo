<?php
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

//Assign the current timestamp as the user's
//latest activity
$_SESSION['last_action'] = time();

include_once 'dbconnect.php';
include_once 'track.php';
if (!isset($_SESSION['userSession'])) {
  header("Location: login.php");
}


$query = $DBcon->query("SELECT * FROM tbl_users WHERE user_id=".$_SESSION['userSession']);
$userRow=$query->fetch_array();
require_once('stripe/stripe/lib/Stripe.php');
	$stripe = array(
		'secret_key'      => 'sk_test_nb655SmAx1Lf3CuFMNYLGSEe',
		'publishable_key' => 'pk_test_lJcjIHIFbkA8a3imB2M8Dh2z'
	);
	Stripe::setApiKey($stripe['secret_key']);
$openstripe=0;
if(isset($_REQUEST['stripeToken']))
{
    $error = NULL;
    try 
		{
			if (!isset($_POST['stripeToken']))
				throw new Exception("The Stripe Token was not generated correctly");
	        $amount= $_POST['amountstripe']*100; 
             
			$charge = Stripe_Charge::create(array(
				'card'     => $_POST['stripeToken'],
				'amount'   => $amount,
				'currency' => 'usd',
                "description" => "Charge for ".$_POST['stripename'],
                // "customer" => $_POST['stripename']
			));
            
            $payment_gross = $_POST['amountstripe'];
            $currency_code = "usd";
            $payment_status = "Completed";
            // how much credits in 1$
            $productResult = $DBcon->query("SELECT * FROM products WHERE id = 1") or die("Cannot Execute query".mysqli_error($DBcon));

             $productRow = $productResult->fetch_assoc();
               $productPrice = $productRow['price'];
               $productcredit=trim($productRow['name']);
               
               //Insert tansaction data into the database
        //users total credit
        $totalcredits_cr="select sum(Credits) as credits_cr from payments where status=1 and User_ID='".$_SESSION['userSession']."'";
            $cr_rs=mysqli_query($DBcon,$totalcredits_cr) or die("Cannot Execute query".mysqli_error($DBcon));
            $cr_row=mysqli_fetch_array($cr_rs);
            $total_credit_cr=$cr_row['credits_cr'];
            
            $totalcredits_db="select sum(Credits) as credits_cr from payments where status=2 and User_ID='".$_SESSION['userSession']."'";
            $db_rs=mysqli_query($DBcon,$totalcredits_db) or die("Cannot Execute query".mysqli_error($DBcon));
            $db_row=mysqli_fetch_array($db_rs);
            $total_credit_db=$db_row['credits_cr'];
            $mycredits=$total_credit_cr-$total_credit_db;
        //get the exact credit 
        $totalcredits=$payment_gross*$productcredit;
        
        //sum of credits
        $totalsumofcredits=$totalcredits+$mycredits;
        $date = date('Y-m-d H:i:s');
       // echo  $q="INSERT INTO payments(Credits,User_ID,item_number,txn_id,payment_gross,currency_code,payment_status,Date,Notes,Status,game_id,total_credits) VALUES('".$totalcredits."','".$_SESSION['userSession']."','".$item_number."','".$charge->id."','".$payment_gross."','".$currency_code."','".$payment_status."','".$date."','Buy credits from stripe','1','0',".$totalsumofcredits.")";
       $q="INSERT INTO payments(Credits,User_ID,item_number,txn_id,payment_gross,currency_code,payment_status,Date,Notes,Status,game_id,total_credits) VALUES('".$totalcredits."','".$_SESSION['userSession']."','".$item_number."','".$charge->id."','".$payment_gross."','".$currency_code."','".$payment_status."','".$date."','Bought credits from stripe','1','0',".$totalsumofcredits.")";
        $insert = $DBcon->query($q) or die("Cannot Execute query".mysqli_error($DBcon).$q);
 
            ?>
            <script>
            alert("Thanks for the payment. Your Transcation Id is - <?php echo $charge->id ?>");
            document.location="game-revenue.php";
            </script>
            <?php
		}
		catch (Exception $e) {
			$error = $e->getMessage();
            $openstripe=1;
            ?>
            <script>
            alert("<?php echo $error?>");
            </script>
            <?php
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
									<li><a href="game-revenue.php">My Transactions</a></li>
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

			<div class="asideArea">
				<div class="aside-top">
					<div class="open-item">
						<div class="userInfo">
							<div class="userImg">
								<img src="assets/img/user_photo.png" alt="User Photo">
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
					<!-- <div class="closed-item">
						<div class="donorInfo">
							<label>Charity </label>
							<p>American red cross</p><br>

							<label>Amount donated</label>
							<p>$500.00</p><br>

							<label>Amount from played games</label>
							<br>
							<p>$150.00</p><br>
							<label>Amount from made games</label>
							<br>
							<p>$250.00</p><br>
						</div>
					</div> -->
				</div>

				<!-- <div class="aside-bottom">
					<div class="earn-donate-chart">
						<div class="month-amount">
							<h4>Total for the month : </h4>
							<span class="">$756.00</span>
						</div>
						<img src="assets/img/earn_donation_chart.png" alt="">
					</div>

					<div class="game-static">
						<img src="assets/img/pie_chart.png" alt="">
					</div>
				</div> -->

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

			<!--SignUp Popup-->
			<div class="signUp" id="signUp-area">
				<div class="modal fade"  id="signUp">
					<div class="modal-dialog">
						<div class="signUp-content">
							<div class="sLogo">
								<img src="assets/img/logo.png" alt="WinWinLabs">
							</div>

							<div class="signSocial">
								<h4>Sign up with social media</h4>
								<div class="ssItem">
									<a href="#"><i class="fa fa-google-plus"></i></a>
									<a href="#"><i class="fa fa-facebook"></i></a>
									<a href="#"><i class="fa fa-twitter"></i></a>
								</div>
							</div>
							<div class="signEmail">
								<h4>Or sign up with e-mail</h4>
								<form action="#" id="signUp-form">
									<div class="full-name">
										<input type="text" placeholder="Full Name">
									</div>
									<div class="user-name">
										<input type="text" placeholder="User Name">
									</div>
									<div class="email">
										<input type="Email" placeholder="Email">
									</div>
									<div class="pass">
										<input type="password" placeholder="Password">
									</div>
									<div class="custom-tick">
										<input type="checkbox">
										<label>You agree to our <span>Terms of Use</span></label>
									</div>

									<div class="s-submit">
										<button type="submit">Lets Start Winning!</button>
									</div>
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>

			<!--LogIn Popup-->
			<div class="logIn" id="logIn-area">
				<div class="modal fade"  id="logIn">
					<div class="modal-dialog">
						<div class="logIn-content">
							<div class="lLogo">
								<img src="assets/img/logo.png" alt="WinWinLabs">
							</div>
							<div class="log-user">
								<img src="assets/img/log-ico/user-loged.png" alt="LogIn User">
							</div>
							<div class="logEmail">
								<form action="#" id="logIn-form">
									<div class="user-name">
										<input type="text" placeholder="User Name">
									</div>
									<div class="pass">
										<input type="password" placeholder="Password">
									</div>
									<div class="forget-pass">
										<a href="#">Forgot Password?</a>
									</div>

									<div class="l-submit">
										<button type="submit">Log In</button>
									</div>
										<div class="custom-tick">
										<input type="checkbox">
										<label>Remember Me</label>
									</div>
								</form>
							</div>
							<div class="logSocial">
								<h4>or</h4>
								<div class="ls-Item">
									<a href="#"><i class="fa fa-google-plus"></i></a>
									<a href="#"><i class="fa fa-facebook"></i></a>
									<a href="#"><i class="fa fa-twitter"></i></a>
								</div>
								<a href="#" class ="createAccount" data-toggle="modal" data-target="#signUp">Create an account</a>
							</div>
						</div>
					</div>
				</div>
			</div>

			<!--Purchase Credits Popup-->

<?php
//Set useful variables for paypal form
$paypalURL = 'https://www.sandbox.paypal.com/cgi-bin/webscr'; //Test PayPal API URL
//$paypalID = 'winwin@gmail.com'; //Business Email
$paypalID="deepersnow-facilitator@gmail.com";

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
                            <input type='hidden' name='cancel_return' value='http://winwinlabs.com/developer/winwinlabs/success.php'>
                           <input type='hidden' name='return' value='http://winwinlabs.com/developer/winwinlabs/success.php'>
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

