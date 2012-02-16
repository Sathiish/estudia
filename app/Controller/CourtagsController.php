<?php
App::uses('AppController', 'Controller');
/**
 * Ressources Controller
 *
 * @property Ressource $Ressource
 */
class CourTagsController extends AppController {
      
    public function delete($id){
    
        $this->CourTag->delete($id, false);
    }
    
    public function addtag($tagId, $coursId){
        
        $this->layout = null;

        $d['CourTag']['cour_id'] = $coursId;
        $d['CourTag']['tag_id'] = $tagId;

        $exist = $this->CourTag->find('first', array(
           "conditions" => "CourTag.tag_id = $tagId AND CourTag.cour_id = $coursId",
            "fields" => "CourTag.id"
        ));
        if(!$exist){
            $this->CourTag->save($d);
        }else{
            $error = "Ce cours est déjà classé dans cette matière. Vous pouvez également le classer dans une autre matière";
            $this->set(compact('error'));
        }      
        $relatedTags = $this->CourTag->Tag->findRelated('Cour', $coursId);
        $model = $this->modelClass;
        $this->set(compact('relatedTags', 'model'));
        $this->render('/common/tag');
    }
}