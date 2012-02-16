<?php 
class Tag extends AppModel{
    
        public $actsAs = array('Containable');
	public $useTable = "tags"; 
        
	public $hasMany = array('CourTag', 'QuizTag');
	
        public function findRelated($model, $id){
            switch($model){
                case "Cour":
                    $target = "CourTag";
                    break;
                case "Quiz":
                    $target = "QuizTag";
                    break;
            }

            $tags = $this->$target->find('all', array(
                "conditions" => "$target.".$model."_id = $id",
                "fields" => array("$target.id, $target.".$model."_id"),
                "contain" => array(
                    "Tag" => array(
                        "fields" => "Tag.name"
                    )
                )
            ));
           
            return $tags;
        }
}