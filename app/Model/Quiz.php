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
                        'UserAnswer'
        );
    
    public $belongsTo = array('Theme', 'User');
    
    function beforeSave($options = array()) {
        parent::beforeSave($options);
        if(!empty($this->data['Quiz']['name'])){
            $this->data['Quiz']['slug'] = strtolower(Inflector::slug($this->data['Quiz']['name'], '-'));
        }

        return true;
    }    

}