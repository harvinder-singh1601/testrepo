<?php

include "dbconnect.php";

 $select="select * from game where id='".$_REQUEST['id']."'";

$select_rs=mysqli_query($DBcon,$select) or die("Cannot Execute Query".mysqli_error($db));

$select_row=mysqli_fetch_array($select_rs);

?>
<input type="hidden" name="gameid" id="gameid" value="<?php echo $_REQUEST['id']?>">
<!DOCTYPE html>

<html xmlns="http://www.w3.org/1999/xhtml">

<head>
     <title>Image Puzzle</title>

    <link href="css/style.css" rel="stylesheet" />

    <link href="css/image-puzzle.css" rel="stylesheet" />

    <script src="js/jquery-2.1.1.min.js"></script>

 <script type="text/javascript" src="rating.js"></script>    <script src="js/jquery-ui.js"></script>

    <script src="js/image-puzzle.js"></script>

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

        data: { game_id: <?php echo $_REQUEST['id'];?>,feedback:feedback},  

        success : function(data) {

       alert(data);
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

 

</head>

<body>

    <div id="collage">
        <div id="playPanel" style="padding:5px;display:none;background-color:white;color:#ff5454;border-radius: 15px;padding-top:0px !important;margin-top:0px !important">
            <center> <div id="actualImageBox" style="margin: 2px;width:100%;font-size:16px;height:20px">
            <div id="stepBox" style="width: 15%;background-color: white;">

                        <div style="background-color: white;">Steps:</div><div style="background-color: white;" class="stepCount">0</div>

                    </div>
             <div style="display: inline-block;" style="font-size: 18px;"><b><?php echo $select_row['name']?></b></div>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            &nbsp;&nbsp;&nbsp;&nbsp;  
             <?php
             $level=$select_row['Level'];
             ?>

                    

                   

                  

                    <div style="display: inline-block;">

                        <div class="wrapper" >

                        <!-- <p>Time Left:<span id="count"><?php echo $select_row['time_limit'];?></span> seconds<br/></p> -->

                        <p>Time Left:<span id="count" class="count"></span> seconds<br/></p>



                        <button id="button-start" style="display: none;">Start</button>

                 

                        </div>



                       

                    </div>

                </div>
</center>
             

			

            <div style="display:inline-block; margin:auto; width:95%; vertical-align:top;padding-top:15px;">

                <ul id="sortable" class="sortable"></ul>

                

            </div>

        </div>

        <div id="gameOver" style="display:none;">

            <div style="padding: 5px 10px 20px 10px; text-align: center; ">

                <h2 style="text-align:center">Game Over!!</h2>

                Congratulations!! <br /> You have completed this picture.

                <br />

                Steps: <span class="stepCount">0</span> steps.

                <br />

                <!-- Time Taken: <span class="timeCount">0</span> seconds<br /> -->

                Time Taken: <span id="timeCounts">0</span> seconds<br />

               

            </div>

	         

	

        </div>	

<?php
if($select_row['Image']=="")
{
    $image="images/taj-mahal.jpg";
}
else
{
    $image=$select_row['Image'];
}
?>

        <script>



            var images = [

            

                { src: '<?php echo $image?>', title: 'Taj Mahal' }

            ];



            $(function () {

                var gridSize = <?php echo $level;?>; //$('#levelPanel :radio:checked').val();

                imagePuzzle.startGame(images, gridSize);

                $('#newPhoto').click(function () {

                    var gridSize = $('#levelPanel :radio:checked').val();  // Take the updated gridSize from UI.

                    imagePuzzle.startGame(images, gridSize);



                });





                $('#levelPanel :radio').change(function (e) {

                    var gridSize = $(this).val();

                    imagePuzzle.startGame(images, gridSize);

                           $("#sortable li").css("-webkit-filter", "blur(30px)");



                });

            });

            function rules() {

                alert('Re arrange the image parts in a way that it correctly forms the picture. \nThe no. of steps taken will be counted.');

            }

            

        </script>



        <script>
        
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

       $("#sortable li").css("-webkit-filter", "blur(30px)");

       

  var buttonStart = document.getElementById('button-start');

 



  buttonStart.onclick = function() {



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

         final_time = document.getElementById("timeCounts");

         final_time.innerHTML = span.innerHTML;
         }

      }

  

     }, 1000);



   imagePuzzle.enableSwapping('#sortable li');

     // clearInterval(Interval);

     // Interval = setInterval(startTimer, 10);

     $('#sortable li').draggable('enable');

     $("#sortable li").css("-webkit-filter", "none");

    // document.getElementById("newPhoto").disabled = true;

  

    

            

         }

         // use this for countdown method

   //       {

   //                document.getElementById("button-start").remove();



   //         var counter = <?php //echo $select_row['time_limit']?>;

   // setInterval(function() {

   //   counter--;

   //    if (counter >= 0) {

   //       span = document.getElementById("count");

   //       span.innerHTML = counter;

   //       final_time = document.getElementById("timeCounts");

   //       final_time.innerHTML = <?php //echo $select_row['time_limit']?> - span.innerHTML;

   //    }

   //    if (counter === 0) {

   //       alert('Sorry, you ran out of time.');

   //      $("#sortable li").css("-webkit-filter", "blur(30px)");

   //      document.getElementById("button-start").remove();





   //       clearInterval(counter);

   //     }

   //   }, 1000);



   // imagePuzzle.enableSwapping('#sortable li');

   //   // clearInterval(Interval);

   //   // Interval = setInterval(startTimer, 10);

   //   $('#sortable li').draggable('enable');

   //   $("#sortable li").css("-webkit-filter", "none");

   //   document.getElementById("newPhoto").disabled = true;

  

    

            

   //       }

          



  

  }

  

  

  



}

</script>





</div>
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
         
         <div id="modaldata"> <h2> <CENTER> <div id="counterdiv"> Game Start In - 10</div></CENTER></h2></div>
         <div id="game_rating" style="display:none;">
<br /><br />
 <input name="rating" value="0" id="rating_star" type="hidden" game_id="<?php echo $_REQUEST['id']?>" />

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

</html>



