<?php
require_once "Models/init.php";
if ($_GET) {
    $id = $_GET["id"];
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

    <!-- CSS Just for demo purpose, don't include it in your project -->
    <link href="assets_quiz/css/demo.css" rel="stylesheet" />
    <link href="assets_quiz/css/style.css" rel="stylesheet" />
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
<div style="display: inline;padding-left:20px;font-size: 12px;"><a href="javascript:void(0)" onclick="go()">Back To Games</a>&nbsp;&nbsp;&nbsp;&nbsp;<a href="javascript:void(0)" onclick="goedit()">Edit Games</a></div>
             
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
                                            <div class=\"col-md-10 col-md-offset-1\">
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
                                    <input type='button' class='btn btn-finish btn-fill btn-danger btn-wd' name='finish12' id="finish12" value='Finish' />
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
<input type="hidden" name="game_id" id="game_id" value="<?php echo $_REQUEST['game_id']?>">
<input type="hidden" name="quiz_id" id="quiz_id" value="<?php echo $id?>">
<script>
function go()
{
    window.top.location.href = "game-draft-publish.php";
}
function goedit()
{
    window.top.location.href = "edit_game_quiz.php?id=<?php echo $_REQUEST['gameid']?>&page=demo";
}
</script>
</body>
<!--   Core JS Files   -->
<script src="assets_quiz/js/jquery-2.2.4.min.js" type="text/javascript"></script>
<script src="assets_quiz/js/bootstrap.min.js" type="text/javascript"></script>
<script src="assets_quiz/js/jquery.bootstrap.js" type="text/javascript"></script>

<!--  Plugin for the Wizard -->
<script src="assets_quiz/js/material-bootstrap-wizard.js"></script>

<!--  More information about jquery.validate here: http://jqueryvalidation.org/	 -->
<script src="assets_quiz/js/jquery.validate.min.js"></script>
<script src="assets_quiz/js/custom.js"></script>
</html>
