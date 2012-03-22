<?php
App::uses('AppController', 'Controller');
/**
 * Ressources Controller
 *
 * @property Ressource $Ressource
 */
class ClassesRessourcesController extends AppController {
      
    public function delete($id){
    
        $this->CourTag->delete($id, false);
    }
    
    public function addtag($classeId, $ressourceId){
        
        $this->layout = null;

        $d['ClassesRessource']['ressource_id'] = $ressourceId;
        $d['ClassesRessource']['classe_id'] = $classeId;

        $exist = $this->ClassesRessource->find('first', array(
           "conditions" => "ClassesRessource.classe_id = $classeId AND ClassesRessource.ressource_id = $ressourceId",
            "fields" => "ClassesRessource.id"
        ));
        if(!$exist){
            $this->ClassesRessource->save($d);
        }else{
            $error = "Cette ressource est déjà classée dans cette matière. Vous pouvez également le classer dans une autre matière";
            $this->set(compact('error'));
        }      
//        $relatedTags = $this->RessourceClasse->Tag->findRelated('Ressource', $ressourceId);
//        $model = $this->modelClass;
//        $this->set(compact('relatedTags', 'model'));
        $this->render('/common/tag');
    }
}