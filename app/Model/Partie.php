<?php

class Partie extends AppModel{
    
    public $actsAs = array('Containable');
    
    public $belongsTo = array('Cour', 'User');
    
    public $hasMany = array('SousPartie');
    
    function beforeSave($options = array()) {
        parent::beforeSave($options); 
        if(!empty($this->data['Partie']['name'])){
            $this->data['Partie']['slug'] = strtolower(Inflector::slug($this->data['Partie']['name'], '-'));
        }
                
        return true;
    }
    
    public function getPath($partieId){
        
        $path = $this->find('first', array(
            "fields" => "Partie.id, Partie.name, Partie.slug",
            "conditions" => "Partie.id = $partieId",
            "contain" => array(
                "Cour" => array(
                        "fields" => array("Cour.name, Cour.slug, Cour.id, Cour.theme_id"),
                        "Theme" => array(
                            "fields" => array("Theme.id, Theme.name"),
                            "Matiere" => array(
                                "fields" => array("Matiere.id, Matiere.name")
                            )
                        )
                )
            )
        ));
        
        return $path;
    } 
    
    
}
?>
