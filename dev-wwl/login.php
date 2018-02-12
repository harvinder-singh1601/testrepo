<?php
session_start();
require_once 'dbconnect.php';
include_once 'track.php';
if (isset($_SESSION['userSession'])!="") {
    header("Location: index.php");

    exit;
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
        $user_id= $_SESSION['userSession'];
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
        $_SESSION["userAttemptSession"] = $_SESSION['userAttemptSession']+1;
        if($_SESSION["userAttemptSession"]>3){
            $loginerror="Please try again later, your reached the maximum allowed attempts for login.";
        echo '<script>
        //disable submit for 5 minutes
        $("#logIn-form submit").attr("disabled","disabled");
function SubmitForm(){
    $("#logIn-form").submit();
};
setTimeout(SubmitForm,300000);      
        </script>';
        }else{
        $loginerror="Invalid Email or Password !";
        }
    }
    $DBcon->close();
}


elseif(isset($_POST['registerbtn'])) {
        if(isset($_POST['g-recaptcha-response']) && !empty($_POST['g-recaptcha-response'])){
       $secret = '6LcN1TsUAAAAAKHq67uiypVTXZaFDHGRgfuMZQuS';
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
            
                $new_password=password_hash($upass, PASSWORD_DEFAULT);
                $update_sql = "UPDATE tbl_users SET password='{$new_password}' WHERE email='{$email}'";
 
                if ($result = $DBcon->query($update_sql)){
                // echo $result;
                    $to = $email;
                    $message = "Your password reset link send to your e-mail address.";
                    $subject="Account Details Recovery";
                    $from = "dashd121@gmail.com";;
                    $body='Hi, <br/> <br/>Your Membership ID is '.$user['user_id'].' <br><br> Your New Password is '.$upass;
                    $headers = "From: " . strip_tags($from) . "\r\n";
                    $headers .= "Reply-To: ". strip_tags($from) . "\r\n";
                    $headers .= "MIME-Version: 1.0\r\n";
                    $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
         
                   $mail= mail($to,$subject,$body,$headers);
                         
                        if ($mail){ //{echo "Mail Sent.";}
                        
                        echo '<script language="javascript">';
                        echo 'alert("Login credentials has been sent to '.$email.'!")';
                        echo '</script>';
                        
                        header("refresh:3;url=login.php");
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
    <title>WinWinLabs</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet" type="text/css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>


    <link href="https://fonts.googleapis.com/css?family=Roboto:700,900" rel="stylesheet">
    <link href="assets/css/bootstrap.min.css" rel="stylesheet"/>
    <link rel="stylesheet" href="assets/css/custom.css"  />
	<script src="https://www.google.com/recaptcha/api.js" async defer></script>

    <style>
        body {
            font: 400 15px Lato, sans-serif;
            line-height: 1.8;
            color: #818181;
            overflow: visible;
        }
        
        h2 {
            font-size: 24px;
            text-transform: uppercase;
            color: #303030;
            font-weight: 600;
            margin-bottom: 30px;
        }
        
        h4 {
            font-size: 19px;
            line-height: 1.375em;
            color: #303030;
            font-weight: 400;
            margin-bottom: 30px;
        }
        
        .jumbotron {
            background-color: #f4511e;
            color: #fff;
            padding: 100px 25px;
            font-family: Montserrat, sans-serif;
        }
        
        .container-fluid {
            padding: 60px 50px;
        }
        
        .bg-grey {
            background-color: #f6f6f6;
        }
        
        .logo-small {
            color: #f4511e;
            font-size: 50px;
        }
        
        .logo {
            color: #f4511e;
            font-size: 200px;
        }
        
        .thumbnail {
            padding: 0 0 15px 0;
            border: none;
            border-radius: 0;
        }
        
        .thumbnail img {
            width: 100%;
            height: 100%;
            margin-bottom: 10px;
        }
        
        .carousel-control.right,
        .carousel-control.left {
            background-image: none;
            color: #f4511e;
        }
        
        .carousel-indicators li {
            border-color: #f4511e;
        }
        
        .carousel-indicators li.active {
            background-color: #f4511e;
        }
        
        .item h4 {
            font-size: 19px;
            line-height: 1.375em;
            font-weight: 400;
            font-style: italic;
            margin: 70px 0;
        }
        
        .item span {
            font-style: normal;
        }
        
        .panel {
            border: 1px solid #f4511e;
            border-radius: 0 !important;
            transition: box-shadow 0.5s;
        }
        
        .panel:hover {
            box-shadow: 5px 0px 40px rgba(0, 0, 0, .2);
        }
        
        .panel-footer .btn:hover {
            border: 1px solid #f4511e;
            background-color: #fff !important;
            color: #f4511e;
        }
        
        .panel-heading {
            color: #fff !important;
            background-color: #f4511e !important;
            padding: 25px;
            border-bottom: 1px solid transparent;
            border-top-left-radius: 0px;
            border-top-right-radius: 0px;
            border-bottom-left-radius: 0px;
            border-bottom-right-radius: 0px;
        }
        
        .panel-footer {
            background-color: white !important;
        }
        
        .panel-footer h3 {
            font-size: 32px;
        }
        
        .panel-footer h4 {
            color: #aaa;
            font-size: 14px;
        }
        
        .panel-footer .btn {
            margin: 15px 0;
            background-color: #f4511e;
            color: #fff;
        }
        
        .navbar {
            margin-bottom: 0;
            background-color: #f4511e;
            z-index: 9999;
            border: 0;
            font-size: 12px !important;
            line-height: 1.42857143 !important;
            letter-spacing: 4px;
            border-radius: 0;
            font-family: Montserrat, sans-serif;
        }
        
        .navbar li a,
        .navbar .navbar-brand {
            color: #fff !important;
        }
        
        .navbar-nav li a:hover,
        .navbar-nav li.active a {
            color: #f4511e !important;
            background-color: #fff !important;
        }
        
        .navbar-default .navbar-toggle {
            border-color: transparent;
            color: #fff !important;
        }
        
        footer .glyphicon {
            font-size: 20px;
            margin-bottom: 20px;
            color: #f4511e;
        }
        
        .slideanim {
            visibility: hidden;
        }
        
        .slide {
            animation-name: slide;
            -webkit-animation-name: slide;
            animation-duration: 1s;
            -webkit-animation-duration: 1s;
            visibility: visible;
        }
        
        @keyframes slide {
            0% {
                opacity: 0;
                transform: translateY(70%);
            }
            100% {
                opacity: 1;
                transform: translateY(0%);
            }
        }
        
        @-webkit-keyframes slide {
            0% {
                opacity: 0;
                -webkit-transform: translateY(70%);
            }
            100% {
                opacity: 1;
                -webkit-transform: translateY(0%);
            }
        }
        
        @media screen and (max-width: 768px) {
            .col-sm-4 {
                text-align: center;
                margin: 25px 0;
            }
            .btn-lg {
                width: 100%;
                margin-bottom: 35px;
            }
        }
        
        @media screen and (max-width: 480px) {
            .logo {
                font-size: 150px;
            }
        }
    </style>
</head>

<body id="myPage" data-spy="scroll" data-target=".navbar" data-offset="60">

    <nav class="navbar navbar-default navbar-fixed-top">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>                        
      </button>
                <a class="navbar-brand" href="#myPage">WINWINLABS</a>

            </div>
            <div class="collapse navbar-collapse" id="myNavbar">
                <ul class="nav navbar-nav navbar-right">
                    <li><a href="#about">ABOUT</a></li>
                    <li><a href="#games">GAMES</a></li>
                    <li><a href="#charity">CHARITIES</a></li>
                    <li><a href="" data-toggle="modal" data-target="#logIn" data-dismiss="modal" data-keyboard="false">LOGIN</a></li>
                    <li><a href="#contact">CONTACT</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="jumbotron text-center">
        <img src="https://winwinlabs.com/developer/TEST/assets/img/winwinlabs_logo.png" alt="">
        <!-- <h1>WinWinLabs</h1> -->
        <p>Fun way to do Charity</p>
        <form>
            <div class="input-group">
                <input type="email" class="form-control" size="50" placeholder="Email Address" required>
                <div class="input-group-btn">
                    <button type="button" class="btn btn-danger">Subscribe</button>
                </div>
            </div>
        </form>
    </div>

    <!-- Container (Games Section) -->
    <div id="games" class="container-fluid text-center">
        <h2>GAMES</h2>
        <h4>What we offer</h4>
        <br>
        <div class="row slideanim">
            <div class="col-sm-4">
                <span class="glyphicon glyphicon-off logo-small"></span>
                <h4>PUZZLE</h4>
                <p>Lorem ipsum dolor sit amet..</p>
            </div>
            <div class="col-sm-4">
                <span class="glyphicon glyphicon-heart logo-small"></span>
                <h4>QUIZ</h4>
                <p>Lorem ipsum dolor sit amet..</p>
            </div>
            <div class="col-sm-4">
                <span class="glyphicon glyphicon-lock logo-small"></span>
                <h4>2048</h4>
                <p>Lorem ipsum dolor sit amet..</p>
            </div>
        </div>
        <br><br>
        <div class="row slideanim">
            <div class="col-sm-4">
                <span class="glyphicon glyphicon-leaf logo-small"></span>
                <h4>GREEN</h4>
                <p>Lorem ipsum dolor sit amet..</p>
            </div>
            <div class="col-sm-4">
                <span class="glyphicon glyphicon-certificate logo-small"></span>
                <h4>MATH</h4>
                <p>Lorem ipsum dolor sit amet..</p>
            </div>
            <div class="col-sm-4">
                <span class="glyphicon glyphicon-wrench logo-small"></span>
                <h4 style="color:#303030;">ARCADE</h4>
                <p>Lorem ipsum dolor sit amet..</p>
            </div>
        </div>
    </div>

    <!-- Container (Charity Section) -->
    <div id="charity" class="container-fluid text-center bg-grey">
        <h2>Charities</h2><br>
        <h4>We Love Donating</h4>
        <div class="row text-center slideanim">
            <div class="col-sm-4">
                <div class="thumbnail">
                    <img src="http://robohub.org/wp-content/uploads/2017/07/FRC.png" alt="First Robotics" width="400" height="300">
                    <p><strong>First Robotics</strong></p>
                    <p>Donated $5,000.00</p>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="thumbnail">
                    <img src="https://www.stjude.org/get-involved/find-an-event/dinners-and-galas/gold-luncheon-houston/_jcr_content/image.img.800.high.png/1507729131490.png" alt="St. Judes" width="400" height="300">
                    <p><strong>St. Judes</strong></p>
                    <p>Donated $20,000.00</p>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="thumbnail">
                    <img src="https://upload.wikimedia.org/wikipedia/en/thumb/a/aa/Feeding_America_logo.svg/1280px-Feeding_America_logo.svg.png" alt="Feeding America" width="400" height="300">
                    <p><strong>Feeding America</strong></p>
                    <p>$10,000.00</p>
                </div>
            </div>
        </div><br>

           <!-- Container (About Section) -->
    <div id="about" class="container-fluid">
        <div class="row">
            <div class="col-sm-8">
                <h2>About WinWinLabs</h2><br>
                <h4>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</h4><br>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Excepteur
                    sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud
                    exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
                <br><button class="btn btn-default btn-lg">Get in Touch</button>
            </div>
            <div class="col-sm-4">
                <div class="embed-responsive embed-responsive-16by9">
                    <iframe width="560" height="315" src="https://www.youtube.com/embed/xHhbSz_i_Pg" frameborder="0" gesture="media" allow="encrypted-media" allowfullscreen></iframe>
                    <!-- <iframe class="embed-responsive-item" src="https://www.youtube.com/watch?v=xHhbSz_i_Pg" allowfullscreen></iframe> -->
                </div>
                <!-- <span class="glyphicon glyphicon-signal logo"></span> -->
            </div>
        </div>
    </div>

    <div class="container-fluid bg-grey">
        <div class="row">
            <div class="col-sm-4">
                <span class="glyphicon glyphicon-globe logo slideanim"></span>
            </div>
            <div class="col-sm-8">
                <h2>Our Values</h2><br>
                <h4><strong>MISSION:</strong> Our mission lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut
                    aliquip ex ea commodo consequat.</h4><br>
                <p><strong>VISION:</strong> Our vision Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut
                    aliquip ex ea commodo consequat. Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut
                    aliquip ex ea commodo consequat.</p>
            </div>
        </div>
    </div>

        <h2>What our users say</h2>
        <div id="myCarousel" class="carousel slide text-center" data-ride="carousel">
            <!-- Indicators -->
            <ol class="carousel-indicators">
                <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
                <li data-target="#myCarousel" data-slide-to="1"></li>
                <li data-target="#myCarousel" data-slide-to="2"></li>
            </ol>

            <!-- Wrapper for slides -->
            <div class="carousel-inner" role="listbox">
                <div class="item active">
                    <h4>"WinWinLabs is the best. I am so happy!"<br><span>Michael Roe, NYC</span></h4>
                </div>
                <div class="item">
                    <h4>"One word... WOW!!"<br><span>John Doe, Michigan</span></h4>
                </div>
                <div class="item">
                    <h4>"I get to support my charity playing games!!! Sign me up"<br><span>Sam Walter, Colorado</span></h4>
                </div>
            </div>

            <!-- Left and right controls -->
            <a class="left carousel-control" href="#myCarousel" role="button" data-slide="prev">
                <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
            </a>
            <a class="right carousel-control" href="#myCarousel" role="button" data-slide="next">
                <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
            </a>
        </div>
    </div>

    <!-- Container (Pricing Section) -->
    <!-- <div id="pricing" class="container-fluid">
        <div class="text-center">
            <h2>Pricing</h2>
            <h4>Choose a payment plan that works for you</h4>
        </div>
        <div class="row slideanim">
            <div class="col-sm-4 col-xs-12">
                <div class="panel panel-default text-center">
                    <div class="panel-heading">
                        <h1>Basic</h1>
                    </div>
                    <div class="panel-body">
                        <p><strong>20</strong> Lorem</p>
                        <p><strong>15</strong> Ipsum</p>
                        <p><strong>5</strong> Dolor</p>
                        <p><strong>2</strong> Sit</p>
                        <p><strong>Endless</strong> Amet</p>
                    </div>
                    <div class="panel-footer">
                        <h3>$19</h3>
                        <h4>per month</h4>
                        <button class="btn btn-lg">Sign Up</button>
                    </div>
                </div>
            </div>
            <div class="col-sm-4 col-xs-12">
                <div class="panel panel-default text-center">
                    <div class="panel-heading">
                        <h1>Pro</h1>
                    </div>
                    <div class="panel-body">
                        <p><strong>50</strong> Lorem</p>
                        <p><strong>25</strong> Ipsum</p>
                        <p><strong>10</strong> Dolor</p>
                        <p><strong>5</strong> Sit</p>
                        <p><strong>Endless</strong> Amet</p>
                    </div>
                    <div class="panel-footer">
                        <h3>$29</h3>
                        <h4>per month</h4>
                        <button class="btn btn-lg">Sign Up</button>
                    </div>
                </div>
            </div>
            <div class="col-sm-4 col-xs-12">
                <div class="panel panel-default text-center">
                    <div class="panel-heading">
                        <h1>Premium</h1>
                    </div>
                    <div class="panel-body">
                        <p><strong>100</strong> Lorem</p>
                        <p><strong>50</strong> Ipsum</p>
                        <p><strong>25</strong> Dolor</p>
                        <p><strong>10</strong> Sit</p>
                        <p><strong>Endless</strong> Amet</p>
                    </div>
                    <div class="panel-footer">
                        <h3>$49</h3>
                        <h4>per month</h4>
                        <button class="btn btn-lg">Sign Up</button>
                    </div>
                </div>
            </div>
        </div>
    </div> -->

    <!-- Container (Contact Section) -->
    <div id="contact" class="container-fluid bg-grey">
        <h2 class="text-center">CONTACT</h2>
        <div class="row">
            <div class="col-sm-5">
                <p>Contact us and we'll get back to you within 24 hours.</p>
                <p><span class="glyphicon glyphicon-map-marker"></span> Denver, US</p>
                <p><span class="glyphicon glyphicon-phone"></span> +00 1515151515</p>
                <p><span class="glyphicon glyphicon-envelope"></span> contactus@winwinlabs.com</p>
            </div>
            <div class="col-sm-7 slideanim">
                <div class="row">
                    <div class="col-sm-6 form-group">
                        <input class="form-control" id="name" name="name" placeholder="Name" type="text" required>
                    </div>
                    <div class="col-sm-6 form-group">
                        <input class="form-control" id="email" name="email" placeholder="Email" type="email" required>
                    </div>
                </div>
                <textarea class="form-control" id="comments" name="comments" placeholder="Comment" rows="5"></textarea><br>
                <div class="row">
                    <div class="col-sm-12 form-group">
                        <button class="btn btn-default pull-right" type="submit">Send</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Google Maps -->
    <!-- <div id="googleMap" style="height:400px;width:100%;"></div> -->
    <script>
        function myMap() {
            var myCenter = new google.maps.LatLng(41.878114, -87.629798);
            var mapProp = {
                center: myCenter,
                zoom: 12,
                scrollwheel: false,
                draggable: false,
                mapTypeId: google.maps.MapTypeId.ROADMAP
            };
            var map = new google.maps.Map(document.getElementById("googleMap"), mapProp);
            var marker = new google.maps.Marker({
                position: myCenter
            });
            marker.setMap(map);
        }
    </script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBu-916DdpKAjTmJNIgngS6HL_kDIKU0aU&callback=myMap"></script>
    <!--
To use this code on your website, get a free API key from Google.
Read more at: https://www.w3schools.com/graphics/google_maps_basic.asp
-->

    <footer class="container-fluid text-center">
        <a href="#myPage" title="To Top">
            <span class="glyphicon glyphicon-chevron-up"></span>
        </a>
        <!-- <p>Bootstrap Theme Made By <a href="https://www.w3schools.com" title="Visit w3schools">www.w3schools.com</a></p> -->
    </footer>

    <script>
        $(document).ready(function() {
            // Add smooth scrolling to all links in navbar + footer link
            $(".navbar a, footer a[href='#myPage']").on('click', function(event) {
                // Make sure this.hash has a value before overriding default behavior
                if (this.hash !== "") {
                    // Prevent default anchor click behavior
                    event.preventDefault();

                    // Store hash
                    var hash = this.hash;

                    // Using jQuery's animate() method to add smooth page scroll
                    // The optional number (900) specifies the number of milliseconds it takes to scroll to the specified area
                    $('html, body').animate({
                        scrollTop: $(hash).offset().top
                    }, 900, function() {

                        // Add hash (#) to URL when done scrolling (default click behavior)
                        window.location.hash = hash;
                    });
                } // End if
            });

            $(window).scroll(function() {
                $(".slideanim").each(function() {
                    var pos = $(this).offset().top;

                    var winTop = $(window).scrollTop();
                    if (pos < winTop + 600) {
                        $(this).addClass("slide");
                    }
                });
            });
        })
    </script>

            <!--SignUp Popup-->
            <div class="signUp" id="signUp-area">
                <div class="modal fade"  id="signUp">
                    <div class="modal-dialog">
                        <div class="signUp-content">
                            <div class="sLogo">
                                <img src="assets/img/logo.png" alt="WinWinLabs">
                            </div>

                            <!-- <div class="signSocial">
                                <h4>Sign up with social media</h4>
                                <div class="ssItem">
                                    <a href="#"><i class="fa fa-google-plus"></i></a>
                                    <a href="#"><i class="fa fa-facebook"></i></a>
                                    <a href="#"><i class="fa fa-twitter"></i></a>
                                </div>
                            </div> -->
                            <div class="signEmail">
                                <!-- <h4>Or sign up with e-mail</h4> -->
                                <form action="" id="signUp-form" method="post">
                                    <div class="full-name">
                                        <input type="text" placeholder="First Name" name = "firstname" required>
                                    </div>
                                    <div class="full-name">
                                        <input type="text" placeholder="Last Name" name = "lastname" required>
                                    </div>
                                    <div class="user-name">
                                        <input type="text" placeholder="User Name" name = "username" required>
                                    </div>
                                    <div class="email">
                                        <input type="Email" placeholder="Email" name = "email" required>
                                    </div>
                                    <div class="pass">
                                        <input type="password" placeholder="Password" name="pswd" id="pswd" required>
                                    </div>
                                    <div class="custom-tick">
                                        <input type="checkbox" required>
                                        <label>You agree to our <span>Terms of Use</span></label>
                                    </div>

                                    <div class="g-recaptcha" data-theme="light" data-sitekey="6LcN1TsUAAAAALyF8DZnAqXjLrkAxokFycS4WpeG" style="transform:scale(0.72);-webkit-transform:scale(0.72);transform-origin:0 0;-webkit-transform-origin:0 0;"></div> 

                                    <div class="s-submit">
                                        <button type="submit" name="registerbtn">Lets Start Winning!</button>
                                    </div>
                                </form>
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
                                <img src="assets/img/logo.png" alt="WinWinLabs">
                            </div>
                            <div class="log-user">
                                <img src="assets/img/log-ico/user-loged.png" alt="LogIn User">
                            </div>
                            <div class="logEmail">
                                <?php if (!empty($_POST)){ ?>
                                    <form action="" id="logIn-form" method="post">
                                    <?php }
                                    else{ ?>
                                    <form action="" id="logIn-form" method="post">

                                    <?php }
                                    if(isset($loginerror) and $loginerror!="")
                                    {?>
                                        <div class="user-name">
                                    <font color='red'>  <?php echo $loginerror?></font>
                                    </div>
                                    <?php
                                    }
                                    ?>


                                    <div class="user-name">
                                        <input type="text" placeholder="Email" name="email" required>
                                    </div>
                                    <div class="pass">
                                        <input type="password" placeholder="Password" name="password" required>
                                    </div>
                                     <?php  if($_SESSION["userAttemptSession"]>3){ ?>
                                     <div class="g-recaptcha" data-theme="light" data-sitekey="6LcN1TsUAAAAALyF8DZnAqXjLrkAxokFycS4WpeG" style="transform:scale(0.72);-webkit-transform:scale(0.72);transform-origin:0 0;-webkit-transform-origin:0 0;"></div> 

                                    <?php }?>
                                     
                                    <div class="forget-pass">
                                        <a href="#" class ="createAccount" data-toggle="modal" data-target="#resPass" data-dismiss="modal">Forgot Password?</a>
                                    </div>                                  

                                    <div class="l-submit">
                                        <button type="submit" name="loginbtn"> Log In</button>
                                    </div>
                                        <div class="custom-tick">
                                        <input type="checkbox">
                                        <label>Remember Me</label>
                                    </div>
                                </form>
                            </div>
                            <div class="logSocial">
                                <!-- <h4>or</h4>
                                <div class="ls-Item">
                                    <a href="#"><i class="fa fa-google-plus"></i></a>
                                    <a href="#"><i class="fa fa-facebook"></i></a>
                                    <a href="#"><i class="fa fa-twitter"></i></a>
                                </div> -->
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
                                <img src="assets/img/logo.png" alt="WinWinLabs">
                            </div>
                            <div class="log-user">
                                <img src="assets/img/log-ico/user-loged.png" alt="LogIn User">
                            </div>
                            <div class="logEmail">
                                <?php if (!empty($_POST)){ ?>
                                    <form action="" id="resPass-form" method="post">
                                    <?php }
                                    else{ ?>
                                    <form action="" id="resPass-form" method="post">

                                    <?php }
                                    if(isset($reseterror) and $reseterror!="")
                                    {?>
                                        <div class="user-name">
                                    <font color='red'>  <?php echo $reseterror?></font>
                                    </div>
                                    <?php
                                    }
                                    ?>


                                    <div class="user-name">
                                        <input type="text" placeholder="Email" name="email" required>
                                    </div>
                                    <div class="pass">
                                        <input type="password" placeholder="Password" name="password" required>
                                    </div>
                                    <div class="pass">
                                        <input type="password" placeholder="Confirm Password" name="confirm_password" required>
                                    </div>
                                    

                                    <div class="l-submit">
                                        <button type="submit" name="resetbtn"> Reset Password</button>
                                    </div>
                                        <div class="custom-tick">
                                        <input type="checkbox">
                                        <label>Remember Me</label>
                                    </div>
                                </form>
                            </div>
                            <div class="logSocial">
                                <!-- <h4>or</h4>
                                <div class="ls-Item">
                                    <a href="#"><i class="fa fa-google-plus"></i></a>
                                    <a href="#"><i class="fa fa-facebook"></i></a>
                                    <a href="#"><i class="fa fa-twitter"></i></a>
                                </div> -->
                                <a href="#" class ="createAccount" data-toggle="modal" data-target="#logIn" data-dismiss="modal">Log In</a>
                                <a href="#" class ="createAccount" data-toggle="modal" data-target="#signUp" data-dismiss="modal">Create an account</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        

        </div>


    
          <script src='https://code.jquery.com/jquery-2.2.4.min.js'></script>

    <script type="text/javascript">

$(document).ready(function() {

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
    </script>

    <script src="assets/js/jquery-1.10.2.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script src="assets/js/custom.js"></script>

</body>

</html>