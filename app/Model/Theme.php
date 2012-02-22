<?php

class Theme extends AppModel{
    
    public $actsAs = array('Containable');
     
    public $belongsTo = array('Matiere');

    public $hasMany = array('Cour', 'CourTag');
    
    function beforeSave($options = array()) {
        if(!empty($this->data['Theme']['name'])){
            $this->data['Theme']['slug'] = strtolower(Inflector::slug($this->data['Theme']['name'], '-'));
        }
                
        return true;
    }
    
    
    function findPath($themeId){
        $path = $this->find('first', array(
            "fields" => "Theme.id, Theme.name, Theme.slug",
            "contain" => array(
                "Matiere" => array(
                    "fields" => array("Matiere.id, Matiere.name, Matiere.slug")
                )
            )
        ));
        
        return $path;
    }
    
}
?>
