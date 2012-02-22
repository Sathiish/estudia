<?php

class AppModel extends Model{
    
    public $actsAs = array('Containable');
    
    public function isAuthorized($id){
        
        $req = $this->find('first', array(
            "conditions" => "id = $id",
            "fields" => "id, user_id, published",
            "contain" => array()
        ));
        return $req;  
    }
    
    public function beforeSave($options = array()) {
        
        if($this->id){  
            $this->OldTheme = $this->field('theme_id');
            $this->Theme->id = $this->OldTheme;
            $this->OldCountTheme = $this->Theme->field('count_quiz');
            
            $this->OldMatiere = $this->Theme->field('matiere_id');
            $this->Theme->Matiere->id = $this->OldMatiere;
            $this->OldCountMatiere = $this->Theme->Matiere->field('count_quiz');
        }
        
        return true;
    }
    
    public function afterSave($created) {
    
        $model = $this->name;
        $type = $this->useTable;

        if(isset($this->data[$model]['theme_id'])){
            $d = $this->data[$model]; 
            
            $matiereId = $d['matiere_id'];
            $themeId = $d['theme_id'];

            $isPublished = $this->isPublished($this->id);

            if($isPublished){
                $fieldToUpdate = "count_published_$type";
            }else{
                $fieldToUpdate = "count_$type";
            }

            $data = $this->Theme->find('first', array(
                "conditions" => "Theme.id = $themeId",
                "fields" => array("Theme.$fieldToUpdate"),
                "contain" => array(
                    "Matiere" => array(
                        "fields" => array("Matiere.$fieldToUpdate")
                    )
                )
            ));

            $oldCountTheme = $data['Theme'][$fieldToUpdate];
            $oldCountMatiere = $data['Matiere'][$fieldToUpdate];


            if(isset($this->OldTheme)){
                if($this->OldTheme != $themeId){
                    //On met à jour le nombre de quiz dans le thème
                    $this->Theme->id =  $themeId;
                    $newCountTheme = $oldCountTheme + 1;
                    $d['Theme'][$fieldToUpdate] = $oldCountTheme + 1;
                    $this->Theme->save($d);
                    
                    //Et ensuite on met à jour l'ancien thème en enlevant 1
                    if($this->OldCountTheme > 0){     
                        $this->Theme->id = $this->OldTheme;
                        $OldnewCountTheme = $this->OldCountTheme - 1;
                        $this->Theme->saveField($fieldToUpdate,$OldnewCountTheme);
                    }

                    //Si la matière est différente, on met à jour aussi
                    if($matiereId != $this->OldMatiere){
                        //On met à jour la nouvelle matière
                        //$this->Matiere->id = $matiereId;
                        $NewMatiere['Matiere']['id'] = $matiereId;
                        $NewMatiere['Matiere'][$fieldToUpdate] = $oldCountMatiere + 1;
                        //die(debug($matiere));
                        $this->Theme->Matiere->save($NewMatiere);
                        
                        //On met également à jour l'ancienne matière
                        //$this->Matiere->id = $this->OldMatiere;
                        $OldMatiere['Matiere']['id'] = $this->OldMatiere;
                        $OldMatiere['Matiere'][$fieldToUpdate] = $this->OldCountMatiere - 1;
                        $this->Theme->Matiere->save($OldMatiere);
                    }
                }
            }else{
                $this->Theme->id =  $themeId;
                $newCountTheme = $oldCountTheme + 1;
                $this->Theme->saveField($fieldToUpdate,$newCountTheme);
                
                $this->Theme->Matiere->id =  $matiereId;
                $NewCountMatiere = $oldCountMatiere +1;
                $this->Theme->Matiere->saveField($fieldToUpdate,$NewCountMatiere);
            }

        }
        
        return true;
    }
    
    public function updateCounter($ToPublish = false){
        
        $model = $this->name;
        $fieldToUpdate = "count_published_$this->table";
        
        $c = $this->find('first', array(
           "conditions" => "$model.id = $this->id",
            "fields" => "theme_id",
            "contain" => array()
        ));
        
        $themeId = $c[$model]['theme_id'];
        
        $this->Theme->id = $themeId;
        $OldCountTheme = $this->Theme->field($fieldToUpdate);
        $matiereId = $this->Theme->field('matiere_id');
        $OldCountMatiere = $this->Theme->Matiere->field($fieldToUpdate);
        
        if($ToPublish){
            $newCountTheme = $OldCountTheme + 1;
            $newCountMatiere = $OldCountMatiere + 1;
        }else{
            $newCountTheme = $OldCountTheme - 1;  
            $newCountMatiere = $OldCountMatiere - 1;
        }
        
        
        $this->Theme->saveField($fieldToUpdate,$newCountTheme);
        
        $matiere['Matiere'] = array("id" => $matiereId, $fieldToUpdate => $newCountMatiere);
        $this->Theme->Matiere->save($matiere);
                
        return true;
    }
    
    public function isPublished($itemId){
        $model = $this->name;
        $itemToEdit = $this->find('first', array(
            "fields" => "$model.published, $model.validation",
            "conditions" => "$model.id = $itemId",
            "contain" => array()
        ));
        
        if($itemToEdit[$model]['published'] == 1 OR $itemToEdit[$model]['validation'] == 1){            
            return true;
        }
        
        return false;
    }       
}