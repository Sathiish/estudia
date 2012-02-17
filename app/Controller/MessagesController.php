<?php

class MessagesController extends AppController{
    
    public $helpers = array('Autocomplete');
    
    /*
     * Boîte de réception: Permet d'afficher tous les messages reçus et non supprimés (delete != 2) par l'utilisateur
     */
    public function index(){
        $id = $this->Auth->user('id');
        $messages = $this->Message->find('all', array(
            "conditions" => array(
                "Message.destinataire" => $id,
                "Message.delete <=" => "2"
            ),
            "fields" => "Message.id, Message.expediteur, Message.sujet, Message.slug, Message.message, Message.conversation_id,Message.created, Message.lu,Message.delete,UserExpediteur.id,UserExpediteur.username, UserExpediteur.avatar,UserDestinataire.username",
            "order" => "Message.created DESC"
        ));
        
	$this->set('messages', $messages);
    }
 
    /*
     * Messages envoyés: Permet d'afficher tous les messages envoyés par l'utilisateur
     */
    public function sent(){
        $id = $this->Auth->user('id');
        $messages = $this->Message->find('all', array(
            "conditions" => "Message.expediteur = $id AND Message.delete != 2",
            "fields" => "Message.id, Message.expediteur, Message.sujet, Message.slug, Message.message, Message.conversation_id,Message.created, UserExpediteur.id,UserExpediteur.username, UserDestinataire.id,UserDestinataire.avatar,UserDestinataire.username",
            "order" => "Message.created DESC"
        ));
        
	$this->set('messages', $messages);
    }
    
     /*
      * Permet d'afficher un message sélectionné
      * 
      * param $id int: id du message à afficher
      */
    public function voir($id){
        $user_id = $this->Auth->user('id');
        
        //On récupère le message passé en paramètre
        $message = $this->Message->read(null, $id);
        $destinataire = $message['Message']['destinataire'];
        $expediteur = $message['Message']['expediteur'];
        
        if($user_id == $destinataire OR $user_id == $expediteur){
            //On marque le message comme lu (lu = 1) si ce n'est pas déjà le cas
            if($message['Message']['lu'] == '1'){
                $this->Message->id = $id;
                $this->Message->saveField('lu', 2, array('callbacks' => false));
            }
            $this->set('message', $message);
        }else{
            $this->Session->setFlash('Ce message ne vous est pas destiné. Vous ne pouvez donc pas le lire.');
            $this->redirect(array('action' => 'index'));
        }
        
        /*
         * On récupère le fil de la conversation également
         * On vérifie bien que l'utilisateur qui veut récupérer un message ne l'a pas supprimé
         */
        $conversation_id = $message['Message']['conversation_id'];
        if($destinataire == $user_id){
            $condition ="AND Message.delete <> 2";
        }elseif($expediteur == $user_id){
            $condition = "AND Message.delete <> 3";
        }

        $conversations = $this->Message->find('all', array(
            "conditions" => "conversation_id = $conversation_id AND Message.id < $id $condition ORDER BY Message.id DESC LIMIT 2",
            "fields" => "Message.id, Message.expediteur, Message.sujet, Message.slug, Message.message, Message.conversation_id,Message.created, UserExpediteur.id,UserExpediteur.username, UserExpediteur.avatar,UserDestinataire.username"
        ));
        
        if(!empty ($conversations))
        $this->set('conversations', $conversations);
    }
    
    /*
     * Permet d'écrire un nouveau message
     * 
     */
    public function ecrire($id = null){
        $id = $this->Auth->user('id');
        $data["users"] = $this->Message->UserDestinataire->find('list',array(
            "recursive" => -1
        ));
        
        $this->set($data);
        
        if($this->request->is('post')){
            unset($this->request->data[$this->modelClass]['destinataireUsername']);
            $d = $this->request->data;
            
            //debug($d); die();
            if ($this->Message->save($d)) {
                    $this->Session->setFlash(__('Votre message a correctement été envoyé.'));
                    $this->redirect(array('action' => 'index'));
            } else {
                    $this->Session->setFlash(__('Un problème est survenue lors de l\'envoi de votre message. Veuillez réessayer.'));
            }
        }       
    }
    
    public function destinataire(){
        
            $this->layout = null;

            if($this->request->is('post') || $this->request->is('put')){
                //debug($this->data); die();
                Configure::write('debug', 0);
                $destinataire = $this->data['queryString'];
                $this->loadModel('User');
                $destinataire_liste = $this->User->find('list', array(
                    "fields" => "User.id, User.username",
                    "conditions" => "User.username LIKE '$destinataire%'",
                    "recursive" => -1
                ));

                $this->set(compact('destinataire_liste'));
            }
    }
    
    /*
     * Permet de supprimer un message en fonction de différents cas de figure
     * 
     * Si l'expéditeur supprime un message, on passe delete à 2
     * Si le destinataire supprime un message, on passe delete à 3
     * 
     * Si delete vaut déjà 2 ou 3, c'est que l'autre a déjà supprimé le message, dans ce cas
     * on peut définitivement le supprimer de la base.
     * Si l'utilisateur est l'expéditeur, dans ce cas on supprime directement le message définitivement
     */
    public function delete($id){
        $this->Message->id = $id;
        $user_id = $this->Auth->user('id');
        
        //On récupère le message passé en paramètre
        $message = $this->Message->read(null, $id);
        $destinataire = $message['Message']['destinataire'];
        $expediteur = $message['Message']['expediteur'];
        $etat = $message['Message']['delete'];
        
        //Si le destinataire est l'expéditeur, on supprime directement le message définitivement
        if($destinataire == $expediteur){
            if ($this->Message->delete()) {
                $this->Session->setFlash('Ce message a bien été supprimé.');         
            }
            else{
                if (!$this->Message->exists()) {
                    $this->Session->setFlash('Ce message n\'existe plus.');
                }
                else {
                    $this->Session->setFlash(__('Ce message n\'a pas été supprimé. Veuillez réessayer.'));
                }
            }
            $this->redirect(array('action' => 'index'));
        }
        
        //Si c'est le destinataire qui fait l'action
        if($destinataire == $user_id){
            if($etat == 2){
                if ($this->Message->delete()) {
                $this->Session->setFlash('Ce message a bien été supprimé.');         
                }
                else{
                    if (!$this->Message->exists()) {
                        $this->Session->setFlash('Ce message n\'existe plus.');
                    }
                    else {
                        $this->Session->setFlash(__('Ce message n\'a pas été supprimé. Veuillez réessayer.'));
                    }
                }
            }else{
                $this->Message->saveField('delete', 3, array('callbacks' => false));
                $this->Session->setFlash('Ce message a bien été supprimé.');  
            }
            
            $this->redirect(array('action' => 'index'));
        }
         
        //Si c'est l'expéditeur qui fait l'action
        if($expediteur == $user_id){
            if($etat == 3){
                if ($this->Message->delete()) {
                $this->Session->setFlash('Ce message a bien été supprimé de votre boite d\'envoi.');         
                }
                else{
                    if (!$this->Message->exists()) {
                        $this->Session->setFlash('Ce message n\'existe plus.');
                    }
                    else {
                        $this->Session->setFlash(__('Ce message n\'a pas été supprimé. Veuillez réessayer.'));
                    }
                }
            }else{
                $this->Message->saveField('delete', 2, array('callbacks' => false));
                $this->Session->setFlash('Ce message a bien été supprimé de votre boite d\'envoi.');  
            }
            
            $this->redirect(array('action' => 'index'));
        }

    }
}
?>
