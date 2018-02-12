<?php
session_start();
require_once 'dbconnect.php';
include_once 'track.php';

if (!isset($_SESSION['token'])) {
	
  header("Location: login.php");
	exit;
}

	$DBcon->close();

?>


<!DOCTYPE html>
<html lang="en">
  <head>
	  <meta charset="utf-8"/>
	  <meta http-equiv="X-UA-Compatible" content="IE=edge">
	  <meta name="viewport" content="width=device-width, initial-scale=1"/>
	  <meta name="description" content=""/>
	  <title>User Dashboard</title>
	  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
	  <link href="https://fonts.googleapis.com/css?family=Roboto:700,900" rel="stylesheet">
	  <link href="assets/css/bootstrap.min.css" rel="stylesheet"/>
	  <link rel="stylesheet" href="assets/css/custom.css"  />

	  <script src="https://www.google.com/recaptcha/api.js" async defer></script>
	   <style>
	#pswd_info1 {
		position: absolute;
		bottom: 145px;
		right: -240px;
		width: 250px;
		padding: 15px;
		background: #fefefe;
		font-size: .875em;
		border-radius: 5px;
		box-shadow: 0 1px 3px #ccc;
		border: 1px solid #ddd;
		display: none;
	}
#pswd_info1::before {
    content: "\25c0";
    position: absolute;
    top: 31px;
    left: -5%;
    font-size: 14px;
    line-height: 14px;
    color: #ddd;
    text-shadow: none;
    display: block;
}	
#resetPass_error{
	padding:10px;
	text-align: center;
}
	   </style>
  </head>

  <body>


	<div class="main">

		<!-- == Header Section==-->
		<header id="header">
			<div class="container">
				<div class="row">

					<div class="col-sm-2 col-sm-offset-5 col-xs-5 col-xs-offset-5">
						<div class="head">
							<img class="winwinlogo" src="assets/img/winwinlabs_logo.png">
						</div>
					</div>

				</div>
			</div>

		</header>

		<!--==Main Content==-->
		<div class="contentArea">
			<!--SignUp Popup-->
			<div class="signUp" id="signUp-area">
				<div class="modal fade"  id="signUp">
					<div class="modal-dialog">
						<div class="signUp-content">
							<div class="sLogo">
								<img src="assets/img/logo.png" alt="WinWinLabs">
							</div>

							<div class="signEmail">
							<div id="thank" align="center"style=" color:black;" >
									<span id="resetPass_error"><font color="red"></font></span>
							<form id="signUp-form" onsubmit="return reset_pass();" method="post">
									<div class="pass">
										<input type="password" placeholder="Enter New Password" name="pswd" id="pswd" required>
									</div>	
									
									<input type="hidden" name="token" value="<?php echo $_GET['token']; ?>" />
									<input type="hidden" name="id" value="<?php echo $_GET['key']; ?>" />
									
									<div class="pass">
										<input type="password" placeholder="Enter Again New Password" name="pswrdVerify" id="pswrdVerify" required>
									</div>								

									<div class="g-recaptcha" data-theme="light" data-sitekey="6LcN1TsUAAAAALyF8DZnAqXjLrkAxokFycS4WpeG" style="transform:scale(0.72);-webkit-transform:scale(0.72);transform-origin:0 0;-webkit-transform-origin:0 0;"></div> 
									<span id="demo" style="color:red;"></span> 
									

									<div class="s-submit">
										<button type="submit" name="log" >Reset Password!</button>
									</div>
									
								</form></div>
									<div id="pswd_info">
								    <h4>Password must contain:</h4>
								    <ul>
								      <li id="letter" class="valid">At least <strong>one letter</strong></li>
								      <li id="capital" class="invalid">At least <strong>one capital letter</strong></li>
								      <li id="number" class="invalid">At least <strong>one number</strong></li>
								      <li id="length" class="invalid">At least <strong>8 characters</strong></li>
								    </ul>
								  </div>
									<div id="pswd_info1">
										<h4>Password must Must Be Same:</h4>
								    <ul>
								      <li id="replica" ><strong>Password Match</strong></li>
								    </ul>
								  </div>
							</div>
						</div>
					</div>
				</div>
			</div>
		

		</div>


	</div><!--Main Area-->
	
		  <script src='https://code.jquery.com/jquery-2.2.4.min.js'></script>

