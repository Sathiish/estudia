<?php
App::uses('AppController', 'Controller');
/**
 * Ressources Controller
 *
 * @property Ressource $Ressource
 */
class ClassesController extends AppController {
    
    public function index(){
        $tags = $this->Classe->find('all', array(
            "fields" => "Classe.id, Classe.name, Classe.slug, Classe.count_published_cours, Classe.count_published_quiz",
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
    


        
    public function nettoyer(){
        
        //On met à jour le nombre de cours publié par tag
        $listCour = $this->Classe->CourClasse->find('list', array("fields" => "CourClasse.id, CourClasse.tag_id"));

        foreach($listCour as $k=>$v){
            $countCour = $this->Classe->CourClasse->find('count', array('conditions' => array("CourClasse.tag_id = $v")));

            $this->Classe->id = $v;
            $d['Classe']['count_cours'] = $countCour;
            $this->Classe->save($d, array('validate' => false,'fieldList' => array(),'callbacks' => false));     
        }
        
        //On fait la même chose pour le nombre de quiz publié par tag
        $listQuiz = $this->Classe->QuizClasse->find('list', array("fields" => "QuizClasse.id, QuizClasse.tag_id"));

        foreach($listQuiz as $k=>$v){
            $countQuiz = $this->Classe->QuizClasse->find('count', array('conditions' => array("QuizClasse.tag_id = $v")));

            $this->Classe->id = $v;
            $d['Classe']['count_quiz'] = $countQuiz;
            $this->Classe->save($d, array('validate' => false,'fieldList' => array(),'callbacks' => false));     
        }
        
        die("Terminée");
    }
    
    public function admin_index() {
        $this->_isAdmin();
        //$this->Classe->recursive = 0;
        $this->set('classes', $this->paginate());
    }
    
    /*
     * Seul l'administrateur peut ajouter des niveaux
     */
    public function admin_add() {
        $this->_isAdmin();
            if ($this->request->is('post')) {
                    $this->Classe->create();
                    if ($this->Classe->save($this->request->data)) {
                            $this->Session->setFlash('La classe a bien été créée', 'notif');
                            $this->redirect(array('action' => 'index'));
                    } else {
                            $this->Session->setFlash('La classe n\'a pas été créée', 'notif', array('type' => 'error'));
                    }
            }
    }
    
    public function admin_edit($id = null) {
        $this->_isAdmin();
            $this->Classe->id = $id;
            if (!$this->Classe->exists()) {
                    throw new NotFoundException(__('Invalid matiere'));
            }
            if ($this->request->is('post') || $this->request->is('put')) {
                    if ($this->Classe->save($this->request->data)) {
                            $this->Session->setFlash(__('The matiere has been saved'));
                            $this->redirect(array('action' => 'index'));
                    } else {
                            $this->Session->setFlash(__('The matiere could not be saved. Please, try again.'));
                    }
            } else {
                    $this->request->data = $this->Classe->read(null, $id);
            }
    }
    
    public function admin_delete($id = null) {
        $this->_isAdmin();
            
            $this->Classe->id = $id;
            if (!$this->Classe->exists()) {
                    throw new NotFoundException('Classe non trouvé', 'notif', array('type' => 'error'));
            }
            if ($this->Classe->delete()) {
                    $this->Session->setFlash('Classe supprimée', 'notif');
                    $this->redirect(array('action'=>'index'));
            }
            $this->Session->setFlash('Classe non supprimée', 'notif', array('type' => 'error'));
            $this->redirect(array('action' => 'index'));
    }
    
}