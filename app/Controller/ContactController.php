<?php
class ContactController extends AppController{

	public $components = array('Session','Security'); 
	
        function beforeFilter() {
            parent::beforeFilter();
            $this->Auth->allow('index');
        }
        
	function index(){
		if($this->request->is('post')){
			if(!empty($this->request->data['Contact']['website'])){
				$this->Session->setFlash("Votre mail nous est bien parvenu","ok");
				$this->request->data = array(); 
			}else{
				if($this->Contact->send($this->request->data['Contact'])){
					$this->Session->setFlash("Votre message a bien été envoyé. Nous le traitons dans les plus bref délais","ok");
					$this->request->data = array(); 
				}else{
					$this->Session->setFlash("Merci de corriger vos champs","ko");
				}
			}
		}
	}

}