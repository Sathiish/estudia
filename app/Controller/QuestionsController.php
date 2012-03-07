<?php
App::uses('AppController', 'Controller');

class QuestionsController extends AppController {
    
    var $helpers = array ('Date');
    
    function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow('resultat', 'repondre', 'explication');
    }       
    
    public function _answer($data){
        if($this->request->is('post') || $this->request->is('put')){

            $ok = $this->Question->UserAnswer->save($data);

            if(!$ok){
                $this->Session->setFlash("Un problème est survenu avec l'enregistrement de vos réponses");
                $this->redirect($this->referer());
            }      
        }
    }
    
    public function visualiser($questionId){
        $contain = array("Quiz" => array(
                            "fields" => array("Quiz.id, Quiz.name, Quiz.slug"),
                            "User" => array(
                                    "fields" => array("User.id, User.username")
                            ),
                            "Theme" => array(
                                "fields" => array("Theme.id, Theme.name"),
                                "Matiere" => array(
                                    "fields" => array("Matiere.id, Matiere.name")
                                )
                            )
                        ),
                        "Answer" => array(
                                "fields" => array("Answer.id, Answer.name")
                        )
                        
                    );

        $this->_visualiser($questionId, $contain);
    } 
    
     public function repondre($quizId, $sort_order = null){
        
        if($this->request->is('post') || $this->request->is('put')){
            $d = $this->Question->set($this->data);
            $time = time();
            $d['UserAnswer']['id'] = null;
            $d['UserAnswer']['quiz_id'] = $quizId;
            $d['UserAnswer']['user_id'] = $this->Auth->User('id');
            $d['UserAnswer']['question_id'] = $d['Question']['question_id'];
            $d['UserAnswer']['answer_id'] = $d['Question']['answer_id'];
            $d['UserAnswer']['time'] = $time - $d['Question']['time'];

            if($this->Auth->User('id')){
                $this->_answer($d['UserAnswer']);
            }else{
                if($sort_order == null) $sort_order = 1;
                $name = "QuizAnswers-$sort_order";
                //On crée une variable de session pour enregistrer les résultats
                $this->Session->write($name, $d['UserAnswer']);
            }
            
        }
        
        if($sort_order != null){
            $condition = "Question.sort_order = $sort_order";
            $nextQuestion = $sort_order+1;
        }else{
            $condition = "Question.sort_order = 1";
            $nextQuestion = 2;
        }
        
        $question = $this->Question->find('first', array(
                    "conditions" => "Question.quiz_id = $quizId AND $condition",
                    "fields" => "Question.id, Question.question, Question.quiz_id",
                    "contain" => array('Answer' => array(
                        "fields" => "Answer.id, Answer.name"
                    ))
                ));

        If(!$question){
            $this->redirect("/questions/resultat/$quizId");
        }
        
        $questionId = $question['Question']['id'];
        $this->set(compact('question', 'quizId', 'nextQuestion', 'questionId'));
    }   
           
    public function resultat($quizId){
        if($this->Auth->User('id')){
            $userId = $this->Auth->User('id');
            $reponses = $this->Question->find('all', array(
                "conditions" => "Question.quiz_id = $quizId",
                "fields" => "Question.id, Question.question, Question.quiz_id",
                "contain" => array(
                    'Answer' => array(
                        "fields" => array("Answer.id, Answer.name, Answer.correct"),
                        "conditions" => "Answer.correct = 1"
                     ),
                    'UserAnswer' => array(
                        "fields" => array("UserAnswer.user_id, UserAnswer.question_id, UserAnswer.answer_id, UserAnswer.time"),
                        "conditions" => "UserAnswer.user_id = $userId"
                    ),
                    'Quiz' => array(
                        "fields" => array("Quiz.id, Quiz.name, Quiz.slug"),
                        "limit" => 1,
                        'Ressource' => array(
                            "fields" => array("Ressource.id, Ressource.titre, Ressource.slug"),
                            "limit" => 1
                        )
                    )
                )
            ));
            $render = "resultat";
        }else{
            $reponses = $this->Question->find('all', array(
                "conditions" => "Question.quiz_id = $quizId",
                "fields" => "Question.id, Question.question, Question.quiz_id, Question.sort_order",
                "contain" => array(
                    'Answer' => array(
                        "fields" => array("Answer.id, Answer.name, Answer.correct"),
                        "conditions" => "Answer.correct = 1"
                     ),
                    'Quiz' => array(
                        "fields" => array("Quiz.id, Quiz.name, Quiz.slug"),
                        "limit" => 1,
                        'Ressource' => array(
                            "fields" => array("Ressource.id, Ressource.titre, Ressource.slug"),
                            "limit" => 1
                        )
                    )
                )
            ));
            
            $render = "resultat-offline";
        }
 
        $quiz_info = $reponses[0]['Quiz'];
        $this->set(compact('reponses', 'quizId', 'quiz_info'));
        $this->render($render);
    }
    
    public function explication($questionId){
        
        if($this->Auth->User('id')){
            $userId = $this->Auth->User('id');
            $contain = array(
                'Answer' => array(
                    "conditions" => array("Answer.correct = 1"),
                    "fields" => array("Answer.name, Answer.correct")
                ),
                'UserAnswer' => array(
                    "conditions" => array("UserAnswer.user_id" => $userId),
                    "fields" => array("UserAnswer.id, UserAnswer.answer_id"),
                    "limit" => 1,
                    "Answer" => array(
                        "fields" => "Answer.name, Answer.correct",
                        "limit" => 1
                    )
                )
            );
        }else{
            $contain = array();
        }
        
        $explication = $this->Question->find('first', array(
            "conditions" => "Question.id = $questionId",
            "fields" => "Question.id, Question.question, Question.quiz_id, Question.explanation",
            "contain" => $contain
        ));
        
        $back = $this->referer();
         
        $this->set(compact('explication', 'back'));
    }
    
    public function manager($quizId){
        
        $user_id = $this->Auth->User('id');
        
        $questions = $this->Question->find('all', array(
            "conditions" => "Question.user_id = $user_id AND Question.quiz_id = $quizId ORDER BY Question.sort_order ASC",
            "fields" => "Question.id, Question.question, Question.quiz_id, Question.sort_order",
            "contain" => array()
        ));
        
        $info = $this->Question->getQuiz($quizId);
        
        $this->set(compact("questions", "info"));
    }
    
    public function add($quizId = null){
        
        if($this->request->is('post') || $this->request->is('put'))
        {
                //$this->Question->set($this->data);
                $d = $this->request->data;
		$d['Question']['id'] = null;
                
                if($quizId == null){
                    $quizId = $d['Question']['quiz_id'];
                }
                
                if($this->Question->Quiz->isPublished($quizId)){
                    $this->Session->setFlash("Action impossible sur un élément publié ou en attente de publication", 'notif', array('type' => 'error'));
                    $this->redirect("/quiz/manager");
                    die();
                }
                
                $lastPosition = $this->Question->find('first', array(
                    "fields" => "Question.sort_order",
                    "conditions" => "Question.quiz_id = $quizId ORDER BY sort_order DESC"
                ));
                
                if(!$lastPosition){
                    $d['Question']['sort_order'] = 1;
                }
                else{
                    $d['Question']['sort_order'] = $lastPosition['Question']['sort_order'] + 1;
                }
                
                //debug($d); die();
                if($this->Question->save($d)){
                    $this->Session->setFlash("Votre question a été correctement créé", 'notif');
                    $this->redirect("/answers/add/".$this->Question->id);                            
                }else
                {
                    $this->Session->setFlash("Corrigez les erreurs mentionnées", 'notif', array('type' => 'error'));
                    //$this->redirect($this->referer()); 
                }
        }else{
            $info = $this->Question->getQuiz($quizId);
            $this->set(compact("quizId", "info"));
        }
               
    }
    
    public function edit($id){

//        if($this->Question->isPublished($id)){
//            $this->Session->setFlash("Action impossible sur un élément publié ou en attente de publication", 'notif', array('type' => 'error'));
//            $this->redirect("/quiz/manager");
//            die();
//        }
        
        if($this->request->is('post') || $this->request->is('put'))
        {
            $this->Question->set($this->data);
            if($this->Question->save()){
                $this->Session->setFlash("Votre question a été correctement mise à jour", 'notif');
                $this->redirect($this->referer());                            
            }else
            {
                $this->Session->setFlash("Corrigez les erreurs mentionnées", 'notif', array('type' => 'error'));
                //$this->redirect($this->referer()); 
            }
        }else{
           
            $this->data = $this->Question->find('first', array(
                    "conditions" => "Question.id = $id",
                    "fields" => array("Question.id, Question.question, Question.explanation"),
                    "contain" => array(
                        "Quiz" => array(
                            "fields" => array("Quiz.id, Quiz.name")
                        )
                    )
                )
            );
            
        $answers = $this->Question->Answer->find('all', array(
            "conditions" => "Answer.question_id = $id ORDER BY sort_order ASC",
            "fields" => "Answer.id, Answer.name, Answer.hint, Answer.correct, Answer.sort_order, Question.question",
            "recursive" => 0
        ));
        
        $this->set(compact("answers"));
        }

    }
    
    public function monter($questionId){
  
        $req = $this->Question->find('first', array(
           "conditions" => "Question.id = $questionId",
           "fields" => "Question.quiz_id, Question.sort_order"
        ));
        
        $quizId = $req['Question']['quiz_id'];
        $sortOrder = $req['Question']['sort_order'];
        
        if($sortOrder <= 1){
            $this->Session->setFlash("Cette question est déjà la première du quiz", 'notif', array('type' => 'error'));
            $this->redirect($this->referer());
            die();
        }
        
        $newsortOrder = $sortOrder -1;
        
        $liste = $this->Question->find('list', array(
           "conditions" => "Question.quiz_id = $quizId AND (Question.sort_order = $sortOrder OR Question.sort_order = $newsortOrder)",
           "fields" => "Question.sort_order, Question.id"
        ));
        
        
        $new = $this->_array_change_key($liste, $sortOrder, $newsortOrder);
        
        foreach($new as $k=>$v){
            $this->Question->id =  $v;
            $this->Question->saveField('sort_order',$k);
        }
        
        $this->redirect($this->referer());
        
    }
    
    public function descendre($questionId){
  
        $req = $this->Question->find('first', array(
           "conditions" => "Question.id = $questionId",
           "fields" => "Question.quiz_id, Question.sort_order"
        ));
        
        $quizId = $req['Question']['quiz_id'];
        $sortOrder = $req['Question']['sort_order'];
                
        $newsortOrder = $sortOrder +1;
        
        $liste = $this->Question->find('list', array(
           "conditions" => "Question.quiz_id = $quizId AND (Question.sort_order = $sortOrder OR Question.sort_order = $newsortOrder)",
           "fields" => "Question.sort_order, Question.id"
        ));
        
        if(count($liste) <= 1){
            $this->Session->setFlash("Cette question est déjà la dernière du quiz", 'notif', array('type' => 'error'));
            $this->redirect($this->referer());
            die();
        }
        
        $new = $this->_array_change_key($liste, $sortOrder, $newsortOrder);
        
        foreach($new as $k=>$v){
            $this->Question->id =  $v;
            $this->Question->saveField('sort_order',$k);
        }
        
        $this->redirect($this->referer());
        
    }
    
    public function delete($questionId = null) {
        $quizIdToRedirect = $this->Question->find("first", array(
            "fields" => "Question.quiz_id, Question.sort_order",
            "conditions" => "Question.id = $questionId", 
            "recursive" => 0
            ));
        
        $currentSortOrder = $quizIdToRedirect['Question']['sort_order'];        
        $quizIdToRedirect = $quizIdToRedirect['Question']['quiz_id'];
        
        $quizToUpdate = $this->Question->find("list", array(
            "fields" => "Question.sort_order, Question.id",
            "conditions" => "Question.quiz_id = $quizIdToRedirect AND Question.sort_order > $currentSortOrder ORDER BY sort_order ASC", 
            "recursive" => 0
            ));
        
        if ($this->Question->delete($questionId, true)) {
            //On update l'ordre des questions suivantes
            foreach($quizToUpdate as $k=>$v){
                $this->Question->id =  $v; $value = $k - 1;
                $this->Question->saveField('sort_order',$value);             
            }
            $this->Session->setFlash("Question définitivement supprimée du quiz", 'notif');
        } else {
            $this->Session->setFlash("Un problème est survenu. Veuillez réessayer. Si le problème persiste, vous pouvez contacter l'administrateur du site à contact@zeschool.com", 'notif', array('type' => 'error'));
        }

        $this->redirect(array('controller' => 'questions', 'action' => 'edit', $quizIdToRedirect));
    }


}