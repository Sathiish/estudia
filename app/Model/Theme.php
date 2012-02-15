<?php

class Theme extends AppModel{
    
    public $actsAs = array('Containable');
     
    public $belongsTo = 'Matiere';
    
    public $hasMany = array('Cour', 'CourTag');
    
    function beforeSave($options = array()) {
        $this->data['Theme']['slug'] = strtolower(Inflector::slug($this->data['Theme']['name'], '-'));
        
        return true;
    }
    
}
?>
