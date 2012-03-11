<?php
App::uses('AppController', 'Controller');
/**
 * Matieres Controller
 *
 * @property Matiere $Matiere
 */
class ThemesController extends AppController {
        
        public function beforeFilter() {
            parent::beforeFilter();
            $this->Auth->allow('view', 'tag');
        }
        
/**
 * view method
 *
 * @param string $id
 * @return void
 */
	public function view($MatiereId = null) {
		$themes = $this->Theme->find('all', array(
                    "conditions" => "Theme.matiere_id = $MatiereId AND Theme.count_published_cours > 0",
                    "fields" => "Theme.name, Theme.slug, Theme.id"
                ));

		$this->set(compact('themes'));
	}
        
        public function tag($tagId, $matiereId){
            $themes = $this->Theme->CourTag->find('all', array(
                "conditions" => "CourTag.tag_id = $tagId AND CourTag.matiere_id = $matiereId",
                "fields" => "CourTag.id, CourTag.tag_id",
                "contain" => array(
                    "Tag" => array(
                        "fields" => array("Tag.id, Tag.name, Tag.slug")
                    ),
                    "Theme" => array(
                        "fields" => array("Theme.name, Theme.id, Theme.slug, Theme.count_published_cours")
                    )
                )
            ));
            
            $matiere = $this->Theme->Matiere->find('first', array(
                "conditions" => "Matiere.id = $matiereId",
                "fields" => "Matiere.id, Matiere.name, Matiere.slug",
                "contain" => array()
            ));
            
            $tag = $themes['0']['Tag'];

            $this->set(compact('themes', 'matiere', 'tag'));
        }

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Matiere->create();
			if ($this->Matiere->save($this->request->data)) {
				$this->Session->setFlash(__('The matiere has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The matiere could not be saved. Please, try again.'));
			}
		}
	}

/**
 * edit method
 *
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		$this->Matiere->id = $id;
		if (!$this->Matiere->exists()) {
			throw new NotFoundException(__('Invalid matiere'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Matiere->save($this->request->data)) {
				$this->Session->setFlash(__('The matiere has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The matiere could not be saved. Please, try again.'));
			}
		} else {
			$this->request->data = $this->Matiere->read(null, $id);
		}
	}

/**
 * delete method
 *
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		if (!$this->request->is('post')) {
			throw new MethodNotAllowedException();
		}
		$this->Matiere->id = $id;
		if (!$this->Matiere->exists()) {
			throw new NotFoundException(__('Invalid matiere'));
		}
		if ($this->Matiere->delete()) {
			$this->Session->setFlash(__('Matiere deleted'));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('Matiere was not deleted'));
		$this->redirect(array('action' => 'index'));
	}

/*
 * Permet de récupérer la liste des thèmes pour une matière donnée
 */
        public function selectbox($classeId, $matiereId = null, $withNew = null){
            $this->layout = null;

            if(!$matiereId){
                $themes = array();              
            }else{
                $themes = $this->Theme->find('list', array(
                    "fields" => "id, name",
                    "conditions" => "Theme.matiere_id = $matiereId AND Theme.classe_id = $classeId"
                ));
            }
            $this->set(compact('themes')); 
            if(isset($withNew) && $withNew == "recherche"){
                $this->render('recherche');
            }
                       
        }
        
/**
 * admin_index method
 *
 * @return void
 */
	public function admin_index($matiereId = null, $classeId = null) {
            $this->_isAdmin();
            
            if($this->request->is('post')){
                $matiereId = $this->data['Theme']['matiere_id'];
                $classeId = $this->data['Theme']['classe_id'];
                
                $condition = "Theme.matiere_id = $matiereId AND Theme.classe_id = $classeId";
            }else{
                if($matiereId == null){
                $condition = "1 = 1";
                }else{
                    $condition = "Theme.matiere_id = $matiereId";
                }
            }
            
            $themes = $this->Theme->find('all', array(
                'conditions' => $condition,
                'fields' => array('Theme.id, Theme.name, Theme.slug, Theme.classe_id'),
                'order' => array('Theme.classe_id', 'Theme.matiere_id'),
                'contain' => array()
            ));

            $classes = $this->Theme->Classe->find('list', array('contain' => array()));
            $matieres = $this->Theme->Matiere->getAllMatieres();
            $this->set(compact('themes', 'matieres', 'classes'));
	}

/**
 * admin_view method
 *
 * @param string $id
 * @return void
 */
	public function admin_view($id = null) {
            $this->_isAdmin();
            
		$this->Theme->id = $id;
		if (!$this->Theme->exists()) {
			throw new NotFoundException(__('Invalid matiere'));
		}
		$this->set('themes', $this->Theme->read(null, $id));
	}

/**
 * admin_add method
 *
 * @return void
 */
	public function admin_add() {
            $this->_isAdmin();
            
            if ($this->request->is('post') || $this->request->is('put')) {
                    $this->Theme->create();
                    if ($this->Theme->save($this->request->data)) {
                            $this->Session->setFlash('Le thème a été crée', 'notif');
                            $this->redirect(array('action' => 'index'));
                    } else {
                            $this->Session->setFlash('Le thème n\'a pas été crée', 'notif', array('type' => 'error'));
                    }
            }
            
            $classes = $this->Theme->Classe->find('list', array('contain' => array()));
            $matieres = $this->Theme->Matiere->getAllMatieres() + array("" => "Autre");
            $this->set(compact('matieres', 'classes'));
	}

/**
 * admin_edit method
 *
 * @param string $id
 * @return void
 */
	public function admin_edit($id = null) {
            $this->_isAdmin();
            
		$this->Theme->id = $id;
		if (!$this->Theme->exists()) {
			throw new NotFoundException('Thème non trouvé', 'notif', array('type' => 'error'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Theme->save($this->request->data)) {
				$this->Session->setFlash('Thème mis à jour', 'notif');
				$this->redirect($this->referer());
			} else {
				$this->Session->setFlash('Thème non modifié', 'notif', array('type' => 'error'));
			}
		} else {
                    $classes = $this->Theme->Classe->find('list', array('contain' => array()));
                    $matieres = $this->Theme->Matiere->getAllMatieres() + array("" => "Autre");
                    $this->request->data = $this->Theme->read(null, $id);
                    $this->set(compact('matieres', 'classes'));			
		}
	}

/**
 * admin_delete method
 *
 * @param string $id
 * @return void
 */
	public function admin_delete($id = null) {
            $this->_isAdmin();

		$this->Theme->id = $id;
		if (!$this->Theme->exists()) {
			throw new NotFoundException('Thème non trouvé', 'notif', array('type' => 'error'));
		}
		if ($this->Theme->delete()) {
			$this->Session->setFlash('Theme supprimé', 'notif');
			$this->redirect($this->referer());
		}
		$this->Session->setFlash('Le thème n\'a pas été supprimé', 'notif', array('type' => 'error'));
		$this->redirect($this->referer());
	}
}
