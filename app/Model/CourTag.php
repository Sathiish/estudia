<?php 
class CourTag extends AppModel{

	public $recursive = -1; 
	public $useTable = "cours_tags"; 
	public $actsAs = array('containable'); 
	public $belongsTo = array(
		'Cour',
                'Theme',
                'Matiere',
		'Tag' => array(
			'counterCache' => 'count_cours'
		)
	); 

//	public function afterDelete(){
//		$this->Tag->deleteAll(array(
//			'count' => 0
//		)); 
//	}

        public function afterSave(){
           
            if(isset($this->data['CourTag']['cour_id'])){
                $coursId = $this->data['CourTag']['cour_id'];
                $info = $this->Cour->find('first', array(
                    "conditions" => "Cour.id = $coursId",
                    "fields" => "Cour.theme_id",
                    "contain" => array(
                        "Theme" => array(
                            "fields" => "Theme.matiere_id"
                        )
                    )
                ));
            }
            
            $d['CourTag']['theme_id'] = $info['Theme']['id'];
            $d['CourTag']['matiere_id'] = $info['Theme']['matiere_id'];
            
            $this->save($d,array(
                    'validate' => false,
                    'fieldList' => array("theme_id", "matiere_id"),
                    'callbacks' => false
                )
            );

            return true; 
    }
}