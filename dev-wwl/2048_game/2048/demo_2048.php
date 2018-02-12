<?php
include '../../dbConfig.php';

    
    $game="select * from game where id='".$_REQUEST['id']."'";
    $game_rs=mysqli_query($db,$game) or die("Cannot Execute Query".mysqli_error($db));
    $game_row=mysqli_fetch_array($game_rs);
 
?>
<!DOCTYPE html>
<html>
<head>

  <meta charset="utf-8">
  <title>2048</title>

  <link href="style/main.css" rel="stylesheet" type="text/css">
  <link rel="shortcut icon" href="favicon.ico">
  <link rel="apple-touch-icon" href="meta/apple-touch-icon.png">
  <link rel="apple-touch-startup-image" href="meta/apple-touch-startup-image-640x1096.png" media="(device-width: 320px) and (device-height: 568px) and (-webkit-device-pixel-ratio: 2)"> <!-- iPhone 5+ -->
  <link rel="apple-touch-startup-image" href="meta/apple-touch-startup-image-640x920.png"  media="(device-width: 320px) and (device-height: 480px) and (-webkit-device-pixel-ratio: 2)"> <!-- iPhone, retina -->
  <meta name="apple-mobile-web-app-capable" content="yes">
  <meta name="apple-mobile-web-app-status-bar-style" content="black">

  <meta name="HandheldFriendly" content="True">
  <meta name="MobileOptimized" content="320">
  <meta name="viewport" content="width=device-width, target-densitydpi=160dpi, initial-scale=1.0, maximum-scale=1, user-scalable=no, minimal-ui">
<style>
.score-container, .best-container
{
    background-color: #fd4f35;
}
.game-container
{
    background-color: #fd4f35;
}

</style>
</head>
<body>
  <div class="container">
  <div>
  <a style="font-size: 12px;text-decoration: none;" href="javascript:void(0)" onclick="go()">Back To Games</a>&nbsp;&nbsp;&nbsp;&nbsp;<a style="font-size: 12px;text-decoration: none;" href="javascript:void(0)" onclick="goedit()">Edit Games</a>
  </div>
    <div class="heading">
      <font size='40px' color="#fd4f35"><?php echo $game_row['name']?></font>
      <div class="scores-container">
        <div class="score-container">0</div>
        <div class="best-container">0</div>
      </div>
    </div>

    <div class="above-game">
      <!--<p style="padding-top: 22px;" class="game-intro">Credit Cost To Play - <?php echo $game_row['credit_cost']?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Credit Value Of The Game - <?php echo $game_row['value_of_the_game']?></p> -->
      <a style="display: none;" class="restart-button"></a> 
      
    </div>

    <div class="game-container">
     <div class="game-message">
        <p></p>
        <div class="lower">
	        <a class="keep-playing-button"></a>
          <a class="retry-button"></a>
        </div>
      </div>

      <div class="grid-container">
        <div class="grid-row">
          <div class="grid-cell"></div>
          <div class="grid-cell"></div>
          <div class="grid-cell"></div>
          <div class="grid-cell"></div>
        </div>
        <div class="grid-row">
          <div class="grid-cell"></div>
          <div class="grid-cell"></div>
          <div class="grid-cell"></div>
          <div class="grid-cell"></div>
        </div>
        <div class="grid-row">
          <div class="grid-cell"></div>
          <div class="grid-cell"></div>
          <div class="grid-cell"></div>
          <div class="grid-cell"></div>
        </div>
        <div class="grid-row">
          <div class="grid-cell"></div>
          <div class="grid-cell"></div>
          <div class="grid-cell"></div>
          <div class="grid-cell"></div>
        </div>
      </div>

      <div class="tile-container">

      </div>
    </div>

   
  </div>
  <script>
function go()
{
    window.top.location.href = "../../game-draft-publish.php";
}
function goedit()
{
    window.top.location.href = "../../edit_game_quiz.php?id=<?php echo $_REQUEST['id']?>&page=demo";
}
 
</script>
 <style class="cp-pen-styles">



     .wrapper {

     width: 200px;

    /*color: #fff;*/

    text-align: center;

    }



    #seconds, #tens {

  font-size: 2em;

}

  .overall-rating{font-size: 14px;margin-top: 5px;color: black;}



    </style>

    <link href="../../rating.css" rel="stylesheet" type="text/css">

