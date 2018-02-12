<?php
session_start();
require_once 'init.php';
if ($_POST) {
    $userid=$_SESSION['userSession'];
    $gameid=$_POST['gameid'];
    $isRandomized = $_POST['Randomized'];
    $question_text = $_POST['question_text'];
    $has_image = $_POST['has_image'];
    $question_type = $_POST['question_type'];
    $q_required = $_POST['requiredQuestion'];
    $question_count = $_POST['questions_count'];
    $choices = $_POST['choice'];
    $choices_count = $_POST['choice_count'];
    $c_answer = $_POST['rightAnswers'];
    $oldimage=$_REQUEST['question_oldimage'];
    //print_r($question_text);
    echo "old-image=".$oldimage[0];
    $count = 0;
    $im = 0;
    $up = Upload::Files($_FILES['question_image']);
    $quiz_id = Quiz::Create($_POST['survey_name'], $isRandomized,$gameid,$userid);
    for ($i = 0; $i < $question_count[0]; $i++) {
        if($has_image[$i] == 0) {
            //$image = NULL;
            $image = $oldimage[$i];
        } else {
             $image ='uploads/'.$up[$im];
             $im++;
        }
        $questions_id = Question::Create($question_text[$i], $question_type[$i], $q_required[$i], $quiz_id, $image);
        for ($y = 0; $y < $choices_count[$i]; $y++) {
            $ans = Answers::Create($choices[$count],$c_answer[$count], $questions_id);
            $count++;
        }
    }
    if ($ans) {
        header('Content-Type: application/json');
        $Response["error"] = null;
        $Response["Quiz_id"] = $quiz_id;
        print json_encode($Response);
    }

}