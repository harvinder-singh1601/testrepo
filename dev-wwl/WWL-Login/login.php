<?php
session_start();
require_once 'dbconnect.php';
include_once 'track.php';
if (isset($_SESSION['userSession'])) {
	
	if($_SESSION['userSession']>0)
	{
	header("Location: index.php");
	exit;
	}
}
 
if (isset($_POST['loginbtn'])) {
    $loginerror="";

	$email = strip_tags($_POST['email']);
	$password = strip_tags($_POST['password']);

	$email = $DBcon->real_escape_string($email);
	$password = $DBcon->real_escape_string($password);


	$query = $DBcon->query("SELECT user_id, email, password FROM tbl_users WHERE email='$email'");
	$row=$query->fetch_array();

	$count = $query->num_rows; // if email/password are correct returns must be 1 row

	if (password_verify($password, $row['password']) && $count==1) {
		$_SESSION['userSession'] = $row['user_id'];
		$user_id = $_SESSION['userSession'];
		$country =  $array['geobytescountry'];
		 $zone= $array['geobytestimezone'];
		 $ip = $array['geobytesipaddress'];
        
		 $sql = "INSERT INTO tracking_user (user_id, ip, location,timezone,activity)
		VALUES (".$user_id.", '".$ip."','".$country."', '".$zone."',1)";

		if ($DBcon->query($sql) === TRUE) {
			echo "New record created successfully";
		} else {
			echo "Error: " . $sql . "<br>" . $DBcon->error;
		}
		header("Location: index.php");
	} else {
		$query1 = $DBcon->query("SELECT * FROM tbl_users WHERE email='$email' and password='$password'");
		
		$_SESSION['userSession1']=$query1;
		if( $_SESSION['userSession'] = '' > 3){
			$loginerror="Please try again later, your reached the maximum allowed attempts for login.";
		echo '<script>
		$( "#logIn-form .pass" ).after("<div class=\"g-recaptcha\" data-theme=\"light\" data-sitekey=\"6LcN1TsUAAAAALyF8DZnAqXjLrkAxokFycS4WpeG\" style=\"transform:scale(0.72);-webkit-transform:scale(0.72);transform-origin:0 0;-webkit-transform-origin:0 0;\"></div>");
	</script>';
		}else{
        $loginerror="Invalid Email or Password !";
		}
	}  
	$DBcon->close();
}