<style>
.modalDialog {
	position: fixed;
	font-family: Arial, Helvetica, sans-serif;
	top: 0;
	right: 0;
	bottom: 0;
	left: 0;
	background: rgba(0,0,0,0.8);
	z-index: 99999;
	opacity:1;
	-webkit-transition: opacity 400ms ease-in;
	-moz-transition: opacity 400ms ease-in;
	transition: opacity 400ms ease-in;
	pointer-events: auto;
}
.modalDialog:target {
	opacity:1;
	pointer-events: auto;
}

.modalDialog > div {
	width: 400px;
	position: relative;
	margin: 10% auto;
	padding: 5px 20px 13px 20px;
	border-radius: 10px;
	background: #fff;
	background: -moz-linear-gradient(#fff, #999);
	background: -webkit-linear-gradient(#fff, #999);
	background: -o-linear-gradient(#fff, #999);
}

.close {
	background: #606061;
	color: #FFFFFF;
	line-height: 25px;
	position: absolute;
	right: -12px;
	text-align: center;
	top: -10px;
	width: 24px;
	text-decoration: none;
	font-weight: bold;
	-webkit-border-radius: 12px;
	-moz-border-radius: 12px;
	border-radius: 12px;
	-moz-box-shadow: 1px 1px 3px #000;
	-webkit-box-shadow: 1px 1px 3px #000;
	box-shadow: 1px 1px 3px #000;
}

.close:hover { background: #00d9ff; }

</style>
<input type="hidden" name="game_id" id="game_id" value="<?php echo $_REQUEST['game_id']?>">

<div id="gameOver" style="display:none;color:black;font-weight:bold;">

            <div style="padding: 5px 10px 20px 10px; text-align: center;color:black;font-weight:bold; ">

                <h2 style="text-align:center">Game Over!!</h2>
                
                <div id="messageforgame"></div>
                 <br />

                Time Taken: <span style="color: black;font-weight:bold" id="timeCounts">0</span> seconds<br />

               

            </div>

	         

	

        </div>


  <script src="js/bind_polyfill.js"></script>
  <script src="js/classlist_polyfill.js"></script>
  <script src="js/animframe_polyfill.js"></script>
 <!-- <script src="js/keyboard_input_manager.js"></script>-->
  <script src="js/html_actuator.js"></script>
  <script src="js/grid.js"></script>
  <script src="js/tile.js"></script>
  <script src="js/jquery.min.js"></script>
  <script src="js/local_storage_manager.js"></script>
  <script src="js/game_manager.js"></script> 
  <script src="js/application.js"></script>
  <script type="text/javascript" src="../../rating.js"></script>
      <script language="javascript" type="text/javascript">

$(function() {

    $("#rating_star").codexworld_rating_widget({


        starLength: '5',

        initialValue: '',

        callbackFunctionName: 'processRating',

        imageDirectory: 'images/',

        inputAttr: 'game_id'

    });

});

   $(document).ready(function() {

 

   $('#post_feedback').click(function() {
   

   var feedback=$('#game_feedback').val();

          $.ajax({

        type: 'POST',

        url: 'rating.php',

        data: { game_id: <?php echo $_REQUEST['game_id'];?>,feedback:feedback},  

        success : function(data) {

       alert(data);
       window.top.location.href = "http://winwinlabs.com/developer/winwin/games.php";
           $('#feedback').empty();

                $('#feedback').html(data);

              

           

        }

    });

     });

	 

  $.ajax({

        type: 'GET',

        url: 'select_rating.php',

        data: 'game_id=<?php echo $_REQUEST['id']?>',

        dataType: 'json',

        success : function(data) {

               

                $('#avgrat').text(data.average);

                $('#totalrat').text(data.rating_number);

           

        }

    });

 });

function processRating(val, attrVal){
   

    $.ajax({

        type: 'POST',

        url: 'rating.php',

        data: 'game_id='+attrVal+'&rating='+val,

        dataType: 'json',

        success : function(data) {

            if (data.status == 'ok') {

                alert('You have rated '+val+' to CodexWorld');

                $('#avgrat').text(data.average_rating);

                $('#totalrat').text(data.rating_number);

            }else{

                alert('Some problem occured, please try again.');

            }

        }

    });

}

</script>
</body>
</html>
