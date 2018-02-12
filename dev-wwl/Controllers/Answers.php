<?php
class Answers {
    public static function Create($answer_text, $answer_isRight, $answer_questionId) {
        return DB::getInstance()->insert('Answers', [
            'Answer_text' => $answer_text,
            'Answer_isRight' => $answer_isRight,
            'Answer_Question_id' => $answer_questionId
        ]);
    }
    public static function insertAnswer($user_id, $game_id, $answer,$question,$right,$quiz_id) {
        $question_sql = DB::getInstance()->query("SELECT * FROM Question WHERE Question_id = ?",[$question]);
        $questionres = $question_sql->results();
        $ques = $questionres[0]["Question_text"];
        return DB::getInstance()->insert('user_answer', [
            'game_id' => $game_id,
            'user_id' => $user_id,
            'Question' => $ques,
            'Answer' =>$answer,
            'right'  =>$right,
            'quiz_id'=>$quiz_id
        ]);
    }
    public static function display($Qustion_id) {
        $answers_sql = DB::getInstance()->get("Answers", ["Answer_Question_id", "=", $Qustion_id]);
        return $answers_sql->results();
    }
    public static function displayanswer($Answer_id) {
        $answers_sql = DB::getInstance()->get("Answers", ["Answer_id", "=", $Answer_id]);
        $answerrs =$answers_sql->results();
        return $answerrs[0]["Answer_text"];
        
    }
    public static function isRight($Answer, $Question) {
        $Answer = strtolower($Answer);
        $right_sql = DB::getInstance()->query("SELECT * FROM Answers WHERE ( Answer_id = ? AND Answer_Question_id = ? ) OR (Answer_text = ? AND Answer_Question_id = ?)",[$Answer, $Question, $Answer, $Question]);
        $isright = $right_sql->results();
        $right = $isright[0]["Answer_isRight"];
        $correct = $isright[0]["Answer_text"];
        if ($right == 1 || $Answer == $correct) {
            return true;
        } else {
            return false;
        }

    }
    public static function deletequiz($userid,$gameid) {
        $questions_sql = DB::getInstance()->query("delete FROM `user_answer` WHERE game_id = ? and user_id=?", [$gameid,$userid]);
        
    }
    public static function delete($Qustion_id) {
        $questions_sql = DB::getInstance()->query("delete FROM `Answers` WHERE Answer_Question_id = ?", [$Qustion_id]);
        
    }
    public static function insertHistory($user_id, $time, $game_id,$precentage) {
        $question_sql = DB::getInstance()->query("SELECT * FROM game WHERE id = ?",[$game_id]);
        $questionres = $question_sql->results();
        $credit = $questionres[0]["credit_cost"];
        return DB::getInstance()->insert('game_history', [
            'game_id' => $game_id,
            'user_id' => $user_id,
            'completed_in' => $time,
            'game_type' =>"3",
            'credit_deducted'  =>$credit,
            'quiz_percentage'=>$precentage
        ]);
    }
}