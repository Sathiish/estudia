<?php

class SousPartie extends AppModel{
    
    public $actsAs = array('Containable');
    
    public $belongsTo = array('Partie', 'User');
    
    function beforeSave($options = array()) {
        parent::beforeSave($options); 
        if(!empty($this->data['SousPartie']['name'])){
            $this->data['SousPartie']['slug'] = strtolower(Inflector::slug($this->data['SousPartie']['name'], '-'));
        }
                
        return true;
    }
    
    public function getPath($sousPartieId){
        
        $path = $this->find('first', array(
            "fields" => array("SousPartie.id, SousPartie.name, SousPartie.slug, SousPartie.partie_id"),
            "conditions" => "SousPartie.id = $sousPartieId",
            "contain" => array(
                "Partie" => array(
                    "fields" => array("Partie.id, Partie.name, Partie.slug, Partie.cour_id"),
                    "Cour" => array(
                        "fields" => array("Cour.id, Cour.name, Cour.slug, Cour.theme_id")
                    )
                )
             )
        ));
        
        return $path;
    } 
    
}
?>
