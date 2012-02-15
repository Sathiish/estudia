<?php
App::uses('AppController', 'Controller');
/**
 * Forums Controller
 *
 * @property Forum $Forum
 */
class PostsController extends AppController {
    
    function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow('index');
    }
    
    /**
     * Voir tous les forums
     *
     * @return void
     */
    public function index($topic_id) {
        
        $this->layout = "vierge";

        $TopicActive = $this->Post->getActive($topic_id);
        $this->Post->Topic->increment("nombre_vue", $topic_id);
                
        $posts = $this->Post->find('all', array(
            "conditions" => "Post.topic_id = $topic_id",
            "fields" => "Post.id, Post.content, Post.created, User.id, User.username",
            "recursive" => 0
        ));
        
        if(empty($TopicActive)){
            $this->Session->setFlash("Cette discussion n'existe pas");
            $this->redirect($this->referer());
        }else{
            $this->set(compact('posts', 'TopicActive'));            
        }
        
   }
   
    /**
     * Administrer tous les forums
     *
     * @return void
     */
    public function admin_index($topic_id) {

        $posts = $this->Post->find('all', array(
            "fields" => "Post.id, Post.content, User.username",
            "conditions" => "topic_id = $topic_id",
            "recursive" => 0
        ));

        $this->set(compact('posts', 'topic_id'));
   }

    /**
     * Poster une réponse
     *
     * @return void
     */
    public function add($topic_id) {

        $this->layout = "modal";
        
           if($this->request->is('post'))
		{
                    $this->Post->set($this->data);                        
                    if($this->Post->save()){
                        $this->Post->Topic->increment("nombre_reponse", $this->data['Post']['topic_id']);
                        $this->Post->Topic->LastPost($this->Auth->user('username'), $this->data['Post']['topic_id']);
                        $this->Session->setFlash("Réponse enregistrée");
                        $this->redirect($this->referer());
                    }else{
                        $this->Session->setFlash("Corrigez les erreurs mentionnées.");
                    }
		}
         $TopicActive = $this->Post->getActive($topic_id);         
         
         $this->set('title_for_layout', "Répondre");
         $this->set(compact('topic_id', 'TopicActive'));
   }
   
    /**
     * Administrer tous les topics
     *
     * @return void
     */
    public function admin_add($topic_id) {

        $this->layout = "modal";
        
           if($this->request->is('post'))
		{
                    $this->Post->set($this->data);                        
                    if($this->Post->save()){
                        $this->Session->setFlash("Topic enregistré");
                        $this->redirect($this->referer());
                    }else
                    {
                        $this->Session->setFlash("Corrigez les erreurs mentionnées.");
                    }
		}
       $TopicActive = $this->Post->getActive($topic_id);             
       
       $this->set('title_for_layout', "Créer/Modifier un topic");
       $this->set(compact('topic_id','TopicActive'));
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
                    $this->Post->set($this->data);                        
                    if($this->Post->save()){
                        $this->Session->setFlash("Topic enregistré");
                        $this->redirect($this->referer());
                    }else
                    {
                        $this->Session->setFlash("Corrigez les erreurs mentionnées.");
                    }
		}
                
                if($id != null){                
                    $this->data = $this->Post->find('first', array(
                        "conditions" => "Post.id = $id",
                        "fields" => "Post.id, Post.content, Post.topic_id, Post.user_id",
                        "recursive" => -1
                    ));
                }
                    
                $this->set('title_for_layout', "Modifier un post");
   }
   
    /**
     * Suppression d'un topic
     *
     * @param int $id Id du topic
     */
    function admin_delete($id = null)
    {
        $this->Post->id = $id;

        if(!$this->Post->exists())
        {
                $this->Session->setFlash("Post introuvable");
        }
        else
        {
                $this->Post->delete($id);
                $this->Session->setFlash("Ce post a bien été supprimé");
        }

        $this->redirect($this->referer());
    }
}