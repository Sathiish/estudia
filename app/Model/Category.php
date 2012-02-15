<?php

class Category extends AppModel{
    
    public $hasMany = 'Forum';

        function beforeSave($options = array()) {
        $this->data['Category']['slug'] = strtolower(Inflector::slug($this->data['Category']['name'], '-'));
        
        return true;
    }
    
}
?>
