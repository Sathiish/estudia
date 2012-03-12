<?php 
class Classe extends AppModel{
    
        public $actsAs = array('Containable');
        
	public $hasMany = array('Theme');
	
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
        
        public function updatecount(){
        
//            //On met à jour le nombre de cours publié par tag
//            $listCour = $this->Classe->find('list', array("fields" => "CourTag.id, CourTag.tag_id"));
//
//            foreach($listCour as $kk=>$vv){
//                $countCour = $this->CourTag->find('count', array('conditions' => array("CourTag.tag_id = $vv AND CourTag.published = 1")));
//
//                $this->id = $vv;
//                $d['Tag']['count_published_cours'] = $countCour;
//                $this->save($d, array('validate' => false,'fieldList' => array(),'callbacks' => false));     
//            }
//
//            //On fait la même chose pour le nombre de quiz publié par tag
//            $listQuiz = $this->QuizTag->find('list', array("fields" => "QuizTag.id, QuizTag.tag_id"));
//
//            foreach($listQuiz as $k=>$v){
//                $countQuiz = $this->QuizTag->find('count', array('conditions' => array("QuizTag.tag_id = $v AND QuizTag.published = 1")));
//
//                $this->id = $v;
//                $d['Tag']['count_published_quiz'] = $countQuiz;
//                $this->save($d, array('validate' => false,'fieldList' => array(),'callbacks' => false));     
//            }
//            
//            return true;

        }
}