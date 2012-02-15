<?php

class UserAnswer extends AppModel{
    
    public $actsAs = array('Containable');
    
    public $belongsTo = array('Answer', 'Question', 'User');
        
    
}
?>
