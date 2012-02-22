<?php

class Question extends AppModel{
    
    public $actsAs = array('Containable');
        
    public $validate = array(
                    'question' => array(
                            'required' => array(
                                    'rule' => array('notEmpty'),
                                    'required' => true, 
                                    'allowEmpty' => false,
                                    'message' => 'Veuillez entrer une question'),
                            'question_min' => array(
                                    'rule' => array('minLength', '3'),
                                    'message' => 'Votre question doit contenir au moins 3 caractères'))
            );
        
    public $hasMany = array(
                        'Answer' => array(
                            'dependent' => true
                        ), 
                        'UserAnswer');

    public $belongsTo = 'Quiz';
    
    function beforeSave($options = array()) {
       
        return true;
    }
    
    function getQuiz($quizId){
        $quiz = $this->Quiz->find('first', array(
            "fields" => "Quiz.id, Quiz.slug, Quiz.name, Quiz.published, Quiz.validation",
            "conditions" => "Quiz.id = $quizId",
            "contain" => array()
        ));
        return $quiz;
    }
    
    function isPublic($questionId){
        $question = $this->find('first', array(
            "fields" => "Question.quiz_id",
            "conditions" => "Question.id = $questionId",
            "contain" => array()
        ));
        
        $quizToEdit = $this->getQuiz($question['Question']['quiz_id']);

        if($quizToEdit['Quiz']['published'] == 1 OR $quizToEdit['Quiz']['validation'] == 1){            
            return true;
        }
        
        return false;
    }
  
}