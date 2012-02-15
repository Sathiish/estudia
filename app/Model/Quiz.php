<?php

class Quiz extends AppModel{
    
    public $actsAs = array('Containable');
        
    var $useTable= "quiz";
    
    public $validate = array(
                    'name' => array(
                            'required' => array(
                                    'rule' => array('notEmpty'),
                                    'required' => true, 
                                    'allowEmpty' => false,
                                    'message' => 'Vous devez entrer un nom de quiz')
                    ),
                    'description' => array(
                            'required' => array(
                                    'rule' => array('notEmpty'),
                                    'required' => true, 
                                    'allowEmpty' => false,
                                    'message' => 'Veuillez entrer une description')
                    )
            );
        
    public $hasMany = array(
                        'Question'=> array(
                            'dependent' => true
                        ), 
                        'UserAnswer');
    public $belongsTo = array('Ressource', 'User');
    
    function beforeSave($options = array()) {
        if(!empty($this->data['Quiz']['name'])){
            $this->data['Quiz']['slug'] = strtolower(Inflector::slug($this->data['Quiz']['name'], '-'));
        }
        
        return true;
    }
  
    function isPublic($quizId){
        $quizToEdit = $this->find('first', array(
            "fields" => "Quiz.public, Quiz.validation",
            "conditions" => "Quiz.id = $quizId",
            "contain" => array()
        ));
        
        if($quizToEdit['Quiz']['public'] == 1 OR $quizToEdit['Quiz']['validation'] == 1){            
            return true;
        }
        
        return false;
    }
}