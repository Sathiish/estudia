<?php

class Answer extends AppModel{
    
    public $actsAs = array('Containable');
    
    public $belongsTo = array('Question');
        
    function beforeSave($options = array()) {
        return true;
    }
    
    function getQuestion($questionId){
        $question = $this->Question->find('first', array(
            "fields" => "Question.id, Question.quiz_id, Question.question, Quiz.name, Quiz.id, Quiz.slug",
            "conditions" => "Question.id = $questionId",
            "recursive" => 0
        ));

        return $question;
    }
    
}
?>
