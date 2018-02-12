<?php
class Question {
    public static function Create($question_text, $question_type, $question_isRequired, $question_quizId, $image) {
        return DB::getInstance()->insert('Question', [
            'Question_text' => $question_text,
            'Question_type' => $question_type,
            'Question_isRequired' => $question_isRequired,
            'Question_Quiz_id' => $question_quizId,
            'Question_image'   => $image
        ]);
    }
    public static function display($Quiz_id) {
        $questions_sql = DB::getInstance()->get("Question", ["Question_Quiz_id", "=", $Quiz_id]);
        return $questions_sql->results();
    }
    public static function Random($Quiz_id) {
        $questions_sql = DB::getInstance()->query("SELECT * FROM `Question` WHERE Question_Quiz_id = ? ORDER BY RAND()", [$Quiz_id]);
        return $questions_sql->results();
    }
    public static function delete($Quiz_id) {
        $questions_sql = DB::getInstance()->query("delete FROM `Question` WHERE Question_Quiz_id = ?", [$Quiz_id]);
        return $questions_sql->results();
    }
}