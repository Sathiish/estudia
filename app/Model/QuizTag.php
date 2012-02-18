<?php 
class QuizTag extends AppModel{

	public $recursive = -1; 
	public $useTable = "quiz_tags"; 
	public $actsAs = array('containable'); 
	public $belongsTo = array(
		'Quiz',
                'Theme',
                'Matiere',
		'Tag' => array(
			'counterCache' => 'count_quiz'
		)
	); 


        public function afterSave(){
           
            if(isset($this->data['QuizTag']['quiz_id'])){
                $quizId = $this->data['QuizTag']['quiz_id'];
                $info = $this->Quiz->find('first', array(
                    "conditions" => "Quiz.id = $quizId",
                    "fields" => "Quiz.theme_id",
                    "contain" => array(
                        "Theme" => array(
                            "fields" => "Theme.matiere_id"
                        )
                    )
                ));
            }
            
            $d['QuizTag']['theme_id'] = $info['Theme']['id'];
            $d['QuizTag']['matiere_id'] = $info['Theme']['matiere_id'];
            
            $this->save($d,array(
                    'validate' => false,
                    'fieldList' => array("theme_id", "matiere_id"),
                    'callbacks' => false
                )
            );

            return true; 
    }
}