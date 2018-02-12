<?php
include 'dbConfig.php';
require_once "Models/init.php";
if ($_GET) {
    
    $game="select * from game where id='".$_REQUEST['game_id']."'";
    $game_rs=mysqli_query($db,$game) or die("Cannot Execute Query".mysqli_error($db));
    $game_row=mysqli_fetch_array($game_rs);
    //get quiz id
    $select="select * from Quiz where game_id='".$_REQUEST['game_id']."'";
    $select_rs=mysqli_query($db,$select) or die("Cannot Execute Query".mysqli_error($db));
    $select_row=mysqli_fetch_array($select_rs);
    
    //$id = $_GET["id"];
    $id=$select_row['Quiz_id'];
    $quiz = Quiz::display($id);
    if ($quiz[0]['Quiz_randomized'] == 1) {
        $questions = Question::Random($quiz[0]['Quiz_id']);
    } else {
        $questions = Question::display($id);
    }
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <title><?=$quiz[0]['Quiz_name'];?></title>

    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
    <meta name="viewport" content="width=device-width" />

    <link rel="apple-touch-icon" sizes="76x76" href="assets_quiz/img/apple-icon.png" />
    <link rel="icon" type="image/png" href="assets_quiz/img/favicon.png" />

    <!--     Fonts and icons     -->
    <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Roboto+Slab:400,700|Material+Icons" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" />

    <!-- CSS Files -->
    <link href="assets_quiz/css/bootstrap.min.css" rel="stylesheet" />
    <link href="assets_quiz/css/material-bootstrap-wizard.css" rel="stylesheet" />
    <script src="assets_quiz/js/jquery-2.2.4.min.js" type="text/javascript"></script>
 <script type="text/javascript" src="rating.js"></script>
      
    <!-- CSS Just for demo purpose, don't include it in your project -->
    <link href="assets_quiz/css/demo.css" rel="stylesheet" />
    <link href="assets_quiz/css/style.css" rel="stylesheet" />
     <link href="http://www.cssscript.com/wp-includes/css/sticky.css" rel="stylesheet" type="text/css">



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

    <link href="rating.css" rel="stylesheet" type="text/css">

</head>

<body>
<div class="image-container set-full-height">
    <!--   Big container   -->
    <div class="container">
        <div class="row">
            <div class="col-sm-8 col-sm-offset-2">
                <!--      Wizard container        -->
                <div class="wizard-container" style="padding: 10px !important;">
                    <div class="card wizard-card" data-color="red" id="wizard">
<!--<div style="display: inline;padding-left:20px;font-size: 12px;" id="creditinfo"><b>Credit Cost To Play - <?php echo $game_row['credit_cost']?> &nbsp;&nbsp;&nbsp;&nbsp;Credit Value Of The Game - <?php echo $game_row['value_of_the_game']?></b></div> -->
             <div style="display: inline-block;padding-left:20px;" id="headerinfo">

                        <div class="wrapper" >

                        <!-- <p>Time Left:<span id="count"><?php echo $select_row['time_limit'];?></span> seconds<br/></p> -->

                        <p style="font-size: 12px;"><b>Time Left : <span id="count" class="count"></span> seconds</b></p>



                        <button id="button-start" style="display: none;">Start</button>

                 

                        </div>



                       

                    </div>
                        <form action="" method="post" id="question_form">
                            <!--        You can switch " data-color="blue" "  with one of the next bright colors: "green", "orange", "red", "purple"             -->
                            <div class="wizard-header" style="padding-top: 10px !important;padding-bottom: 10px;">
                                <h3 class="wizard-title">
                                    <?=$quiz[0]['Quiz_name'];?>
                                </h3>
                            </div>
                            <div class="wizard-navigation hidden">
                                <ul>
                                    <? foreach ($questions as $question) { ?>
                                    <li><a href="#<?=$question['Question_id']?>" data-toggle="tab"><?=$question['Question_text']?></a></li>
                                    <? }?>
                                </ul>
                            </div>

                            <div class="tab-content">
                                <?
                                    foreach ($questions as $question) {
                                        if ($question['Question_type'] == "many") {
                                            echo '<div class="tab-pane" id="' . $question["Question_id"] . '">
                                        <div class="row">
                                            '.(($question["Question_image"] == Null)? "" : "
                                            <div class=\"col-md-7 col-md-offset-3\">
                                                <img src=".$question['Question_image']." class=\"img-responsive question-image\" />
                                            </div>
                                        ").'
                                            <div class="col-md-12">
                                                <h4 class="text-center text-bold">' . $question["Question_text"] . '</h4>
                                            </div>
                                            <div class="col-sm-10 col-sm-offset-1">
                                                <div id="answers_id">
                                                    ';
                                            $answers = Answers::display($question['Question_id']);
                                            foreach ($answers as $answer) {
                                                print '<div class="col-sm-12">
                                                            <div class="choice" data-toggle="wizard-radio">
                                                                <label class="element animation1 btn btn-lg btn-default btn-block">
                                                                    <input type="radio" name ="' . $question["Question_id"] . '" value = "' . $answer["Answer_id"] . '">
                                            ' . $answer["Answer_text"] . '
                                                                </label> 
                                                            </div>
                                                        </div>';
                                            }
                                            echo '
                                                </div>
                                            </div>
                                        </div>
                                    </div>';
                                        } else if ($question['Question_type'] == "one") {
                                            echo '<div class="tab-pane" id="' . $question["Question_id"] . '">
                                    <div class="row">
                                        '.(($question["Question_image"] == Null)? "" : "
                                            <div class=\"col-md-10 col-md-offset-1\">
                                            <img src=".$question['Question_image']." class=\"img-responsive question-image center-block\" />
                                        </div>
                                        ").'
                                        <div class="col-md-12">
                                            <h4 class="text-center text-bold">' . $question["Question_text"] . '</h4>
                                        </div>
                                        <div class="col-sm-10 col-sm-offset-1">
                                            <div id="answers_id">
                                                ';
                                            $answers = Answers::display($question['Question_id']);
                                            print '<div class="col-sm-12">
                                                        <div class="form-group label-floating">
                                                            <label class="control-label">' . $question["Question_text"] . '</label>
                                                            <input name="'.$question["Question_id"].'" type="text" class="form-control">
			                                            </div>
                                                        </div>
                                                    </div>
                                            </div>
                                    </div>
                                </div>';
                                        }

                                    }
                                ?>
                            </div>
                            <div class="wizard-footer">
                                <div class="pull-right">
                                    <input type='button' class='btn btn-next btn-fill btn-danger btn-wd' name='next' value='Next' />
                                    <input type='submit' class='btn btn-finish btn-fill btn-danger btn-wd' name='finish' id="finish" value='Finish' />
                                </div>
                                <div class="pull-left">
                                    <input type='button' class='btn btn-previous btn-fill btn-default btn-wd' name='previous' value='Previous' />
                                </div>
                                <div class="clearfix"></div>
                            </div>
                        </form>
                    </div>
                </div> <!-- wizard container -->
            </div>
        </div> <!-- row -->
    </div> <!--  big container -->

</div>
<div id="gameOver" style="display:none;color:black;font-weight:bold;">

            <div style="padding: 5px 10px 20px 10px; text-align: center;color:black;font-weight:bold; ">

                <h2 style="text-align:center">Game Over!!</h2>

                Your Score : <span style="color: black;font-weight:bold" id="myscore"></span><br />

                Time Taken: <span style="color: black;font-weight:bold" id="timeCounts">0</span> seconds<br />

               

            </div>

	         

	

        </div>	
<input type="hidden" name="game_id" id="game_id" value="<?php echo $_REQUEST['game_id']?>">
<input type="hidden" name="quiz_id" id="quiz_id" value="<?php echo $id?>">
<script>
function go()
{
    window.top.location.href = "gamelist.php";
}
function goedit()
{
    window.top.location.href = "edit_game.php?id=<?php echo $_REQUEST['gameid']?>&page=demo";
}
 var counter=10;
        var t=setInterval(runFunction,1000);
        
        function runFunction()
        {
        
            counter=counter-1;
            document.getElementById("counterdiv").innerHTML="Game Start In - "+counter;
            if(counter<0)
            {
                clearInterval(t);
                var buttonStart = document.getElementById('button-start');
                document.getElementById("counterdiv").innerHTML="";
                buttonStart.click(); 
                 $(".modalDialog").css({"opacity":"0","pointer-events":"none"});
                
            }
        }


window.onload = function () {

       $(".wizard-container").css("-webkit-filter", "blur(30px)");

       

  var buttonStart = document.getElementById('button-start');

 



  buttonStart.onclick = function() {

     $(".wizard-container").css("-webkit-filter", "none");


  // var ans=confirm("Once you click the start button, the game can't be stopped or reset. Continue to play the game?");
var ans=true;
         if(ans==true)

            {

                  document.getElementById("button-start").remove();



           var counter = 0;

   setInterval(function() {

     counter++;

      if (counter >= 0) {
        if(document.getElementById("count"))
        {

         span = document.getElementById("count");

         span.innerHTML = counter;
         }

         //final_time = document.getElementById("timeCounts");

         //final_time.innerHTML = span.innerHTML;

      }

  

     }, 1000);



         }
  }
  }
</script>
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

<div id="openModal" class="modalDialog">
      <div>
         
         <div id="modaldata"> <h2> <CENTER> <div id="counterdiv" style="color: black;font-weight:bold;"><b>Game Start In - 10</b> </div></CENTER></h2></div>
         <div id="game_rating" style="display:none;color: black;font-weight:bold;">
<br /><br />
 <input name="rating" value="0" id="rating_star" type="hidden" game_id="<?php echo $_REQUEST['game_id']?>" />

    <div class="overall-rating">(Average Rating <span id="avgrat"> </span>

Based on <span id="totalrat"> </span>  rating)</span></div>

<div id="feedback"class="feedback" style="vertical-align: top;">

			 <textarea name="game_feedback" id="game_feedback" style="max-width:100%;max-height:100px;border-radius:2px;" value=""> </textarea>

			  <br /><button type="button" style="border-radius: 5px;padding:5px;" id="post_feedback"  name="post_feedback">Post Feedback</button>

 

			 </div>

</div>	
          
   </div>
</div>



</body>
<!--   Core JS Files   -->
<script src="assets_quiz/js/bootstrap.min.js" type="text/javascript"></script>
<script src="assets_quiz/js/jquery.bootstrap.js" type="text/javascript"></script>

<!--  Plugin for the Wizard -->
<script src="assets_quiz/js/material-bootstrap-wizard.js"></script>

<!--  More information about jquery.validate here: http://jqueryvalidation.org/	 -->
<script src="assets_quiz/js/jquery.validate.min.js"></script>
<script src="assets_quiz/js/custom.js"></script>
</html>
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

       //alert(data);
       window.top.location.href = "http://winwinlabs.com/developer/dashboard/play-game.php";
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
