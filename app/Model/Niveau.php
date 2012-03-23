<?php

class Niveau extends AppModel{
    
    public $actsAs = array('Containable');
     
    public $hasMany = array('Classe');
    
    public function beforeSave($options = array()) {
        if(!empty($this->data['Niveau']['name'])){
            $this->data['Niveau']['slug'] = strtolower(Inflector::slug($this->data['Niveau']['name'], '-'));
        }
                
        return true;
    }
    
    public function getMenu(){
            
        $menu = $this->find('all', array(
            "fields" => array("Niveau.id, Niveau.name, Niveau.slug"),
            "contain" => array(
//                "Classe"=> array(
//                    'fields' => array('Classe.id, Classe.name, Classe.slug'),
//                    "Matiere" => array(
//                        'fields' => array('Matiere.id, Matiere.name, Matiere.slug')
//                    )
//                )
            )
        ));

        return $menu;
    }
}
?>
