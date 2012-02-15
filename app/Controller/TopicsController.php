<?php
App::uses('AppController', 'Controller');
/**
 * Forums Controller
 *
 * @property Forum $Forum
 */
class TopicsController extends AppController {
    
    public $helpers = array('Date');

    /**
     * Voir tous les forums
     *
     * @return void
     */
    
    function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow('index');
    }
    
    public function index($forum_id) {
        $this->layout = "vierge";

        $ForumActive = $this->Topic->getActive($forum_id);
        
        $topics = $this->Topic->find('all', array(
            "conditions" => "Topic.forum_id = $forum_id",
            "fields" => "Topic.id, Topic.name, Topic.slug, Topic.content, Topic.created, Topic.modified, 
                        Topic.nombre_reponse,Topic.username_last_post, Topic.nombre_vue, User.id, User.username",
            "recursive" => 0
        ));
        
        if(empty($topics)){
            $this->Session->setFlash("Soyez le premier à créer une discussion sur ce thème");
            //$this->redirect($this->referer());
        }else{
            $this->set(compact('topics', 'ForumActive'));
        }
   }
   
    /**
     * Administrer tous les forums
     *
     * @return void
     */
    public function admin_index($id) {

        $topics = $this->Topic->find('list', array(
            "conditions" => "Topic.forum_id = $id",
            "fields" => "Topic.id, Topic.name",
            "recursive" => -1
        ));
        
        $ForumActive = $this->Topic->getActive($id);
        
        $this->set(compact('topics', 'ForumActive'));
   }

    /**
     * Administrer tous les topics
     *
     * @return void
     */
    public function add($forum_id) {

        $this->layout = "modal";
        
           if($this->request->is('post'))
		{
                    $this->Topic->set($this->data);                        
                    if($this->Topic->save()){
                        $this->Topic->Forum->increment("nombre_topic", $this->data['Topic']['forum_id']);
                        $this->Topic->Forum->LastTopic($this->data['Topic']['forum_id'], $this->data['Topic']['name'], $this->Topic->id);
                        $this->Session->setFlash("Discussion créée");
                        $this->redirect($this->referer());
                    }else
                    {
                        $this->Session->setFlash("Corrigez les erreurs mentionnées.");
                    }
		}
            $ForumActive = $this->Topic->getActive($forum_id);         
            
            $this->set('title_for_layout', "Créer une discussion");
            $this->set(compact('forum_id','ForumActive'));
   }
   

   /**
     * Administrer tous les topics
     *
     * @return void
     */
    public function admin_edit($id = null) {

        $this->layout = "modal";
        
           if($this->request->is('post'))
		{
                    $this->Topic->set($this->data);                        
                    if($this->Topic->save()){
                        $this->Session->setFlash("Topic enregistré");
                        $this->redirect($this->referer());
                    }else
                    {
                        $this->Session->setFlash("Corrigez les erreurs mentionnées.");
                    }
		}
                
                if($id != null){                
                    $this->data = $this->Topic->find('first', array(
                        "conditions" => "Topic.id = $id",
                        "fields" => "Topic.id, Topic.name, Topic.content, Topic.forum_id, Topic.user_id",
                        "recursive" => -1
                    ));
                }
                    
                $this->set('title_for_layout', "Créer/Modifier un topic");
   }
   
    /**
     * Suppression d'un topic
     *
     * @param int $id Id du topic
     */
    function admin_delete($id = null)
    {
        $this->Topic->id = $id;

        if(!$this->Topic->exists())
        {
                $this->Session->setFlash("Forum introuvable");
        }
        else
        {
                $forum = $this->Topic->find('first', array(
                    "conditions" => "Topic.id = $id",
                    "fields" => "Topic.id, Topic.forum_id"
                ));               
                $this->Topic->Forum->decrement("nombre_topic", $forum['Topic']['forum_id']);
                $this->Topic->Forum->LastTopic($forum['Topic']['forum_id'],"", "");
                $this->Topic->delete($forum['Topic']['id']);
                $this->Session->setFlash("Ce topic a bien été supprimé");
        }

        $this->redirect($this->referer());
    }
}