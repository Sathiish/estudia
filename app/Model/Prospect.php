<?php
App::uses('AppModel', 'Model');
/**
 * User Model
 *
 * @property  $
 */
class Prospect extends AppModel {
        
    /**
 * Validation parameters
 *
 * @var array
 */
	public $validate = array(
            'name' => array(
                    'alpha' => array(
                            'allowEmpty' => true,
                            'rule' => '!^[[:alpha:][:blank:]- \pL]+$!u', 
                            'message' => 'Le pseudo ne peut contenir que des chiffres et des lettres')),
            'email' => array(
                    'required' => array(
                            'rule' => 'notEmpty',
                            'message' => 'Veuillez entrer un email'),
                    'isValid' => array(
                            'rule' => 'email',
                            'required' => true,
                            'message' => 'Votre adresse email ne semble pas avoir un format valide')),
            'phone' => array(
                    'alpha' => array(
                            'allowEmpty' => true,
                            'rule' => 'alphaNumeric', 
                            'message' => 'Le pseudo ne peut contenir que des chiffres et des lettres')),
            'zip' => array(
                    'required' => array(
                            'rule' => 'notEmpty',
                            'message' => 'Veuillez entrer votre code postal'),
                    'to_short' => array(
                            'rule' => array('minLength', '5'),
                            'message' => 'Votre code postal doit contenir 5 caractères')
            ));

}
