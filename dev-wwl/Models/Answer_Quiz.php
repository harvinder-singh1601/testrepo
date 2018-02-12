<?php
session_start();
require_once 'init.php';
if($_POST) {
    $right_answers = 0;
    Answers::deletequiz($_SESSION['userSession'],$_REQUEST['gameid']);
    foreach($_POST as $Question => $Answerdata)
    {
        $Answerval=explode(":",$Answerdata);
        $Answer=$Answerval[0];
        if (!empty($Answer) && !empty($Question)) {
            
            $right = Answers::isRight($Answer, $Question);
            if ($right) {
                $rightval='yes';
                $right_answers++;
            }
            else
            {
                $rightval='no';
            }
            if($Answerval[1]=="radio")
            {
                $answertext=Answers::displayanswer($Answer);
            }
            else
            {
                $answertext=$Answer;
            }
            //insert data in user_answer
            $ansques= Answers::insertAnswer($_SESSION['userSession'],$_REQUEST['gameid'],$answertext, $Question,$rightval,$_REQUEST['quizid']);
        }
    }
    header('Content-Type: application/json');
    $result["score"] = number_format(($right_answers/$_POST['num_q'])*100,2);
    Answers::insertHistory($_SESSION['userSession'],$_REQUEST['timecount'],$_REQUEST['gameid'],$result["score"] );
    $result["user"]=$_SESSION['userSession'];
    $result["game"]=$_REQUEST['gameid'];
    die(json_encode($result));
}