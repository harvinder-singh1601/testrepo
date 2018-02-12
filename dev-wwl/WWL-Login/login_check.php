<?php

session_start();
require_once 'dbconnect.php';
include_once 'track.php';

if($_GET['p'] == 'login'){

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
		$_SESSION['userPic'] = $row['profile_img_path'];		
		$user_id= $_SESSION['userSession'];
		$country =  $array['geobytescountry'];
		 $zone= $array['geobytestimezone'];
		 $ip = $array['geobytesipaddress'];
        
		 
		if ($DBcon->query($sql) === TRUE) {
			echo"1";	
		} else {
			echo "1";
		}
	} else {
		       
		
		if(!isset($_SESSION['failed_login_count']))
		{
			$_SESSION['failed_login_count']=1;		
		}
		else
		{
			$_SESSION['failed_login_count']=$_SESSION['failed_login_count']+1;
		}
		
		if($_SESSION['failed_login_count']>4)
		{
			echo"2";	
		}
		else{
			echo"3";
		}
	}  
	$DBcon->close();
}

if($_GET['p'] == 'reset'){


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
				// $upass = strip_tags($_POST['password']);
				// $conpass = strip_tags($_POST['confirm_password']);
				
				$email = $DBcon->real_escape_string($email);
				// $upass = $DBcon->real_escape_string($upass);
				// $conpass = $DBcon->real_escape_string($conpass);
		
				// if($upass==$conpass){
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
									echo "1";
								}
						}else{
							echo "2"; //Cannot Reset Password at this time	
							}
				// }

			}

			 else {

				echo "3"; //Email Not Found
			}

			$DBcon->close();

}



if($_GET['p'] == 'register'){

		$val = array();
		parse_str($_POST['reg'], $val);
		
		// print_r($val);
		
		$fname = strip_tags($val['firstname']);
		$lname = strip_tags($val['lastname']);
		$uname = strip_tags($val['username']);
		$email = strip_tags($val['email']);
		$upass = strip_tags($val['pswd']);

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
				if(mysqli_num_rows($charity_rs) > 0 ){
				  
					$charity_row=mysqli_fetch_array($charity_rs);
					$insert_charity="insert into charity_under_user (User_ID, Charity_ID, name, Address, Contact_personnel, Phonenumber,Tax_ID, non_profit_501c3, Approved,Image, Type) 
					values
					('".$user_id."', 
					'".$charity_row['id']."', 
					'".$charity_row['name']."', 
					'".$charity_row['Address']."', 
					'".$charity_row['Contact_personnel']."', 
					'".$charity_row['Phonenumber']."', 
					'".$charity_row['Tax_ID']."', 
					'".$charity_row['non_profit_501c3']."', 
					'Yes', 
					'".$charity_row['Image']."', 
					'default')";
				
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
					 
					if ($mail){
						echo "1"; //mail and register done
					} 
						
				}else{
					echo "2";//Charity Error
				}
				
			}else {
				echo "3";//Registeration Failed
			}

		}else {
			echo "4"; //You are already registered
			
		}

	$DBcon->close();
	
}

if($_GET['p'] == 'resetPass'){
		
	$val = array();
	parse_str($_POST['pDa'], $val);
	// print_r($_POST['pDa']);
	
	if($_SESSION['token'] == $val['token']){
						

		## connect mysql server
		# check connection
		if ($DBcon->connect_errno) {
			echo "<p>MySQL error no {$DBcon->connect_errno} : {$DBcon->connect_error}</p>";
			exit();
		}
			$id = strip_tags($val['id']);
			$id = my_simple_crypt($id, 'd');
			$pswd = strip_tags($val['pswd']);
			$pswrdVerify = strip_tags($val['pswrdVerify']);
			
			if($pswd == $pswrdVerify){
				
				$hashed_password = password_hash($pswd, PASSWORD_DEFAULT);

				$update_sql = "UPDATE tbl_users SET password='{$hashed_password}' WHERE user_id='{$id}'";
				// print_r($update_sql);
				if ($DBcon->query($update_sql)){
					
					echo '1'; //Changed					
					unset($_SESSION['token']);
					
				}else{
					
					echo "2"; //Cannot Changed
					
				}
				
			}else{
				
				echo '3'; //Password Does not Match	
				
			}
			
	}
	else{
		
		echo '4';//Link Expired				
		unset($_SESSION['token']);
		
	}

	$DBcon->close();
	
}

