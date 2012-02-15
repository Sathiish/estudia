<?php
App::uses('AppController', 'Controller');

class QuizController extends AppController {
    
    function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow('index', 'view', 'theme', 'start', 'released', 'unreleased');
    }       
    
    public function index(){
          $matieres = $this->Quiz->Ressource->find('all', array(
            "fields" => "Ressource.id, Ressource.titre, Ressource.slug",
            "conditions" => "parent_id = 0",
            "order" => "titre ASC"
            ));
          
          $this->set(compact('matieres'));
    }
    
    public function theme($matiereId){

      $path = $this->Quiz->Ressource->find('first', array(
          "fields" => "Ressource.titre, Ressource.slug, Ressource.id",
          "conditions" => "Ressource.id = $matiereId",
          "recursive" => -1
      ));
      
      $themes = $this->Quiz->Ressource->find('all', array(
          "fields" => "Ressource.titre, Ressource.slug, Ressource.id",
          "conditions" => "Ressource.parent_id = $matiereId AND Ressource.type = 'theme'",
          "recursive" => -1
      ));
      
      $this->set(compact('themes', 'path'));
    }

    public function view($themeId){

      $path = $this->Quiz->Ressource->getPath($themeId, array('slug','id','titre','type'));
      
      if($this->Auth->User('id')){
          $userId = $this->Auth->User('id');
          $condition = "UserAnswer.user_id = $userId";
      }else{
          $condition = "1 = 0";
      }
      
      $quizz = $this->Quiz->find('all', array(
          "fields" => "Quiz.id, Quiz.name, Quiz.slug",
          "conditions" => "Quiz.ressource_id = $themeId",
          "contain" => array(
              'UserAnswer' => array(
                  "fields" =>"UserAnswer.id, UserAnswer.user_id",
                  "conditions" => $condition,
                  "limit" => 1
              )
          )
      ));
      $this->set(compact('quizz', 'path'));
    }

    public function start($quizId, $quizSlug, $restart=null){

        if($restart == "restart"){
            $suppression = $this->Quiz->UserAnswer->deleteAll(array(
                                'UserAnswer.quiz_id' => $quizId));
            if(!$suppression){
                $this->Session->setFlash("Un problème est survenu lors de la suppression de vos précédents résultats. Veuillez réessayer.", 'notif', array('type' => 'error'));
                $this->redirect($this->referer()); 
            }
        }
      $quiz = $this->Quiz->find('first', array(
          "fields" => "Quiz.id, Quiz.name, Quiz.slug, Quiz.description, Quiz.final_screen",
          "conditions" => "Quiz.id = $quizId",
          "recursive" => -1
      ));
      
      $this->set(compact('quiz'));
    }
        
    public function manager(){
          
        $user_id = $this->Auth->User('id');      
        
        $quizz = $this->Quiz->find('all', array(
            "conditions" => "Quiz.user_id = $user_id ORDER BY Quiz.id DESC",
            "fields" => "Quiz.id, Quiz.name, Quiz.slug, Quiz.description, Quiz.validation, Quiz.public",
            "contain" => array(
                "Ressource" => array(
                    "fields" => array("Ressource.id, Ressource.titre")
                )
            )
        ));

        $this->set(compact("quizz"));
    }
    
    public function add(){
        //$this->layout = "modal";
        
        if($this->request->is('post') || $this->request->is('put'))
        {
                $this->Quiz->set($this->data);
                
                if($this->Quiz->save()){
                    $redirectTarget = $this->Quiz->id;
                    $this->Session->setFlash("Votre quiz a été correctement créé", 'notif');
                    $this->redirect("/questions/add/$redirectTarget");                            
                }else
                {
                    //debug($this->Quiz->invalidFields());die();
                    $this->Session->setFlash("Corrigez les erreurs mentionnées.", 'notif', array('type' => 'error'));
                    $this->redirect($this->referer()); 
                }
        }
        
        $matieres = array('Choisissez votre matière') + $this->Quiz->Ressource->find('list', array(
                    "fields" => "id, titre",
                    "conditions" => "parent_id = 0 AND Ressource.etat = 1"
                ));
        
        $this->set(compact("matieres"));
    }
    
    public function edit($quizId){
        
        if($this->Quiz->isPublic($quizId)){
            $this->Session->setFlash("Action impossible sur un élément publié ou en attente de publication", 'notif', array('type' => 'error'));
            $this->redirect("/quiz/manager");
            die();
        }
        
        if($this->request->is('post') || $this->request->is('put'))
        {
            $this->Quiz->set($this->data);
            
            if($this->Quiz->save($this->data, true, array('name','description','final_screen'))){
                $this->Session->setFlash("Votre quiz a été correctement mise à jour", 'notif');
                $this->redirect($this->referer());                          
            }else
            {
                $this->Session->setFlash("Corrigez les erreurs mentionnées.", 'notif', array('type' => 'error'));
                $this->redirect($this->referer()); 
            }
        }else{
            $this->data = $this->Quiz->find('first', array(
            "conditions" => "Quiz.id = $quizId",
            "fields" => "Quiz.id, Quiz.name, Quiz.slug, Quiz.description, Quiz.final_screen",
            "contain" => array()
            ));
            
            $user_id = $this->Auth->User('id');
        
        $questions = $this->Quiz->Question->find('all', array(
            "conditions" => "Question.user_id = $user_id AND Question.quiz_id = $quizId ORDER BY Question.sort_order ASC",
            "fields" => "Question.id, Question.question, Question.quiz_id, Question.sort_order",
            "contain" => array()
        ));
        
        
        $this->set(compact("questions", "quizId"));
        }

    }
    
    public function askforreleased($quizId){

        $quiz = $this->Quiz->find('first', array(
            "fields" => "Quiz.public, Quiz.validation, Quiz.name, Quiz.description, Quiz.final_screen",
            "conditions" => "Quiz.id = $quizId",
            "contain" => array(
                'Ressource' => array(
                    "fields" => "Ressource.titre",
                    "limit" => 1
                ),
                'Question' => array(
                    'fields' => array('Question.question', 'Question.explanation', 'Question.id'),
                    "Answer" => array(
                        "fields" => array("Answer.id, Answer.name, Answer.correct")
                    )
                ),
                'User' => array(
                    "fields" => "User.username",
                    "limit" => 1
                )
            )
        ));
        
        if(!$quiz){
            $this->Session->setFlash("Un problème est survenu avec la validation de ce quiz", 'notif', array('type' => 'error'));
            $this->redirect($this->referer()); 
        }else{
            if(!$quiz['Quiz']['public']){
                $this->Quiz->id = $quizId;
                $token = $this->Quiz->User->generateToken();
                
                $d['Quiz']['id'] = $this->Quiz->id;
                $d['Quiz']['validation'] = 1;
                $d['Quiz']['token'] = $token;
                if($this->Quiz->save($d,true,array('validation','token'))){ 
                    $link = array('controller'=>'quiz','action'=>'released', $token);
                                    App::uses('CakeEmail','Network/Email'); 
                                    $mail = new CakeEmail(); 
                                    $mail->from('noreply@zeschool.com')
                                            ->to('cayoul@gmail.com')
                                            ->subject('Publié un quiz')
                                            ->emailFormat('html')
                                            ->template('askforreleased')
                                            //->layout('quiz')
                                            ->viewVars(array('quiz'=>$quiz,'link'=>$link))
                                            ->send();
                    $this->Session->setFlash("Votre demande de validation a bien été transmise. Celle-ci sera traitée très rapidement.", 'notif');
                    $this->redirect($this->referer());   
                }else{
                $this->Session->setFlash("La demande de publication de ce quiz n'a pas été transmise. Un problème est survenu. Veuillez envoyer votre demande à contact@zeschool.com directement.", 'notif', array('type' => 'error'));
                $this->redirect($this->referer());     
            }
            }else{
                $this->Session->setFlash("Votre demande de publication a déjà été transmise", 'notif');
                $this->redirect($this->referer());     
            }

        }
    }
    
    public function released($token){
        $this->layout = null;
        
        $quiz = $this->Quiz->find('first', array(
            "fields" => "Quiz.id",
            "conditions" => 'Quiz.token = "'.$token.'"',
            "contain" => array(
                'User' => array(
                    "fields" => "User.username, User.email",
                    "limit" => 1
                )
            )
        ));
        
        if(!$quiz){
            $this->Session->setFlash("Ce quiz n'a pas été trouvé", 'notif', array('type' => 'error'));
            $this->redirect($this->referer()); 
        }else{
            $this->Quiz->id = $quiz['Quiz']['id'];
            
            $d['Quiz']['id'] = $this->Quiz->id;
            $d['Quiz']['public'] = 1;
            $d['Quiz']['validation'] = 0;
            $d['Quiz']['token'] = 0;
            if($this->Quiz->save($d,true,array('validation','public','token'))){ 
                App::uses('CakeEmail','Network/Email'); 
                $mail = new CakeEmail(); 
                $mail->from('noreply@zeschool.com')
                        ->to($quiz['User']['email'])
                        ->subject('Votre demande de publication a été validée')
                        ->emailFormat('html')
                        ->template('released')
                        ->viewVars(array('username'=>$quiz['User']['username']))
                        ->send();
                $resultat = "Quiz mis en ligne";
            }else{
                $resultat = "Le quiz n'a pas été mis en ligne";
            }
            $this->set(compact("resultat"));
        }     
    }
    
    public function unreleased($token){
        $this->layout = null;
        
        $quiz = $this->Quiz->find('first', array(
            "fields" => "Quiz.id",
            "conditions" => 'Quiz.token = "'.$token.'"',
            "contain" => array(
                'User' => array(
                    "fields" => "User.username, User.email",
                    "limit" => 1
                )
            )
        ));
        
        if(!$quiz){
            $this->Session->setFlash("Ce quiz n'a pas été trouvé", 'notif', array('type' => 'error'));
            $this->redirect($this->referer()); 
        }else{
            $this->Quiz->id = $quiz['Quiz']['id'];
            
            $d['Quiz']['id'] = $this->Quiz->id;
            $d['Quiz']['public'] = 0;
            $d['Quiz']['validation'] = 0;
            $d['Quiz']['token'] = 0;
            if($this->Quiz->save($d,true,array('validation','public','token'))){ 
                App::uses('CakeEmail','Network/Email'); 
                $mail = new CakeEmail(); 
                $mail->from('noreply@zeschool.com')
                        ->to($quiz['User']['email'])
                        ->subject('Votre demande de dépublication a été validée')
                        ->emailFormat('html')
                        ->template('unreleased')
                        ->viewVars(array('username'=>$quiz['User']['username']))
                        ->send();
                $resultat = "Quiz dépublié";
            }else{
                $resultat = "Le quiz n'a pas été dépublié";
            }
            $this->set(compact("resultat"));
            $this->render('released');
        }     
    }
    
    public function askforunreleased($quizId){
        $quiz = $this->Quiz->find('first', array(
            "fields" => "Quiz.public",
            "conditions" => "Quiz.id = $quizId",
            "contain" => array(
                'Ressource' => array(
                    "fields" => "Ressource.titre",
                    "limit" => 1
                ),
                'Question' => array(
                    'fields' => array('Question.question', 'Question.explanation', 'Question.id'),
                    "Answer" => array(
                        "fields" => array("Answer.id, Answer.name, Answer.correct")
                    )
                ),
                'User' => array(
                    "fields" => "User.username",
                    "limit" => 1
                )
            )
        ));
            
        if(!$quiz){
            $this->Session->setFlash("Un problème est survenu avec la dépublication de ce quiz", 'notif', array('type' => 'error'));
            $this->redirect($this->referer()); 
        }else{
            if($quiz['Quiz']['public']){
                $this->Quiz->id = $quizId;
                $token = $this->Quiz->User->generateToken();
                $this->Quiz->saveField('validation',1);
                $this->Quiz->saveField('token',$token);
                $link = array('controller'=>'quiz','action'=>'unreleased', $token);
				App::uses('CakeEmail','Network/Email'); 
				$mail = new CakeEmail(); 
				$mail->from('noreply@zeschool.com')
					->to('cayoul@gmail.com')
					->subject('Dépublié un quiz')
					->emailFormat('html')
					->template('askforreleased')
                                        //->layout('quiz')
					->viewVars(array('quiz'=>$quiz,'link'=>$link, 'unreleased'=> true))
					->send();
                $this->Session->setFlash("Votre demande de dépublication a bien été transmise. Celle-ci sera traitée très rapidement.", 'notif');
                $this->redirect($this->referer());              
            }else{
                $this->Session->setFlash("Votre demande de dépublication a déjà été transmise", 'notif', array('type' => 'error'));
                $this->redirect($this->referer());     
            }
        $this->set(compact($resultat));
        }
    }
    
    public function delete($quizId = null) {
        if ($this->Quiz->delete($quizId, true)) {
            $this->Session->setFlash("Quiz définitivement supprimé", 'notif');
        } else {
            $this->Session->setFlash("Un problème est survenu. Veuillez réessayer. Si le problème persiste, vous pouvez contacter l'administrateur du site à contact@zeschool.com", 'notif', array('type' => 'error'));
        }

        $this->redirect(array('controller' => 'quiz', 'action' => 'manager'));
    }
}