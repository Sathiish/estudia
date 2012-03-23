<?php

class Theme extends AppModel{
    
    public $actsAs = array('Containable');
     
    public $belongsTo = array('Matiere');

    public $hasMany = array('Cour', 'Ressource');
    
    function beforeSave($options = array()) {
        if(!empty($this->data['Theme']['name'])){
            $this->data['Theme']['slug'] = strtolower(Inflector::slug($this->data['Theme']['name'], '-'));
        }
                
        return true;
    }
    
    
    public function findPath($themeId){
        $path = $this->find('first', array(
            "fields" => "Theme.id, Theme.name, Theme.slug, Theme.matiere_id",
            "conditions" => "Theme.id = $themeId",
            "contain" => array(
                "Matiere" => array(
                    "fields" => array("Matiere.id, Matiere.name, Matiere.slug, Matiere.classe_id"),
                    "Classe" => array(
                        "fields" => array("Classe.id, Classe.name, Classe.slug"),
                        "limit" => 1
                    ) 
                )
            )
        ));
        
        return $path;
    }
   
    function getAllthemes($matiereId){
            if($matiereId != null){
                $condition = "Theme.matiere_id = $matiereId";
            }else{
                $condition = "1 = 1";
            }
            
            $AllThemes = $this->find('list', array(
                "fields" => "id, name",
                "conditions" => $condition,
                "order" => "id ASC"
            ));

            return $AllThemes;
        }
}
?>
