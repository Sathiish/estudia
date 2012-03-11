<?php

class Theme extends AppModel{
    
    public $actsAs = array('Containable');
     
    public $belongsTo = array('Matiere', 'Classe');

    public $hasMany = array('Cour');
    
    function beforeSave($options = array()) {
        if(!empty($this->data['Theme']['name'])){
            $this->data['Theme']['slug'] = strtolower(Inflector::slug($this->data['Theme']['name'], '-'));
        }
                
        return true;
    }
    
    
    function findPath($themeId){
        $path = $this->find('first', array(
            "fields" => "Theme.id, Theme.name, Theme.slug",
            "conditions" => "Theme.id = $themeId",
            "contain" => array(
                "Matiere" => array(
                    "fields" => array("Matiere.id, Matiere.name, Matiere.slug")
                ),
                "Classe" => array(
                    "fields" => array("Classe.id, Classe.name, Classe.slug"),
                    "limit" => 1
                ) 
            )
        ));
        
        return $path;
    }
    
}
?>
