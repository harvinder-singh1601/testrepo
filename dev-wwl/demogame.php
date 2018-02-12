<?php
include 'dbConfig.php';
if($_REQUEST['set'])
{
    $update="update game set Level='".$_REQUEST['gamelevel']."' where id='".$_REQUEST['id']."'";
    mysqli_query($db,$update) or die("Cannot Execute");
}

 $select="select * from game where id='".$_REQUEST['id']."'";

$select_rs=mysqli_query($db,$select) or die("Cannot Execute Query".mysqli_error($db));

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
       window.top.location.href = "http://winwinlabs.com/developer/test/games.php";
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

	  <div id="game_chosen" style="display:none;"><span class="game_chosen">default</span></div>
        <div id="playPanel" style="display:none;background-color:white;color:#ff5454;">

            

          <!--  <h3 id="imgTitle">Guess Image Name: <input type="text"/></h3> <hr /> -->

            <!-- Time Limit - <?php echo $select_row['time_limit']." Seconds";?><br />

             Step Limit - <?php echo $select_row['Steps'];?><br />-->
             
             

            
             <div id="actualImageBox" style="margin: 5px;width:100%;font-size:16px">
             <div style="display: inline-block;padding-right:220px;font-size: 12px;vertical-align: top;"><a href="javascript:void(0)" onclick="go()">Back To Games</a>&nbsp;&nbsp;<a href="javascript:void(0)" onclick="goedit()">Edit Games</a></div>
             <div style="display:inline-block;font-size: 18px;vertical-align: top;"><b><?php echo $select_row['name']?></b></div>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
              <form style="display: inline-block;margin:0px;vertical-align: top;" method="post"><div>
             <div style="padding-left: 300px;">Change Level: <select id="gamelevel" name="gamelevel" onchange="imagegrid()">
                        <?php
                            for($j=4;$j<21;$j=$j+1)
                            {?>
                                <option <?php if($select_row['Level']==$j) echo "selected";?> value='<?php echo $j?>'><?php echo $j?></option>
                                <?php
                            }
                            ?>
                        
                        </select>&nbsp;&nbsp;<input type="submit" name="set" id="set" value="Set This Level" /></div><br />
            
             
             <?php
             $level=$select_row['Level'];
             ?>
            <!-- Credit Cost To Play - <?php echo $select_row['credit_cost']?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
             Credit  Value Of The Game  - <?php echo $select_row['value_of_the_game']?> -->
             </div>

                    <div style="display: inline-block;">

                        

                    </div>

           </form>        

                  

                   
                </div>

             <hr style="margin: 0px;" />

			

            <div style="display:inline-block; margin:auto; width:95%; vertical-align:top;">

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
        function imagegrid()
        {
            var level=document.getElementById("gamelevel").value;
            
            var images = [

            

                { src: '<?php echo $image?>', title: 'Taj Mahal' }

            ];



            $(function () {

                var gridSize = level; //$('#levelPanel :radio:checked').val();

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
        }
        
        </script>



        <script>
        
         
               
                
window.onload = function () {

       //$("#sortable li").css("-webkit-filter", "blur(30px)");

       

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

         span = document.getElementById("count");

         span.innerHTML = counter;

         final_time = document.getElementById("timeCounts");

         final_time.innerHTML = span.innerHTML;

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
function go()
{
    window.top.location.href = "game-draft-publish.php";
}
function goedit()
{
    window.top.location.href = "edit_game_puzzle.php?id=<?php echo $_REQUEST['id']?>&page=demo";
}
imagegrid(2);
</script>





</div>









