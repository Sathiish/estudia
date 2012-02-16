<?php
App::uses('AppController', 'Controller');
/**
 * Matieres Controller
 *
 * @property Matiere $Matiere
 */
class ThemesController extends AppController {

/**
 * view method
 *
 * @param string $id
 * @return void
 */
	public function view($MatiereId = null) {
		$themes = $this->Theme->find('all', array(
                    "conditions" => "Theme.matiere_id = $MatiereId",
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
                        "fields" => array("Theme.name, Theme.id, Theme.slug, Theme.count_cours")
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
        public function selectbox($matiereId = null){
            $this->layout = null;

            if(!$matiereId){
                $themes = array();              
            }else{
                $themes = $this->Theme->find('list', array(
                    "fields" => "id, name",
                    "conditions" => "Theme.matiere_id = $matiereId"
                ));
            }
            $this->set(compact('themes'));            
        }
        
/**
 * admin_index method
 *
 * @return void
 */
	public function admin_index() {
		$this->Matiere->recursive = 0;
		$this->set('matieres', $this->paginate());
	}

/**
 * admin_view method
 *
 * @param string $id
 * @return void
 */
	public function admin_view($id = null) {
		$this->Matiere->id = $id;
		if (!$this->Matiere->exists()) {
			throw new NotFoundException(__('Invalid matiere'));
		}
		$this->set('matiere', $this->Matiere->read(null, $id));
	}

/**
 * admin_add method
 *
 * @return void
 */
	public function admin_add() {
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
 * admin_edit method
 *
 * @param string $id
 * @return void
 */
	public function admin_edit($id = null) {
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
 * admin_delete method
 *
 * @param string $id
 * @return void
 */
	public function admin_delete($id = null) {
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
}