elseif(isset($_POST['registerbtn'])) {
	    if(isset($_POST['g-recaptcha-response']) && !empty($_POST['g-recaptcha-response'])){
	   $secret = 'InsertSiteSecretKey';
		//get verify response data
        $verifyResponse = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret='.$secret.'&response='.$_POST['g-recaptcha-response']);
        $responseData = json_decode($verifyResponse);

	$fname = strip_tags($_POST['firstname']);
	$lname = strip_tags($_POST['lastname']);
	$uname = strip_tags($_POST['username']);
	$email = strip_tags($_POST['email']);
	$upass = strip_tags($_POST['pswd']);

	$fname = $DBcon->real_escape_string($fname);
	$lname = $DBcon->real_escape_string($lname);
	$uname = $DBcon->real_escape_string($uname);
	$email = $DBcon->real_escape_string($email);
	$upass = $DBcon->real_escape_string($upass);

	$hashed_password = password_hash($upass, PASSWORD_DEFAULT);

	$check_email = $DBcon->query("SELECT email FROM tbl_users WHERE email='$email'");
	$count=$check_email->num_rows;

	if ($count==0) {

		$query = "INSERT INTO tbl_users(firstname,lastname,username,email,password,usertype) VALUES('$fname','$lname','$uname','$email','$hashed_password','2')";


		if ($DBcon->query($query)) {
		  $user_id=mysqli_insert_id($DBcon);
          $charity="select * from charity where `Default`='Yes'";
          $charity_rs=mysqli_query($DBcon,$charity) or die("Cannot Execute Query".mysqli_error($DBcon));
          if(mysqli_num_rows($charity_rs)>0)
          {
            $charity_row=mysqli_fetch_array($charity_rs);
            $insert_charity="insert into charity_under_user (User_ID,Charity_ID,name,Address,Contact_personnel,Phonenumber,Tax_ID,non_profit_501c3,Approved,Image,Type) values
            ('".$user_id."','".$charity_row['id']."','".$charity_row['name']."','".$charity_row['Address']."','".$charity_row['Contact_personnel']."','".$charity_row['Phonenumber']."','".$charity_row['Tax_ID']."','".$charity_row['non_profit_501c3']."','Yes','".$charity_row['Image']."','default')";
    mysqli_query($DBcon,$insert_charity) or die("Cannot Execute query".mysqli_error($DBcon));
					$to = $email;
					$message = "Welcome Here!";
					$subject="Welcome to winwinLabs";
					$from = "dashd121@gmail.com";
					$body = file_get_contents("mail.html");
					$headers = "From: " . strip_tags($from) . "\r\n";
					$headers .= "Reply-To: ". strip_tags($from) . "\r\n";
					$headers .= "MIME-Version: 1.0\r\n";
					$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
		 
				   $mail= mail($to,$subject,$body,$headers);
						 
						if (!$mail){} //{echo "Mail Sent.";}
							
          }
			
         	echo '<script language="javascript">';
			echo 'alert("You have registered successfully !")';
			echo '</script>';
			header("refresh:3;url=login.php");
		}else {
			echo '<script language="javascript">';
			echo 'alert("Robot verification failed, please try again.")';
			echo '</script>';
		}

	} }else {
			echo '<script language="javascript">';
			echo 'alert("Please click on the reCAPTCHA box.")';
			echo '</script>';
		
	}

	$DBcon->close();
}

	elseif (isset($_POST['resetbtn'])) {
		 	## connect mysql server
				# check connection
				if ($DBcon->connect_errno) {
					echo "<p>MySQL error no {$DBcon->connect_errno} : {$DBcon->connect_error}</p>";
					exit();
				}
			## query database
				# fetch data from mysql database
				$sql = "SELECT user_id, email FROM tbl_users WHERE email LIKE '{$_POST['email']}' LIMIT 1";

				if ($result = $DBcon->query($sql)) {
					$user = $result->fetch_array();
					$user_id= $user['user_id'];
						$country =  $array['geobytescountry'];
					 $zone= $array['geobytestimezone'];
					 $ip = $array['geobytesipaddress'];
					 $sql = "INSERT INTO tracking_user (user_id, ip, location,timezone,activity)
					VALUES (".$user_id.", '".$ip."','".$country."', '".$zone."',3)";
				} else {
					echo "<p>MySQL error no {$DBcon->errno} : {$DBcon->error}</p>";
					exit();
				}

			if ($result->num_rows == 1) {
			


	$email = strip_tags($_POST['email']);
	$upass = strip_tags($_POST['password']);
	$conpass = strip_tags($_POST['confirm_password']);
	
	$email = $DBcon->real_escape_string($email);
	$upass = $DBcon->real_escape_string($upass);
	$conpass = $DBcon->real_escape_string($conpass);
	
			 if($upass==$conpass){
			$upass=rand();
			
			$_SESSION['token'] = $token = bin2hex(openssl_random_pseudo_bytes(64));
			
				$new_password=password_hash($upass, PASSWORD_DEFAULT);
				$update_sql = "UPDATE tbl_users SET password='{$new_password}' WHERE email='{$email}'";
 
				if ($result = $DBcon->query($update_sql)){
				// echo $result;
					$to = $email;
					$message = "Your password reset link send to your e-mail address.";
					$subject="Account Details Recovery";
					$from = "dashd121@gmail.com";
					$body='<center style="border:3px inset #000;margin-top:50px;width:80%;margin: 0 auto;box-shadow: 0 8px 16px 0 rgba(0,0,0,0.2), 0 6px 20px 0 rgba(0,0,0,0.19);padding:20px;border-radius:20px;">
						<img src="https://i.imgur.com/LZREtxT.png" style="padding-top:50px;"/> </br>
						<h2>Reset Your Password</h2>
						<h4>Hi, There, Its looks like you are requested for a new Password.</h4>
						<table>
							<tr>
								<td align="center" valign="middle" style="font-size:24px;padding-bottom:20px;">
								Click below </br>
								If You have lost your password or wish to reset your password then use this link to get started								
								</td>
							</tr>
							<tr>
								<td align="center" valign="middle"  style="background:#ff5454;color:#FFFFFF;font-family: Helvetica;  font-size: 18px;line-height: 100%;text-align:center; padding-top:25px; padding-bottom:25px;border-radius:20px; padding-right:15px; padding-left:15px;">
									<a style="padding-bottom:25px; color:#FFFFFF;text-decoration:none;font-family:Helvetica,Arial,sans-serif;font-size:20px;line-height:135%;" href="https://winwinlabs.com/developer/TEST/r3s3tp.php?token='.$_SESSION['token'].'&key='.my_simple_crypt($user['user_id'],'e').'&sess='.$upass.'" target="_blank">Reset Password
									</a>
								</td>
							</tr>
						</table>
					</center>';
					$headers = "From: " . strip_tags($from) . "\r\n";
					$headers .= "Reply-To: ". strip_tags($from) . "\r\n";
					$headers .= "MIME-Version: 1.0\r\n";
					$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
		 
				   $mail= mail($to,$subject,$body,$headers);
						 
						if ($mail){ //{echo "Mail Sent.";}
						
						echo '<script language="javascript">';
						echo 'alert("Login credentials has been sent to '.$email.'!")';						
						// echo 'return false;';					
						echo '</script>';					
						// header("refresh:3;url=login.php");
						}
						}else{

						echo '<script language="javascript">';
						echo 'alert("Sorry,password does not match, re-enter your password correctly.")';
						echo '</script>';
						
						
						}
					}

			}

			 else {
			 	echo '<script language="javascript">';
						echo 'alert("Sorry, no user found with this email !")';
						echo '</script>';
			  $reseterror="Invalid Email or Password !";
				
			}
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
									<li class="active"><a href="login.php" >Home</a></li>
									<li><a href="">About Us</a></li>
									
									<li><a href="" data-toggle="modal" id="loginPopop" data-target="#logIn" data-dismiss="modal" data-keyboard="false">LogIn</a></li>

								    <li><a href="" data-toggle="modal" data-target="#signUp" data-dismiss="modal">SignUp</a></li>

								</ul>
							</nav>
						</div>
					</div>

					<div class="col-sm-2 col-xs-5">
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
								<img src="assets/img/winwinlabs_logo.png" alt="WinWinLabs">
							</div>

							<div class="signEmail">

							<div id="thank" align="center" style=" color:black;" >
							<form onsubmit="return registerUser();" id="signUp-form" method="post">
							<center><div class="user-name" id="signup_error" style="padding:10px;"></div></center>
							<div class="full-name">
										<input type="text" placeholder="First Name" id="fname" name = "firstname" required>
									</div>
									<div class="full-name">
										<input type="text" placeholder="Last Name" id="lname" name = "lastname" required>
									</div>
									<div class="user-name">
										<input type="text" placeholder="User Name" id="uname" name = "username" required>
									</div>
									<div class="email">
										<input type="Email" placeholder="Email" name = "email" id="emailSignUp" required>
									</div>
									<div class="pass">
										<input type="password" placeholder="Password" name="pswd" id="pswd" required>
									</div>
									<div class="custom-tick">
										<input type="checkbox" required>
										<label>You agree to our <span>Terms of Use</span></label>
									</div>
									
										<div id="captcha" class="g-recaptcha" data-theme="light" data-sitekey="6LcN1TsUAAAAALyF8DZnAqXjLrkAxokFycS4WpeG" style="transform:scale(0.72);-webkit-transform:scale(0.72);transform-origin:0 0;-webkit-transform-origin:0 0;"></div> 
										<span id="demo" style="color:red;"></span> 

									<div class="s-submit">
										<button type="submit" name="registerbtn">Lets Start Winning!</button>
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
								<img src="assets/img/winwinlabs_logo.png" alt="WinWinLabs">
							</div>
							<div class="logEmail">
								
									
								    <form  id="logIn-form" onsubmit="return login_check();" method="post">

									<?php
                                    if(isset($loginerror) and $loginerror!="")
                                    {
										?>
                                    <div class="user-name">
									<font color='red'>	<?php echo $loginerror?></font>
									</div>
                                    <?php
                                    }
                                    ?>

									<div class="user-name" id="login_error" ></div>
									<div class="user-name">
										<input type="email" placeholder="Email" id="login-email" name="email" required>
									</div>
									<div class="pass">
										<input type="password" placeholder="Password" id="login-password" name="password" required>
									</div>
									  
									 
									<div class="forget-pass">
										<a href="#" class ="createAccount" data-toggle="modal" id="res_pass_link" data-target="#resPass" data-dismiss="modal">Forgot Password?</a>
									</div>									

									<div class="l-submit">
										<button type="submit"  onclick="return login_check();"  name="loginbtn" >Log In</button>
									</div>
										<div class="custom-tick">
										<input type="checkbox">
										<label>Remember Me</label>
									</div>
								</form>
							</div>
							<div class="logSocial">

								<a href="#" class ="createAccount" data-toggle="modal" data-target="#signUp" data-dismiss="modal">Create an account</a>
							</div>

						</div>
					</div>
				</div>
			</div>

		
			
			<!--Reset Password Popup-->
			<div class="resPass" id="resPass-area">
				<div class="modal fade"  id="resPass">
					<div class="modal-dialog">
						<div class="resPass-content">
							<div class="lLogo">
								<img src="assets/img/winwinlabs_logo.png" alt="WinWinLabs">
							</div>
	
							<div class="logEmail">
								
									<form  onsubmit="return reset_check();" id="resPass-form" method="post">
									<center><div class="user-name" id="reset_error" style="padding:10px;"></div></center>
								

								
									<span id="forgot_pass_mail_error" ></span>
									<span id="forgot_pass_mail_suc" ></span>
									

									<div class="user-name">
										<input type="text" placeholder="Email" name="email" id="rest_pass_email"  required>
									</div>

									<div id="captcha" class="g-recaptcha" data-theme="light" data-sitekey="6LcN1TsUAAAAALyF8DZnAqXjLrkAxokFycS4WpeG" style="transform:scale(0.72);-webkit-transform:scale(0.72);transform-origin:0 0;-webkit-transform-origin:0 0;"></div> 
									<span id="demo" style="color:red;"></span>
												
									

									<div class="l-submit">
										<button type="submit" name="resetbtn"> Reset Password</button>
									</div>
										
								</form>
							</div>
							<div class="logSocial" id="resContent">

								<a href="#" class ="createAccount" data-toggle="modal"  data-target="#logIn" data-dismiss="modal">Log In</a>
								<a href="#" class ="createAccount" data-toggle="modal" data-target="#signUp" data-dismiss="modal">Create an account</a>
							</div>
						</div>
					</div>
				</div>
			</div>

		

		</div>


<span data-toggle="modal" data-target="#resPass_mail" id="res_pass_link" data-dismiss="modal"></span>
	</div><!--Main Area-->
	
		  <script src='https://code.jquery.com/jquery-2.2.4.min.js'></script>

	<script type="text/javascript">
	

$(document).ready(function() {

 $('#uname').focus(function() {
	if($("#signup_error").text() != "" || $("#fname").val() != "" || $("#lname").val() != ""){
		$("#signup_error").delay(1000).replaceWith('<span id="signup_error"><font color="red"></font></span>');	 
	}
 });
 

  $('#uname').keyup(function() {
	var str = $("#fname").val().toUpperCase() +" "+ $("#lname").val().toUpperCase() + " " + $("#fname").val().toUpperCase() +""+ $("#lname").val().toUpperCase();
	var patt = new RegExp($(this).val().toUpperCase());
    var res = patt.test(str);
	if(res == true){
		$("#signup_error").replaceWith('<span id="signup_error"><font color="red">First or Last name cannot be username</font></span>');
		$("input[type=email]").prop('disabled', true);
		$("input[type=password]").prop('disabled', true);	
	}else{
		$("#signup_error").replaceWith('<span id="signup_error"><font color="red"></font></span>');
		$("input[type=email]").prop('disabled', false);
		$("input[type=password]").prop('disabled', false);		
	}
    // $('#pswd_info').hide();
  });
  //you have to use keyup, because keydown will not catch the currently entered value
  $('input[type=password]').keyup(function() {

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

});


function login_check()
{
	
	var password=document.getElementById("login-password").value;	
	var email=document.getElementById("login-email").value;
	
	$.ajax({
		type:"POST",
		url:"login_check.php?p=login",
		data:{email:email,password:password},
		success:function(data)
		{
			
			if(data==1)
			{
				location.href="index.php";
				return false;
			}
			if(data==2)				
			{
				clearLogin();			
				$("#res_pass_link").trigger("click");				
				
				return false;
			}
			if(data==3)
			{
				$("#login_error").replaceWith('<span id="login_error"><font color="red">Invalid Email or Password !</font></span>');
				clearLogin();							
				return false;
			}
		}
	});
		
	
	return false;
}

										
function clearLogin()
{
	document.getElementById("logIn-form").reset();
	setTimeout(hideLoginMsg, 5000);		
}

function hideLoginMsg()
{
	$("#login_error").replaceWith('<span id="login_error"><font color="red"></font></span>');

}	
	

function registerUser(){
	
	if (grecaptcha.getResponse() == ""){
		return false;
	}else{
		
		var rData = $("#signUp-form").serialize();
		
		var email = document.getElementById("emailSignUp").value;
		var password = document.getElementById("pswd").value;	
		
		$.ajax({
			type:"POST",
			url:"login_check.php?p=register",
			data:{reg:rData},
			success:function(data)
			{
			// console.log(data);
				if(data==1)
				{
					$("#signup_error").replaceWith('<span id="signup_error"><font color="green">You are Registered Successfully!</font></span>')
						$.ajax({
							type:"POST",
							url:"login_check.php?p=login",
							data:{email:email,password:password},
							success:function(data)
							{
								
								if(data==1)
								{
									location.href="index.php";
									return false;
								}
								if(data==2)				
								{
								
									$("#res_pass_link").trigger("click");				
									
									return false;
								}
								if(data==3)
								{
									$("#signup_error").replaceWith('<span id="signup_error"><font color="red">You are Registered But Cannot Sign in right now!</font></span>')
									return false;
								}
							}
						});				
					return false;
				}
				if(data==2)				
				{			
					$("#signup_error").replaceWith('<span id="signup_error"><font color="red">You are Registered but Not Charity !</font></span>')
					clearSignUp();				
					return false;
				}
				if(data==3)
				{
					$("#signup_error").replaceWith('<span id="signup_error"><font color="red">Cannot Registered. !</font></span>');
					clearSignUp()
					return false;
				}
				if(data==4)
				{
					$("#signup_error").replaceWith('<span id="signup_error"><font color="red">You are already Registered. !</font></span>');
					clearSignUp();
					return false;
				}
			}
		});
			
		
		return false;
	
	}
}

										
function clearSignUp()
{
	document.getElementById("signUp-form").reset();
	grecaptcha.reset();
	setTimeout(hideSignupMsg, 5000);		
}

function hideSignupMsg()
{
	$("#signup_error").replaceWith('<span id="signup_error"><font color="red"></font></span>');

}	
	

function reset_check(){
	
	var email=document.getElementById("rest_pass_email").value;	
	
	$.ajax({
		type:"POST",
		url:"login_check.php?p=reset",
		data:{email:email},
		success:function(data)
		{
		// console.log(data);
			if(data==1)
			{
				$("#reset_error").replaceWith('<span id="reset_error"><font color="green">Login credential has been sent to your email !</font></span>');
				clearReset();
				return false;
			}
			if(data==2)				
			{
			
				$("#reset_error").replaceWith('<span id="reset_error"><font color="red">Cannot Reset Password at this time !</font></span>');				
				clearReset();					
				return false;
			}
			if(data==3)
			{
				$("#reset_error").replaceWith('<span id="reset_error"><font color="red">Email Not Found !</font></span>');
				clearReset();				
				return false;
			}
		}
	});
		
	
	return false;
}

function clearReset()
{
	document.getElementById("resPass-form").reset();
	setTimeout(hideResetMsg, 5000);		
}

function hideResetMsg()
{
	$("#reset_error").replaceWith('<span id="reset_error"><font color="red"></font></span>');	
}	
	
function reset_password_mail()
{
	
	var reset_email=document.getElementById("rest_pass_email").value;
	
	return false;
}

	</script>



    <script src="assets/js/jquery-1.10.2.min.js"></script>
	<script src="assets/js/bootstrap.min.js"></script>
	<script src="assets/js/custom.js"></script>

  </body>
</html>
<?PHP
if(isset($loginerror) and $loginerror!="")
{
    ?>
    <script>
    $('#logIn').modal('show');

    </script>
    <?php
}
?>