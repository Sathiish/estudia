<?php
class Contact extends AppModel{
		
	public $useTable = false; 
	public $validate = array(
		'name' => array(
			'rule' => 'notEmpty',
			'required' => true,
			'message' => 'Vous devez entrer votre nom'
		),
		'email' => array(
			'rule' => 'email',
			'required' => true,
			'message' => 'Vous devez entrer un email valide'
		),
		'message' => array(
			'rule' => 'notEmpty',
			'required' => true,
			'message' => 'Vous devez entrer votre message'
		)
	);


	public function send($d){
		$this->set($d); 
		if($this->validates()){
			App::uses('CakeEmail','Network/Email');
			$mail = new CakeEmail(); 
			$mail->to('cayoul@gmail.com')
				->from($d['email'])
				->subject('Contact :: Site')
				->emailFormat('html')
				->template('contact')->viewVars($d);
			return $mail->send();
		}else{
			return false; 
		}
		
	}

}