<?php
App::uses('AppController', 'Controller');
/**
 * Ressources Controller
 *
 * @property Ressource $Ressource
 */
class TagsController extends AppController {
    
    public function index(){
        $tags = $this->Tag->find('all', array(
            "fields" => "Tag.id, Tag.name, Tag.slug, Tag.count_cours",
            "contain" => array()
        ));
        
        $this->set(compact('tags'));
    }
    
    /*
     * Seul l'administrateur peut ajouter des niveaux
     */
    public function admin_add(){
        
    }
    
}