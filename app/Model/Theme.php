<?php

class Theme extends AppModel{
    
    public $actsAs = array('containable');
     
    public $belongsTo = array('Matiere');   
    public $hasMany = array('Cour', 'CourTag');
    
    function beforeSave($options = array()) {
        $this->data['Theme']['slug'] = strtolower(Inflector::slug($this->data['Theme']['name'], '-'));
        
        return true;
    }
    
}
?>
