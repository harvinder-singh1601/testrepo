<?php
session_start();
require_once 'init.php';
if ($_POST) {
    $userid=$_SESSION['userSession'];
    $gameid=$_POST['gameid'];
    $quizid=$_POST['quizid'];
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
    $count = 0;
    $im = 0;
    $up = Upload::Files($_FILES['question_image']);
    if($quizid=="")
    {
        $quiz_id = Quiz::Create($_POST['survey_name'], $isRandomized,$gameid,$userid);
    }
    else
    {
        $quizans=Quiz::Update($_POST['survey_name'], $isRandomized,$gameid,$quizid);
        $quiz_id=$quizid;
    }
    $questions = Question::display($quiz_id);
    foreach ($questions as $question) {
        $ans=Answers::delete($question['Question_id']);
        
        }
    $ques=Question::delete($quiz_id);
    
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