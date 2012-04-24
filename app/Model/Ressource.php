<?php

class Ressource extends AppModel{
    
    public $actsAs = array('Containable');
         
    public $belongsTo = array('User', 'Theme');
        
    //public $hasMany = array('CourNote', 'CourFavori');
    //public $hasMany = array('CourFavori');
    public $hasMany = array('Media');
    
    function beforeSave($options = array()) {
        parent::beforeSave($options); 
        if(!empty($this->data['Ressource']['name'])){
            $this->data['Ressource']['slug'] = strtolower(Inflector::slug($this->data['Ressource']['name'], '-'));
        }
        
        if(!$this->id){
            $this->data['Ressource']['codeweb'] = substr(uniqid(),1, 6);
        }
        return true;
    }
    
//    public function getPath($coursId){
//        
//        $path = $this->find('first', array(
//            "fields" => array("Cour.id, Cour.name, Cour.slug"),
//            "conditions" => array("Cour.id" => $coursId),
//            "contain" => array(
//                "Theme" => array(
//                    "fields" => array("Theme.id, Theme.name, Theme.slug"),
//                    "limit" => 1,
//                    "Matiere" => array(
//                        "fields" => array("Matiere.id, Matiere.name, Matiere.slug")
//                    ),
//                    "Classe" => array(
//                        "fields" => array("Classe.id, Classe.name, Classe.slug"),
//                        "limit" => 1
//                    ) 
//                )
//            )
//        ));
//        
//        return $path;
//    } 
    
    public function filAriane($ressourceId){
        $filAriane = $this->find('first', array(
            'conditions' => "Ressource.id = $ressourceId",
            'fields' => array('Ressource.id, Ressource.name, Ressource.slug, Ressource.theme_id'),
            'contain' => array(
                'Theme' => array(
                    'fields' => array('Theme.id, Theme.name, Theme.slug, Theme.matiere_id'),
                    'Matiere' => array(
                        'fields' => array('Matiere.id, Matiere.name, Matiere.slug'),
                        'Classe' => array(
                            'fields' => array('Classe.id, Classe.name, Classe.slug'),
                            'Niveau' => array()
                        )
                    )
                )
            )
        ));
                
        return $filAriane;
    }
    
}
?>
