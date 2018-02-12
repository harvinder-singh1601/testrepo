<?php
class Quiz {
    public static function Create($quiz_name, $quiz_randomize,$gameid,$userid) {
        return DB::getInstance()->insert('Quiz', [
            'Quiz_name' => $quiz_name,
            'Quiz_randomized' => $quiz_randomize,
            'game_id'=>$gameid,
            'user_id'=>$userid
        ]);
    }
    public static function Update($quiz_name, $quiz_randomize,$gameid,$quizid) {
        return DB::getInstance()->update('Quiz','Quiz_id='.$quizid,[
            'Quiz_name' => $quiz_name,
            'Quiz_randomized' => $quiz_randomize
        ]);
        
    
    }
    public static function display($Quiz_id) {
        $quiz_sql = DB::getInstance()->get("Quiz", ["Quiz_id", "=", $Quiz_id]);
        return $quiz_sql->results();
    }
    
}