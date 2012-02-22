<?php
App::uses('AppController', 'Controller');

class QuizController extends AppController {
    
    public $helpers = array('Autocomplete');
    
    function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow('index', 'view', 'theme', 'start', 'released', 'unreleased');
    }       
        
    public function theme($matiereId){

      $path = $this->Quiz->Theme->Matiere->find('first', array(
          "fields" => "Matiere.name, Matiere.slug, Matiere.id",
          "conditions" => "Matiere.id = $matiereId",
          "recursive" => -1
      ));
      
       
      $themes = $this->Quiz->Theme->find('all', array(
          "fields" => "Theme.name, Theme.slug, Theme.id",
          "conditions" => "Theme.matiere_id = $matiereId AND Theme.count_published_quiz > 0",
          "recursive" => -1
      ));
      
      $this->set(compact('themes', 'path'));
    }

    public function view($themeId){

      $path = $this->Quiz->Theme->findPath($themeId);
      if($this->Auth->User('id')){
          $userId = $this->Auth->User('id');
          $condition = "UserAnswer.user_id = $userId";
      }else{
          $condition = "1 = 0";
      }
      
      $quizz = $this->Quiz->find('all', array(
          "fields" => "Quiz.id, Quiz.name, Quiz.slug",
          "conditions" => "Quiz.theme_id = $themeId AND Quiz.published = 1",
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
        
    public function visualiser($quizId){
        $contain = array("Theme" => array(
                            "fields" => array("Theme.id, Theme.name"),
                            "Matiere" => array(
                                "fields" => array("Matiere.id, Matiere.name")
                            )
                        ),
                        "User" => array(
                                "fields" => array("User.id, User.username")
                        )
                    );

        $this->_visualiser($quizId, $contain);
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
            "fields" => "Quiz.id, Quiz.name, Quiz.slug, Quiz.description, Quiz.validation, Quiz.published",
            "contain" => array(
                "Theme" => array(
                    "fields" => array("Theme.id, Theme.name")
                )
            )
        ));

        $this->set(compact("quizz"));
    }
    
    public function add(){
        
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
        
        $matieres = array('Choisissez votre matière') + $this->Quiz->Theme->Matiere->find('list', array(
                    "fields" => "id, name",
                    "conditions" => "Matiere.published = 1"
                ));
        
        $this->set(compact("matieres"));
    }
    
    public function edit($quizId){
        
        if($this->Quiz->isPublished($quizId)){
            $this->Session->setFlash("Action impossible sur un élément publié ou en attente de publication", 'notif', array('type' => 'error'));
            $this->redirect("/quiz/manager");
            die();
        }
        
        if($this->request->is('post') || $this->request->is('put'))
        {

            $d = $this->Quiz->set($this->data);
            $d['Quiz']['tags'] = "";

                //On crée la matière si celle-ci n'existe pas
                if($d['Quiz']['matiere_id'] == ""){
                    $d['Matiere']['id'] = null;
                    $this->loadModel('Matiere');
                    $ok = $this->Matiere->save($d['Matiere']);
                    if($ok) $d['Quiz']['matiere_id'] = $this->Matiere->id;
                }

                //On crée le thème si celui-ci n'existe pas
                if(!empty($d['Theme']['name'])){
                    $d['Theme']['id'] = null;

                    $d['Theme']['matiere_id'] =  $d['Quiz']['matiere_id'];

                    $this->loadModel('Theme');
                    $ok2 = $this->Theme->save($d['Theme']);
                    if($ok2) $d['Quiz']['theme_id'] = $this->Theme->id;
                }

            if($this->Quiz->save($d)){
                $this->Session->setFlash("Votre quiz a été correctement mise à jour", 'notif');
                $this->redirect($this->referer());                          
            }else
            {
                $this->Session->setFlash("Corrigez les erreurs mentionnées.", 'notif', array('type' => 'error'));
                $this->redirect($this->referer()); 
            }
        }
        
        $this->data = $this->Quiz->find('first', array(
        "conditions" => "Quiz.id = $quizId",
        "fields" => "Quiz.id, Quiz.name, Quiz.slug, Quiz.description, Quiz.final_screen, Quiz.theme_id",
        "contain" => array(
            "Theme" => array(
                "fields" => array("Theme.id, Theme.name, Theme.slug"),
                "Matiere" => array(
                    "fields" => "Matiere.id, Matiere.name, Matiere.slug")
            )
        )
        ));

        $user_id = $this->Auth->User('id');
        
        $questions = $this->Quiz->Question->find('all', array(
            "conditions" => "Question.user_id = $user_id AND Question.quiz_id = $quizId ORDER BY Question.sort_order ASC",
            "fields" => "Question.id, Question.question, Question.quiz_id, Question.sort_order",
            "contain" => array()
        ));
        
        $matieres = $this->Quiz->Theme->Matiere->getAllMatieres() + array("" => "Soumettre une nouvelle matière");
        $relatedTags = $this->Quiz->Tag->findRelated($this->modelClass, $quizId);
        $this->set(compact('matieres','questions', 'relatedTags'));
      

    }
    
//    public function askforreleased($quizId){
//
//        $quiz = $this->Quiz->find('first', array(
//            "fields" => "Quiz.public, Quiz.validation, Quiz.name, Quiz.description, Quiz.final_screen",
//            "conditions" => "Quiz.id = $quizId",
//            "contain" => array(
//                'Ressource' => array(
//                    "fields" => "Ressource.titre",
//                    "limit" => 1
//                ),
//                'Question' => array(
//                    'fields' => array('Question.question', 'Question.explanation', 'Question.id'),
//                    "Answer" => array(
//                        "fields" => array("Answer.id, Answer.name, Answer.correct")
//                    )
//                ),
//                'User' => array(
//                    "fields" => "User.username",
//                    "limit" => 1
//                )
//            )
//        ));
//        
//        if(!$quiz){
//            $this->Session->setFlash("Un problème est survenu avec la validation de ce quiz", 'notif', array('type' => 'error'));
//            $this->redirect($this->referer()); 
//        }else{
//            if(!$quiz['Quiz']['public']){
//                $this->Quiz->id = $quizId;
//                $token = $this->Quiz->User->generateToken();
//                
//                $d['Quiz']['id'] = $this->Quiz->id;
//                $d['Quiz']['validation'] = 1;
//                $d['Quiz']['token'] = $token;
//                if($this->Quiz->save($d,true,array('validation','token'))){ 
//                    $link = array('controller'=>'quiz','action'=>'released', $token);
//                                    App::uses('CakeEmail','Network/Email'); 
//                                    $mail = new CakeEmail(); 
//                                    $mail->from('noreply@zeschool.com')
//                                            ->to('cayoul@gmail.com')
//                                            ->subject('Publié un quiz')
//                                            ->emailFormat('html')
//                                            ->template('askforreleased')
//                                            //->layout('quiz')
//                                            ->viewVars(array('quiz'=>$quiz,'link'=>$link))
//                                            ->send();
//                    $this->Session->setFlash("Votre demande de validation a bien été transmise. Celle-ci sera traitée très rapidement.", 'notif');
//                    $this->redirect($this->referer());   
//                }else{
//                $this->Session->setFlash("La demande de publication de ce quiz n'a pas été transmise. Un problème est survenu. Veuillez envoyer votre demande à contact@zeschool.com directement.", 'notif', array('type' => 'error'));
//                $this->redirect($this->referer());     
//            }
//            }else{
//                $this->Session->setFlash("Votre demande de publication a déjà été transmise", 'notif');
//                $this->redirect($this->referer());     
//            }
//
//        }
//    }
//    
//    public function released($token, $admin = null){
//  
//        if(!empty($admin) && $admin == "validation"){
//            $condition = "Quiz.id";
//        }else{
//            $condition = "Quiz.token";
//             $this->layout = null;
//        }
//        
//        $quiz = $this->Quiz->find('first', array(
//            "fields" => "Quiz.id",
//            "conditions" => "$condition = $token",
//            "contain" => array(
//                'User' => array(
//                    "fields" => "User.username, User.email",
//                    "limit" => 1
//                )
//            )
//        ));
//        
//        if(!$quiz){
//            $this->Session->setFlash("Cette action est impossible", 'notif', array('type' => 'error'));
//            $this->redirect($this->referer()); 
//        }else{
//            $this->Quiz->id = $quiz['Quiz']['id'];
//            
//            $d['Quiz']['id'] = $this->Quiz->id;
//            $d['Quiz']['published'] = 1;
//            $d['Quiz']['validation'] = 0;
//            $d['Quiz']['token'] = 0;
//            if($this->Quiz->save($d,true,array('validation','published','token'))){
//                
//                $this->Quiz->updateCounter();
////                App::uses('CakeEmail','Network/Email'); 
////                $mail = new CakeEmail(); 
////                $mail->from('contact@zeschool.com')
////                        ->to($quiz['User']['email'])
////                        ->subject('Votre demande de publication a été validée')
////                        ->emailFormat('html')
////                        ->template('released')
////                        ->viewVars(array('username'=>$quiz['User']['username']))
////                        ->send();
//                $resultat = "Quiz mis en ligne";
//            }else{
//                $resultat = "Le quiz n'a pas été mis en ligne";
//            }
//            $this->set(compact("resultat"));
//        }     
//    }
//    
//    public function unreleased($token, $admin = null){
//        
//        if(!empty($admin) && $admin == "validation"){
//            $condition = "Quiz.id";
//        }else{
//            $condition = "Quiz.token";
//             $this->layout = null;
//        }
//                
//        $quiz = $this->Quiz->find('first', array(
//            "fields" => "Quiz.id",
//            "conditions" => "$condition = $token",
//            "contain" => array(
//                'User' => array(
//                    "fields" => "User.username, User.email",
//                    "limit" => 1
//                )
//            )
//        ));
//        
//        if(!$quiz){
//            $this->Session->setFlash("Ce quiz n'a pas été trouvé", 'notif', array('type' => 'error'));
//            $this->redirect($this->referer()); 
//        }else{
//            $this->Quiz->id = $quiz['Quiz']['id'];
//            
//            $d['Quiz']['id'] = $this->Quiz->id;
//            $d['Quiz']['published'] = 0;
//            $d['Quiz']['validation'] = 0;
//            $d['Quiz']['token'] = 0;
//            if($this->Quiz->save($d,true,array('validation','published','token'))){ 
//                $this->Quiz->updateCounter(true);
////                App::uses('CakeEmail','Network/Email'); 
////                $mail = new CakeEmail(); 
////                $mail->from('noreply@zeschool.com')
////                        ->to($quiz['User']['email'])
////                        ->subject('Votre demande de dépublication a été validée')
////                        ->emailFormat('html')
////                        ->template('unreleased')
////                        ->viewVars(array('username'=>$quiz['User']['username']))
////                        ->send();
//                $resultat = "Quiz dépublié";
//            }else{
//                $resultat = "Le quiz n'a pas été dépublié";
//            }
//            $this->set(compact("resultat"));
//            $this->render('released');
//        }     
//    }
//    
//    public function askforunreleased($quizId){
//        $quiz = $this->Quiz->find('first', array(
//            "fields" => "Quiz.public",
//            "conditions" => "Quiz.id = $quizId",
//            "contain" => array(
//                'Ressource' => array(
//                    "fields" => "Ressource.titre",
//                    "limit" => 1
//                ),
//                'Question' => array(
//                    'fields' => array('Question.question', 'Question.explanation', 'Question.id'),
//                    "Answer" => array(
//                        "fields" => array("Answer.id, Answer.name, Answer.correct")
//                    )
//                ),
//                'User' => array(
//                    "fields" => "User.username",
//                    "limit" => 1
//                )
//            )
//        ));
//            
//        if(!$quiz){
//            $this->Session->setFlash("Un problème est survenu avec la dépublication de ce quiz", 'notif', array('type' => 'error'));
//            $this->redirect($this->referer()); 
//        }else{
//            if($quiz['Quiz']['public']){
//                $this->Quiz->id = $quizId;
//                $token = $this->Quiz->User->generateToken();
//                $this->Quiz->saveField('validation',1);
//                $this->Quiz->saveField('token',$token);
//                $link = array('controller'=>'quiz','action'=>'unreleased', $token);
//				App::uses('CakeEmail','Network/Email'); 
//				$mail = new CakeEmail(); 
//				$mail->from('noreply@zeschool.com')
//					->to('cayoul@gmail.com')
//					->subject('Dépublié un quiz')
//					->emailFormat('html')
//					->template('askforreleased')
//                                        //->layout('quiz')
//					->viewVars(array('quiz'=>$quiz,'link'=>$link, 'unreleased'=> true))
//					->send();
//                $this->Session->setFlash("Votre demande de dépublication a bien été transmise. Celle-ci sera traitée très rapidement.", 'notif');
//                $this->redirect($this->referer());              
//            }else{
//                $this->Session->setFlash("Votre demande de dépublication a déjà été transmise", 'notif', array('type' => 'error'));
//                $this->redirect($this->referer());     
//            }
//        $this->set(compact($resultat));
//        }
//    }
    
    public function delete($quizId = null) {
        if ($this->Quiz->delete($quizId, true)) {
            $this->Session->setFlash("Quiz définitivement supprimé", 'notif');
        } else {
            $this->Session->setFlash("Un problème est survenu. Veuillez réessayer. Si le problème persiste, vous pouvez contacter l'administrateur du site à contact@zeschool.com", 'notif', array('type' => 'error'));
        }

        $this->redirect(array('controller' => 'quiz', 'action' => 'manager'));
    }
    
     public function admin_manager($isPublished = "unpublished", $enAttente = null){

            if($enAttente == "enattente"){
                $condition = "Quiz.validation = 1";
            }else{
                $condition = "Quiz.validation = 0";
            }

            if($isPublished == "published"){
                $condition .= " AND Quiz.published = 1";
            }elseif($isPublished == "unpublished"){
                $condition .= " AND Quiz.published = 0";
            }

            $q = $this->Quiz->find('all', array(
                "fields" => "Quiz.slug, Quiz.name, Quiz.id, Quiz.validation, Quiz.published, Quiz.token",
                "conditions" => "$condition ORDER BY Quiz.created DESC",
                "contain" => array(
                    "Theme" => array(
                        "fields" => array('Theme.name')
                    ),
                    "User" => array(
                        "fields" => array("User.username, User.id")
                    )
                )
            ));

            $this->set(compact('q'));   
        }
    
}