if($_GET['p'] == 'updateProfile'){
	// echo "Hello";
	$query = $DBcon->query("SELECT * FROM tbl_users WHERE user_id = '".	$_SESSION['userSession']."'");
	$row = $query->fetch_assoc();
	// print_r($row);
	echo json_encode(array(
	"fname"=>$row['firstname'],
	"lname"=>$row['lastname'],
	"uname"=>$row['username'],
	"email"=>$row['email']
	));
}

if($_GET['p'] == 'insertProfile'){
	
	$lav = array();
	parse_str($_POST['rData'], $lav);

		$sql = "UPDATE tbl_users SET firstname = '".$lav['firstname']."', lastname = '".$lav['lastname']."', username = '".$lav['username']."', email = '".$lav['email']."' WHERE user_id = '".$_SESSION['userSession']."' ";
				
		if ($DBcon->query($sql) === TRUE) {

		$query1 = $DBcon->query("SELECT * FROM tbl_users WHERE user_id = '".$_SESSION['userSession']."'");
			$row = $query1->fetch_assoc();
			
			echo json_encode(array(
				"fname"=>$row['firstname'],
				"lname"=>$row['lastname'],
				"uname"=>$row['username'],
				"email"=>$row['email'],
				"done"=>"1"
			));

		} else {
			echo json_encode(array(
				"done"=>"0"
			));
		}		
	
		
}


if($_GET['p'] == 'updatePass'){
	
	$red = array();
	parse_str($_POST['pData'], $red);

	$currentPass = strip_tags($red['changePassword']);
	$newPass = strip_tags($red['newPassword']);		
	$newPassVerify = strip_tags($red['newVerifyPassword']);
	
	// $currentPass = "14Pst01019";
	// $newPass = "14Pst14Pst";		
	// $newPassVerify = "14Pst14Pst";
	
	
	if($currentPass != $newPass){
		
		$query = $DBcon->query("SELECT password FROM tbl_users WHERE user_id = '".$_SESSION['userSession']."' ");
		$row1=$query->fetch_array();

		if (password_verify($currentPass, $row1['password'])) {
			if($newPass == $newPassVerify){
				$updateHashPass = password_hash($newPass, PASSWORD_DEFAULT);
				
				$update_sql1 = "UPDATE tbl_users SET password='".$updateHashPass."' WHERE user_id= '".$_SESSION['userSession']."' ";
					if ($DBcon->query($update_sql1)){
					
						echo json_encode(array(
							"done"=>"1" // Success
						));				
					
					}else{
						
						echo json_encode(array(
							"done"=>"2" // Failed Changing
						));	
						
					}				
			}else{
				echo json_encode(array(
				"done"=>"3" //pass does not match
				));			
			}
			
		}else{
			echo json_encode(array(
			"done"=>"4" //Current pass is invalid
			));
		}
		
	}else{
		echo json_encode(array(
		"done"=>"5" //Same Password
		));
	}
		
}


if($_GET['p'] == 'updateImage'){
/* Checking to see if profile pic exists*/ 

	$user_pic = "user_pic_".$_SESSION['userSession'].".jpg";
	if (file_exists($user_pic)) {
		unlink($user_pic);
	}

	else{
	/* Getting file name */
	$filename = $_FILES['file-input']['name'];
	$new_filename = "user_pic_".$_SESSION['userSession'].".jpg";

	/* Location - renaming file*/ 
	$location = "assets/img/".$new_filename;
	// $location = "upload/".$filename;


	/* Upload file */
	if(move_uploaded_file($_FILES['file-input']['tmp_name'],$location)){
		$update_sql = "UPDATE tbl_users SET profile_img_path = '".$location."' WHERE user_id = '".$_SESSION['userSession']."' ";
		if ($result = $DBcon->query($update_sql)){
			$query = $DBcon->query("SELECT profile_img_path FROM tbl_users WHERE user_id = '".$_SESSION['userSession']."'");
			$row=$query->fetch_assoc();			
			$_SESSION['userPic'] = $row['profile_img_path'];
			echo $location;
		}
	}else{
		echo 0;
	}

	}	
}
if($_GET['p'] == 'getImage'){
	
	$query = $DBcon->query("SELECT profile_img_path FROM tbl_users WHERE user_id = '".$_SESSION['userSession']."'");
	$row=$query->fetch_assoc();
	$_SESSION['userPic'] = $row['profile_img_path'];	
	echo json_encode(array(
		"picUp"=>$row['profile_img_path'] //Same Password
	));
	
}
?>