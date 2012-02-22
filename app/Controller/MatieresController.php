<?php
App::uses('AppController', 'Controller');
/**
 * Matieres Controller
 *
 * @property Matiere $Matiere
 */
class MatieresController extends AppController {


/**
 * index method
 *
 * @return void
 */
	public function index() {
		$matieres = $this->Matiere->find('all', array(
                    "fields" => "Matiere.name, Matiere.id, Matiere.slug, Matiere.count_published_cours, Matiere.count_published_quiz",
                    "conditions" => "Matiere.published = 1 AND (Matiere.count_published_cours > 0 OR Matiere.count_published_quiz > 0)",
                    "contain" => array()
                ));
		$this->set(compact('matieres'));
	}

/**
 * view method
 *
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		$this->Matiere->id = $id;
		if (!$this->Matiere->exists()) {
			throw new NotFoundException(__('Invalid matiere'));
		}
		$this->set('matiere', $this->Matiere->read(null, $id));
	}

        public function tag($tagId) {
            $matieres = $this->Matiere->CourTag->find('all', array(
                "conditions" => "CourTag.tag_id = $tagId",
                "fields" => "CourTag.id",
                "contain" => array(
                    "Matiere" => array(
                        "fields" => "Matiere.name, Matiere.id, Matiere.slug"
                    ),
                    "Tag" => array(
                        "fields" => "Tag.slug"
                    )
                )
            ));

            $tag = $this->Matiere->CourTag->Tag->find('first', array(
                "conditions" => "Tag.id = $tagId",
                "fields" => "Tag.id, Tag.name, Tag.slug",
                "contain" => array()
            ));
            $this->set(compact('matieres', 'tag'));
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
