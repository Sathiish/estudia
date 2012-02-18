<?php
App::uses('AppController', 'Controller');
/**
 * Ressources Controller
 *
 * @property Ressource $Ressource
 */
class QuizTagsController extends AppController {
    
    public function view($tagId){
        $tags = $this->QuizTag->find('all', array(
            "conditions" => "QuizTag.tag_id = $tagId",
            "contain" => array(
                "Quiz" => array(
                    "fields" => array("Quiz.id, Quiz.name, Quiz.slug, Quiz.theme_id"),
                    "Theme" => array(
                        "fields" => array("Theme.id, Theme.name, Theme.slug"),
                        "Matiere" => array(
                            "fields" => array("Matiere.id, Matiere.slug, Matiere.name")
                        )
                    )
                )
            )
        ));
        
        $this->set(compact('tags'));
    }

    
    public function delete($id){    
        $this->QuizTag->delete($id, false);
    }
    
    public function addtag($tagId, $quizId){
        
            $this->layout = null;

            $d['QuizTag']['quiz_id'] = $quizId;
            $d['QuizTag']['tag_id'] = $tagId;
            
            $exist = $this->QuizTag->find('first', array(
               "conditions" => "QuizTag.tag_id = $tagId AND QuizTag.quiz_id = $quizId",
                "fields" => "QuizTag.id"
            ));
            if(!$exist){
                $this->QuizTag->save($d);
                         
            }else{
                $error = "Ce quiz est déjà classé dans cette matière. Vous pouvez également le classer dans une autre matière";
                $this->set(compact('error'));
            }      
            $relatedTags = $this->QuizTag->Tag->findRelated('Quiz', $quizId);
            $model = $this->modelClass;
            $this->set(compact('relatedTags', 'model'));
            $this->render('/common/tag');
    }
}