<script type="text/javascript">

function reset_pass(){
	if (grecaptcha.getResponse() == ""){
		return false;
	}else{
			
	var pData = $("#signUp-form").serialize();	
	
	$.ajax({
		type:"POST",
		url:"login_check.php?p=resetPass",
		data:{pDa:pData},
		success:function(data)
		{
		// console.log(data);
			if(data==1)
			{
				$("#resetPass_error").replaceWith('<span id="resetPass_error"><font color="green">Password Changed Successfully !</font></span>');
				clearReset();
				return false;
			}
			if(data==2)				
			{
			
				$("#resetPass_error").replaceWith('<span id="resetPass_error"><font color="red">Cannot Reset Password at this time !</font></span>');
				clearReset();				
				return false;
			}
			if(data==3)
			{
				$("#resetPass_error").replaceWith('<span id="resetPass_error"><font color="red">Password Does not Match !</font></span>');
				clearReset();
				return false;
			}
			if(data==4)
			{
				$("#resetPass_error").replaceWith('<span id="resetPass_error"><font color="red">Link Expired !</font></span>');
				clearReset();
				return false;
			}
		}
	});
		
	
	return false;
	}
}

	function clearReset()
	{
		document.getElementById("signUp-form").style.display = "none";
		setTimeout(hideResetMsg, 5000);		
	}

	function hideResetMsg()
	{
		$("#resetPass_error").replaceWith('<span id="resetPass_error"><font color="red"></font></span>');
		$("#signUp").modal("hide");		
		location.href="login.php";		

	}	
	
	
	function validation() {
		var x = document.forms["form"]["g-recaptcha-response"].value;
		if (x == "") {
			document.getElementById("demo").innerHTML = "!Click On The Captcha";
			return false;
		}
		else 
		{
		document.getElementById("thank").innerHTML = "Thank you";	
		}
	}	

$(document).ready(function() {
	
	//Signup Modal Keep Always Open
    $('#signUp').modal('show').on('hide.bs.modal', function(e){
      e.preventDefault();
    });

	
  //you have to use keyup, because keydown will not catch the currently entered value
  $('#pswd').keyup(function() {

    // set password variable
    var pswd = $(this).val();

    //validate the length
    if (pswd.length < 8) {
      $('#length').removeClass('valid').addClass('invalid');
    } else {
      $('#length').removeClass('invalid').addClass('valid');
    }

    //validate letter
    if (pswd.match(/[A-z]/)) {
      $('#letter').removeClass('invalid').addClass('valid');
    } else {
      $('#letter').removeClass('valid').addClass('invalid');
    }

    //validate uppercase letter
    if (pswd.match(/[A-Z]/)) {
      $('#capital').removeClass('invalid').addClass('valid');
    } else {
      $('#capital').removeClass('valid').addClass('invalid');
    }

    //validate number
    if (pswd.match(/\d/)) {
      $('#number').removeClass('invalid').addClass('valid');
    } else {
      $('#number').removeClass('valid').addClass('invalid');
    }

  }).focus(function() {
    $('#pswd_info').show();
  }).blur(function() {
    $('#pswd_info').hide();
  });

  	
  //you have to use keyup, because keydown will not catch the currently entered value
  $('#pswrdVerify').keyup(function() {

    // set password variable
    var pswrdVerify = $(this).val();

    //validate the same password
    if ($("#pswd").val() != $("#pswrdVerify").val()) {
      $('#replica').removeClass('valid').addClass('invalid');
    } else {
      $('#replica').removeClass('invalid').addClass('valid');
    }


	
  }).focus(function() {
    $('#pswd_info1').show();
  }).blur(function() {
    $('#pswd_info1').hide();
  });
  
});


	</script>



    <script src="assets/js/jquery-1.10.2.min.js"></script>
	<script src="assets/js/bootstrap.min.js"></script>
	<script src="assets/js/custom.js"></script>

  </body>
</html>

