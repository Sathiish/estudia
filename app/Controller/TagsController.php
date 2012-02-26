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
            "fields" => "Tag.id, Tag.name, Tag.slug, Tag.count_published_cours, Tag.count_published_quiz",
            "contain" => array()
        ));
        
        $this->set(compact('tags'));
    }
    
    public function theme($type, $matiereId){
        
        $this->loadModel('Theme');
        $themes = $this->Theme->find('all', array(
            "conditions" => "Theme.matiere_id = $matiereId AND Theme.count_published_$type > 0",
            "contain" => array()
        ));
        //die(debug($themes));
        
        $this->set(compact('themes'));
    }
    
    /*
     * Seul l'administrateur peut ajouter des niveaux
     */
    public function admin_add(){
        
    }
        
    public function nettoyer(){
        
        //On met à jour le nombre de cours publié par tag
        $listCour = $this->Tag->CourTag->find('list', array("fields" => "CourTag.id, CourTag.tag_id"));

        foreach($listCour as $k=>$v){
            $countCour = $this->Tag->CourTag->find('count', array('conditions' => array("CourTag.tag_id = $v")));

            $this->Tag->id = $v;
            $d['Tag']['count_cours'] = $countCour;
            $this->Tag->save($d, array('validate' => false,'fieldList' => array(),'callbacks' => false));     
        }
        
        //On fait la même chose pour le nombre de quiz publié par tag
        $listQuiz = $this->Tag->QuizTag->find('list', array("fields" => "QuizTag.id, QuizTag.tag_id"));

        foreach($listQuiz as $k=>$v){
            $countQuiz = $this->Tag->QuizTag->find('count', array('conditions' => array("QuizTag.tag_id = $v")));

            $this->Tag->id = $v;
            $d['Tag']['count_quiz'] = $countQuiz;
            $this->Tag->save($d, array('validate' => false,'fieldList' => array(),'callbacks' => false));     
        }
        
        die("Terminée");
    }
    
}