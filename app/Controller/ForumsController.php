<?php
App::uses('AppController', 'Controller');
/**
 * Forums Controller
 *
 * @property Forum $Forum
 */
class ForumsController extends AppController {
    
    function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow('index', 'topic', 'post');
    }
    

    /**
     * Voir tous les forums
     *
     * @return void
     */
    public function index($category_id) {
        //$this->layout = "vierge";

        $CategoryActive = $this->Forum->Category->find('first', array(
            "conditions" => "Category.id = $category_id",
            "fields" => "id, name",
            "recursive" => -1
         ));
        
        $forums = $this->Forum->find('all', array(
            "conditions" => "Forum.category_id = $category_id",
            "fields" => "",
            "recursive" => 1
        ));

        $this->set(compact('forums', 'CategoryActive'));
   }
    
    /**
     * Ajouter un forum
     *
     * @return void
     */
    public function admin_add($id) {
        $this->_isAdmin();
        $this->layout = "modal";
        
           if($this->request->is('post'))
		{
                        $this->Forum->set($this->data);                        
			if($this->Forum->save()){
                            $this->Session->setFlash("Forum enregistré");
                            $this->redirect($this->referer());
                        }else
			{
                            $this->Session->setFlash("Corrigez les erreurs mentionnées.");
			}
		}
                    
                $this->set('title_for_layout', "Créer/Modifier un forum");

   }

   /**
     * Editer un forum
     *
     * @return void
     */
    public function admin_edit($id = null) {
        $this->_isAdmin();
        $this->layout = "modal";
        
           if($this->request->is('post'))
		{
                        $this->Forum->set($this->data);                        
			if($this->Forum->save()){
                            $this->Session->setFlash("Forum enregistré");
                            $this->redirect($this->referer());
                        }else
			{
                            $this->Session->setFlash("Corrigez les erreurs mentionnées.");
			}
		}
                
                if($id != null){                
                    $this->data = $this->Forum->find('first', array(
                        "conditions" => "Forum.id = $id",
                        "fields" => "Forum.id, Forum.name, Forum.description, Forum.user_id",
                        "recursive" => -1
                    ));

                }
                    
                $this->set('title_for_layout', "Créer/Modifier un forum");

   }

    
    /**
     * Suppression d'un Forum
     *
     * @param int $id Id du Forum
     */
    function admin_delete($id = null){
        $this->_isAdmin();
        $this->Forum->id = $id;

        if(!$this->Forum->exists())
        {
                $this->Session->setFlash("Forum introuvable");
        }
        else
        {
                $this->Forum->delete($id);
                $this->Session->setFlash("Ce forum a bien été supprimé");
        }

        $this->redirect($this->referer());
    }

    /**
     * Administrer tous les forums
     *
     * @return void
     */
    public function admin_index($id) {
        $this->_isAdmin();
        
        $forums = $this->Forum->find('list', array(
            "conditions" => "Forum.category_id = $id",
            "fields" => "Forum.id, Forum.name",
            "recursive" => -1
        ));

        $this->set(compact('forums'));
   }

}