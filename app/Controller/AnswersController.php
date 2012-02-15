<?php
App::uses('AppController', 'Controller');

class AnswersController extends AppController {
    
    function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow('*');
    }       
    
    public function manager($id){
               
        $answers = $this->Answer->find('all', array(
            "conditions" => "Answer.question_id = $id ORDER BY sort_order ASC",
            "fields" => "Answer.id, Answer.name, Answer.hint, Answer.correct, Answer.sort_order, Question.question",
            "recursive" => 0
        ));
        
        $info = $this->Answer->getQuestion($id);
        
        $this->set(compact("answers", "info"));
    }
        
    public function add($questionId = null){
        
        if($this->request->is('post') || $this->request->is('put'))
        {
            $this->Answer->set($this->data);
            $d = $this->request->data;
            $d['Answer']['id'] = null;
            
            if($questionId == null){
                $questionId = $d['Answer']['question_id'];
            }
            
            $lastPosition = $this->Answer->find('first', array(
                    "fields" => "Answer.sort_order",
                    "conditions" => "Answer.question_id = $questionId ORDER BY sort_order DESC"
            ));

            if(!$lastPosition){
                $d['Answer']['sort_order'] = 1;
            }
            else{
                $d['Answer']['sort_order'] = $lastPosition['Answer']['sort_order'] + 1;
            }
                
            if($this->Answer->save($d)){
                $this->Session->setFlash("Votre réponse a été correctement ajoutée", 'notif');
                $this->redirect("/questions/edit/$questionId");                            
            }else
            {
                $this->Session->setFlash("Corrigez les erreurs mentionnées", 'notif', array('type' => 'error'));
                $this->redirect($this->referer()); 
            }
        }
        $info = $this->Answer->getQuestion($questionId);
        $this->set(compact("questionId", "info"));
    }
    
    public function edit($id){
        
        if($this->request->is('post') || $this->request->is('put'))
        {
            $this->Answer->set($this->data);

            if($this->Answer->save()){
                //On récupère l'Id de la question vers laquelle on redirige
                $redirectTarget = $this->Answer->find('first', array("fields"=> "Answer.question_id", "conditions" => "Answer.id = $id", "recursive" => -1));
                $redirectTarget = $redirectTarget['Answer']['question_id'];
                $this->Session->setFlash("Votre réponse a été correctement mise à jour", 'notif');
                $this->redirect("/answers/manager/".$redirectTarget);                            
            }else
            {
                $this->Session->setFlash("Corrigez les erreurs mentionnées", 'notif', array('type' => 'error'));
                $this->redirect($this->referer()); 
            }
        }else{
            $this->data = $this->Answer->find('first', array(
                "conditions" => "Answer.id = $id",
                "fields" => "Answer.id, Answer.name, Answer.hint, Answer.correct, Answer.question_id",
                "recursive" => -1
            ));
            if(!empty($this->data)){
                $info = $this->Answer->getQuestion($this->data['Answer']['question_id']);
                $this->set(compact("info"));
            }else{
                $this->Session->setFlash("Cette page n'a pas pu être trouvée", 'notif', array('type' => 'error'));
                $this->redirect("/quiz/manager/"); 
            }
            
        }

    }
    
    public function monter($answerId){
  
        $req = $this->Answer->find('first', array(
           "conditions" => "Answer.id = $answerId",
           "fields" => "Answer.question_id, Answer.sort_order"
        ));
        
        $questionId = $req['Answer']['question_id'];
        $sortOrder = $req['Answer']['sort_order'];
        
        if($sortOrder <= 1){
            $this->Session->setFlash("Cette réponse est déjà la première", 'notif', array('type' => 'error'));
            $this->redirect($this->referer());
            die();
        }
        
        $newsortOrder = $sortOrder -1;
        
        $liste = $this->Answer->find('list', array(
           "conditions" => "Answer.question_id = $questionId AND (Answer.sort_order = $sortOrder OR Answer.sort_order = $newsortOrder)",
           "fields" => "Answer.sort_order, Answer.id"
        ));
        
        
        $new = $this->_array_change_key($liste, $sortOrder, $newsortOrder);
        
        foreach($new as $k=>$v){
            $this->Answer->id =  $v;
            $this->Answer->saveField('sort_order',$k);
        }
        
        $this->redirect($this->referer());
        
    }
    
    public function descendre($answerId){
  
        $req = $this->Answer->find('first', array(
           "conditions" => "Answer.id = $answerId",
           "fields" => "Answer.question_id, Answer.sort_order"
        ));
        
        $questionId = $req['Answer']['question_id'];
        $sortOrder = $req['Answer']['sort_order'];
                
        $newsortOrder = $sortOrder +1;
        
        $liste = $this->Answer->find('list', array(
           "conditions" => "Answer.question_id = $questionId AND (Answer.sort_order = $sortOrder OR Answer.sort_order = $newsortOrder)",
           "fields" => "Answer.sort_order, Answer.id"
        ));
        
        if(count($liste) <= 1){
            $this->Session->setFlash("Cette réponse est déjà la dernière", 'notif', array('type' => 'error'));
            $this->redirect($this->referer());
            die();
        }
        
        $new = $this->_array_change_key($liste, $sortOrder, $newsortOrder);
        
        foreach($new as $k=>$v){
            $this->Answer->id = $v;
            $this->Answer->saveField('sort_order',$k);
        }
        
        $this->redirect($this->referer());
        
    }
    
    public function delete($answerId) {
        $questionToRedirect = $this->Answer->find("first", array(
            "fields" => "Answer.question_id, Answer.sort_order",
            "conditions" => "Answer.id = $answerId", 
            "recursive" => -1
            ));
        $questionId = $questionToRedirect['Answer']['question_id'];
        $currentSortOrder = $questionToRedirect['Answer']['sort_order']; 
        
        $questionToUpdate = $this->Answer->find("list", array(
            "fields" => "Answer.sort_order, Answer.id",
            "conditions" => "Answer.question_id = $questionId AND Answer.sort_order > $currentSortOrder ORDER BY sort_order ASC", 
            "recursive" => 0
        ));
        
        if ($this->Answer->delete($answerId)) {
            //On update l'ordre des questions suivantes
            foreach($questionToUpdate as $k=>$v){
                $this->Answer->id =  $v; $value = $k - 1;
                $this->Answer->saveField('sort_order',$value);            
            }
            $this->Session->setFlash("Réponse supprimée", 'notif');
        } else {
            $this->Session->setFlash("Un problème est survenu. Veuillez réessayer.", 'notif', array('type' => 'error'));
        }

        $this->redirect(array('controller' => 'questions', 'action' => 'edit', $questionId));
    }

}