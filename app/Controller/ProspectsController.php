<?php
App::uses('AppController', 'Controller');

class ProspectsController extends AppController {
    
    function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow('*');
    }       
    
    public function contact($save = true){
        
        if($save){
            if($this->request->is('post') || $this->request->is('put')) {

                $d = $this->Prospect->set($this->data);

                if($this->Prospect->save($d)){
                    $message = 'Votre demande a bien été transmise';
                    $this->set(compact('message'));
                }else{
                    $message = 'Votre demande n\'a pas été envoyée';
                    $type = 'error';
                    $this->set(compact('message', 'type'));
                }         
                
            }
        }
        
        if($this->Auth->user('id')){
            $d = $this->data;
            
            if(!isset($d['Prospect']['name']))
                $d['Prospect']['name'] = $this->Auth->user('name').' '.$this->Auth->user('lastname');
            if(!isset($d['Prospect']['email']))
                $d['Prospect']['email'] = $this->Auth->user('email');
            if(!isset($d['Prospect']['classe_id']))
                $d['Prospect']['classe_id'] = $this->Auth->user('tag_id');
            
            $this->data = $d;
        }
        
        $this->loadModel('Classe');
        $classes = $this->Classe->find('list', array('contain' => array()));

        $this->set(compact('classes'));
        
    }
            
}