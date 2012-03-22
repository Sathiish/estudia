<?php
App::uses('AppController', 'Controller');
/**
 * Cours Controller
 *
 */
class RessourcesAppController extends AppController {
              
        function beforeFilter() {
            parent::beforeFilter();
            $this->Auth->allow('*');
        }
                
        //public $helpers = array('Autocomplete', 'Tinymce');
        
 
        public function listNiveau(){
            $this->loadModel('Niveau');
            $this->set('d', $this->Niveau->find('list'));
            $this->render('selectbox');
            
        }
        
        public function listClasse($niveauId){
            $this->loadModel('Classe');
            $this->set('d', $this->Classe->getListClasse($niveauId));
            $this->render('selectbox');
        }
        
        public function listMatiere($classeId){
            $this->loadModel('Matiere');
            $this->set('d', $this->Matiere->getAllMatieres($classeId));
            $this->render('selectbox');
        }
        
        public function listTheme($matiereId){
            $this->loadModel('Theme');
            $this->set('d', $this->Theme->getAllThemes($matiereId));
            $this->render('selectbox');
        }

}