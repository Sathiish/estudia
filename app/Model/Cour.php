<?php

class Cour extends AppModel{
    
    public $actsAs = array('Containable');
    
    var $useTable= "cours";
     
    public $belongsTo = array('User', 'Theme');
    
    public $hasMany = array('Partie', 'CourTag', 'CourNote', 'CourFavori');
    
    public $hasAndBelongsToMany = array('Tag');
    
    function beforeSave($options = array()) {
        parent::beforeSave($options); 
        if(!empty($this->data['Cour']['name'])){
            $this->data['Cour']['slug'] = strtolower(Inflector::slug($this->data['Cour']['name'], '-'));
        }
        
        if(!$this->id){
            $this->data['Cour']['raccourci'] = substr(uniqid(),1, 6);
        }
        return true;
    }
    
    public function getPath($coursId){
        
        $path = $this->find('first', array(
            "fields" => array("Cour.id, Cour.name, Cour.slug"),
            "conditions" => array("Cour.id" => $coursId),
            "contain" => array(
                "Theme" => array(
                    "fields" => array("Theme.id, Theme.name, Theme.slug"),
                    "limit" => 1,
                    "Matiere" => array(
                        "fields" => array("Matiere.id, Matiere.name, Matiere.slug")
                    )
                )
            )
        ));
        
        return $path;
    } 
    
}
?>
