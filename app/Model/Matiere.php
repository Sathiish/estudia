<?php
App::uses('AppModel', 'Model');
/**
 * Matiere Model
 *
 */
class Matiere extends AppModel {
/**
 * Display field
 *
 * @var string
 */
	
        public $actsAs = array('Containable');
        public $hasMany = array('Theme');
        public $belongsTo = array('Classe');
        
        public $displayField = 'name';
/**
 * Validation rules
 *
 * @var array
 */
//	public $validate = array(
//		'name' => array(
//			'alphanumeric' => array(
//				'rule' => array('alphanumeric'),
//				//'message' => 'Your custom message here',
//				//'allowEmpty' => false,
//				//'required' => false,
//				//'last' => false, // Stop validation after this rule
//				'on' => 'create', // Limit validation to 'create' or 'update' operations
//			),
//		),
//	);
        
        function beforeSave($options = array()) {
            if(isset($this->data['Matiere']['name'])){
                $this->data['Matiere']['slug'] = strtolower(Inflector::slug($this->data['Matiere']['name'], '-'));
            }
            
            return true;
        }
        
        function getAllMatieres($classeId=null){
            if($classeId != null){
                $condition = "Matiere.classe_id = $classeId";
            }else{
                $condition = "1 = 1";
            }
            
            $AllMatieres = $this->find('list', array(
                "fields" => "id, name",
                "conditions" => $condition,
                "order" => "name ASC"
            ));

            return $AllMatieres;
        }
}
