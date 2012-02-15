<?php
App::uses('AppController', 'Controller');
/**
 * Ressources Controller
 *
 * @property Ressource $Ressource
 */
class CourTagsController extends AppController {
    
    public function view($tagId){
        $tags = $this->CourTag->find('all', array(
            "conditions" => "CourTag.tag_id = $tagId",
            "contain" => array(
                "Cour" => array(
                    "fields" => array("Cour.id, Cour.name, Cour.slug, Cour.theme_id"),
                    "Theme" => array(
                        "fields" => array("Theme.id, Theme.name, Theme.slug"),
                        "Matiere" => array(
                            "fields" => array("Matiere.id, Matiere.slug, Matiere.name")
                        )
                    )
                )
            )
        ));
        
        $this->set(compact('tags'));
    }
    
    public function matiere($tagId){
        $m = $this->CourTag->find('all', array(
            "conditions" => "CourTag.tag_id = $tagId",
            "contain" => array(
                "Cour" => array(
                    "fields" => array("Cour.id"),
                    "Theme" => array(
                        "fields" => array("Theme.id"),
                        "Matiere" => array(
                            "fields" => array("Matiere.slug, Matiere.name")
                        )
                    )
                )
            )
        ));
        
        $matieres = array();
        foreach($m as $matiere): $matiere = $matiere['Cour']['Theme']['Matiere'];
           $id = $matiere['slug'];
           $matieres[$id] = $matiere['name'];
        endforeach;

        $this->set(compact('matieres', 'tagId'));
    }
    
    public function cours($slug, $tagId){
        $this->loadModel('Matiere');
        
        $slug = "'".$slug."'";
        $m = $this->Matiere->find('first', array(
            "fields" => "Matiere.id",
            "conditions" => "Matiere.slug = $slug",
            "contain" => array()
        ));
        
        $matiereId = $m['Matiere']['id'];
                
        $cc = $this->CourTag->Cour->Theme->find('all', array(
            "fields" => array("Theme.id, Theme.name, Theme.slug, Theme.matiere_id"),
            "conditions" => "Theme.matiere_id = $matiereId",
            "contain" => array(
                "Cour" => array(
                    "fields" => array("Cour.id, Cour.name, Cour.slug, Cour.theme_id"),
                    "CourTag" => array(
                        "conditions" => "CourTag.tag_id = $tagId"
                    )
                ),
                "Matiere" => array(
                    "fields" => array("Matiere.id, Matiere.name, Matiere.slug")
                )
            )
        ));
        
        $c = array(); $i = 0;
        foreach($cc as $cours){
//            $c = current($cc);
            if(!empty($cours['Theme']['id'])){
                $c[$i] = $cours; $i++;
            }
        }
        
//        debug($c); die();
        $this->set(compact('c'));
    }
    
    public function delete($id){
    
        $this->CourTag->delete($id, false);
//        $this->layout = null;
//        
//        if ($this->CourTag->delete($toDelete, false)) {
//            //$this->Session->setFlash("Tag supprimé", 'notif');
//            $relatedTags = $this->CourTag->Tag->findRelated('Cour', $toRedirect);
//                $this->set(compact('relatedTags'));
//                $this->render('/common/tag');     
//        } else {
//            $this->Session->setFlash("Un problème est survenu. Veuillez réessayer. Si le problème persiste, vous pouvez contacter l'administrateur du site à contact@zeschool.com", 'notif', array('type' => 'error'));
//        }

        //$this->redirect($this->referer());
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
            $this->set(compact('relatedTags'));
            $this->render('/common/tag');
    }
}