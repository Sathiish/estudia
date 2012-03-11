<?php
App::uses('AppController', 'Controller');
/**
 * Forums Controller
 *
 * @property Forum $Forum
 */
class CategoriesController extends AppController {
    
    var $helpers = array ('Date');
    
    function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow('index');
    }
    
    
    public function index(){
       //$this->layout = "vierge";
       
       $categories = $this->Category->find('all', array(
            "fields" => "Category.id, Category.name",
            "recursive" => 1
        ));

        $this->set(compact('categories'));
    }

    /**
     * Voir tous les forums
     *
     * @return void
     */
    public function admin_index() {
        $this->_isAdmin();

        $categories = $this->Category->find('list', array(
            "fields" => "Category.id, Category.name",
            "recursive" => -1
        ));

        $this->set(compact('categories'));
   }
    

    /**
     * Ajouter un forum
     *
     * @return void
     */
    public function admin_add($id = null) {
        $this->_isAdmin();
        $this->layout = "modal";
        
           if($this->request->is('post'))
		{
                        $this->Category->set($this->data);                        
			if($this->Category->save()){
                            $this->Session->setFlash("Category enregistrée");
                            $this->redirect($this->referer());
                        }else
			{
                            $this->Session->setFlash("Corrigez les erreurs mentionnées.");
			}
		}
                
                if($id != null){                
                    $this->data = $this->Category->find('first', array(
                        "conditions" => "Category.id = $id",
                        "fields" => "Category.id, Category.name",
                        "recursive" => -1
                    ));

                }
                    
                $this->set('title_for_layout', "Créer/Modifier une categorie");

   }
    
    /**
     * Suppression d'une catégorie
     *
     * @param int $id Id de la catégorie
     */
    function admin_delete($id = null){
        $this->_isAdmin();
        
        $this->Category->id = $id;

        if(!$this->Category->exists())
        {
                $this->Session->setFlash("Catégorie introuvable.");
        }
        else
        {
                $this->Category->delete($id);
                $this->Session->setFlash("La catégorie a bien été supprimée.");
        }

        $this->redirect($this->referer());
    }


}