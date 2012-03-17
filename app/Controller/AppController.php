<?php

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @package       cake
 * @subpackage    cake.app
 */
class AppController extends Controller {

/**
 * Composants utilises dans tous les controleurs
 *
 * @var array
 */
	public $components = array('Session', 'Cookie', 'DebugKit.Toolbar', 'RequestHandler',
                                    'Auth' => array(
                                        'authenticate' => array(
                                                'Form' => array(
                                                        'scope' => array('User.active' => 1)  
                                                )
                                        )
                                ));
                
        public function beforeFilter(){
            if($this->RequestHandler->isAjax()){
                Configure::write('debug', 0);
                $this->layout = null;
                
            }
            $this->Auth->allow('code', 'mliste', 'selectbox', 'recommander');
            $this->Auth->loginAction = array('controller'=>'pages', 'action'=>'display', 'tuto'=>false, 'admin'=>false);
            $this->Auth->authError = 'Créer un compte ou connectez-vous pour accéder à cette page';
            $this->Auth->Redirect($this->referer());
        }
        
        protected function _array_change_key($array, $oldKey, $newKey) {
            static $arrayKeys, $arrayValues;

            if (!array_key_exists($oldKey, $array)){
                return $array;
            }

            ksort($array);

            if (!isSet($arrayKeys)) {
                $arrayKeys   = array_keys($array);
                $arrayValues = array_values($array);
            }

            if($oldKey < $newKey){
                $kkey = $oldKey;
                $oldKey = $newKey;
                $newKey = $kkey;
            }

            $arrayKeys[array_search($oldKey, $arrayKeys)] = $newKey;
            $arrayKeys[array_search($newKey, $arrayKeys)] = $oldKey;

            return array_combine($arrayKeys, $arrayValues);
        }
        
        protected function _checkAuthorization($id){

            $userId = $this->Auth->user('id');           
            $info = $this->{$this->modelClass}->isAuthorized($id, $userId);
            $model = $this->{$this->modelClass}->name;
            
            if($info[$model]['user_id'] != $userId){
                $this->Session->setFlash("Vous n'êtes pas authorisé à accéder à cette page car vous n'êtes pas l'auteur", 'notif', array('type' => 'error'));
                $this->redirect($this->referer());
                die();
            }

            if($info[$model]['published'] == 1){
                $this->Session->setFlash("Vous n'êtes pas authorisé à accéder à cette page car son contenu est protégé contre les modifications", 'notif', array('type' => 'error'));
                $this->redirect($this->referer());
                die();
            }

        }
        
        /*
         * Permet de prévisualiser un contenu en mode édition
         */
        protected function _visualiser($id, $contain){
            $userId = $this->Auth->user('id'); 
            $p = $this->{$this->modelClass}->find('first', array(
                "conditions" => "{$this->modelClass}.id = $id AND {$this->modelClass}.user_id = $userId",
                "contain" => $contain
            ));
            
            $this->set(compact('p'));            
        }
        
        public function publier($id, $publish = "publish", $tken = null){

            $this->loadModel('SousPartie');
            $userId = $this->Auth->user('id'); 
            $model = $this->{$this->modelClass}->name;
            
            $p = $this->{$this->modelClass}->find('first', array(
                "conditions" => "{$this->modelClass}.id = $id",
                "contain" => array(
                    "User" => array(
                        "fields" => array("User.id, User.username, User.email")
                    )
                )
            ));

            if(!$p){
                $this->Session->setFlash("Contenu introuvable", 'notif', array('type' => 'error'));
                $this->redirect($this->referer()); 
            }else{
                if(!$p[$model]['validation']){
                    $token = $this->_generateToken();
                    $this->{$this->modelClass}->id = $id;
            
                    $d[$model]['id'] = $this->{$this->modelClass}->id; 
                    $d[$model]['validation'] = 1;
                    $d[$model]['token'] = $token;                
                    $this->_saveDemande($d, $model, $p);
                }               
                else{
                    if($tken != null){
                        $this->{$this->modelClass}->id = $id;
            
                        $d[$model]['id'] = $this->{$this->modelClass}->id;
                        if(isset($publish) && $publish == "publish"){
                             $d[$model]['published'] = 1;
                             
                        }elseif(isset($publish) && $publish == "unpublish"){
                             $d[$model]['published'] = 0;
                        }
                       
                        $d[$model]['validation'] = 0;
                        $d[$model]['token'] = 0;
            
                        $this->_savePublication($d, $model, $p);
                        
                       
                    }else{
                        $this->Session->setFlash("Votre demande de publication a déjà été transmise", 'notif');
                        $this->redirect($this->referer());     
                    }   
                }
            }
        }
        
        protected function _saveDemande($d, $model, $p){       

            $whiteList = array('validation','token');

            if($this->{$this->modelClass}->save($d,true,$whiteList)){ 
//                $link = array('controller'=>"$this->alias",'action'=>'released', $d[$model]['token']);
//                                App::uses('CakeEmail','Network/Email'); 
//                                $mail = new CakeEmail(); 
//                                $mail->from('noreply@zeschool.com')
//                                        ->to('contact@zeschool.com')
//                                        ->subject("Attente de publication")
//                                        ->emailFormat('html')
//                                        ->template('askforreleased2')
//                                        ->viewVars(array('p'=>$p,'link'=>$link))
//                                        ->send();
                $this->Session->setFlash("Votre demande de validation a bien été transmise. Celle-ci sera traitée très rapidement.", 'notif');
                $this->redirect($this->referer());   
            }else{
                $this->Session->setFlash("La demande de publication n'a pas été transmise. Un problème est survenu. Veuillez envoyer votre demande à contact@zeschool.com directement.", 'notif', array('type' => 'error'));
                $this->redirect($this->referer());  
            }
        }
        
        protected function _savePublication($d, $model, $p){     
      
            if($this->{$this->modelClass}->save($d,true,array('validation','published','token'))){
                $ToPublish = ($d[$model]['published'] == 1)? true : false;
                $this->{$this->modelClass}->updateCounter($ToPublish);
                
                //On met à jour les count dans la table CourTag et QuizTag
                $typeTag = $this->modelClass."Tag";
                $cible = $this->modelKey;

                $this->{$this->modelClass}->$typeTag->updateAll(    
                        array("$typeTag.published" => $d[$model]['published']),
                        array($typeTag.".".$cible."_id" => $d[$model]['id'])
                );
                
                //Puis on met à jour les count dans la table Tag
                $this->{$this->modelClass}->$typeTag->Tag->updatecount();
                        
//                App::uses('CakeEmail','Network/Email'); 
//                $mail = new CakeEmail();
//                $mail->from('contact@zeschool.com')
//                        ->to($p['User']['email'])
//                        ->subject('Votre demande de publication a été validée')
//                        ->emailFormat('html')
//                        ->template('released')
//                        ->viewVars(array('username'=>$p['User']['username']))
//                        ->send();
                $this->Session->setFlash("Ce $this->name a été mis en ligne", 'notif');
                $this->redirect($this->referer());  
            }else{
                $this->Session->setFlash("Ce $this->name n'a pas été correctement mis en ligne", 'notif', array('type' => 'error'));
               // $this->redirect($this->referer());  
            }
        }
        
        /*
         * Permet de générer une chaine de caractère aléatoire en spécifiant la longueur de la chaine
         */
        protected function _generateToken($length = 10) {
            $possible = '0123456789abcdefghijklmnopqrstuvwxyz';
            $token = "";
            $i = 0;

            while ($i < $length) {
                    $char = substr($possible, mt_rand(0, strlen($possible) - 1), 1);
                    if (!stristr($token, $char)) {
                            $token .= $char;
                            $i++;
                    }
            }
            return $token;
    }  
    
    /*
     * Méthode utiliser pour l'autocomplétion des niveaux
     */
    public function autocomplete() { 
        if ($this->RequestHandler->isAjax() && $this->RequestHandler->isPost()) { 
            $fields = explode(",",$this->params['data']['fields']);
            $query = explode(",",$this->params['data']['query']);
            $query = $query[sizeof($query)-1];
            //debug($query);die();
            //$results = $this->{$this->modelClass}->{$this->params['data']['model']}->find('all', $this->params['data']['search'].' LIKE '.$this->params['data']['query'].'%\'',$fields,$this->params['data']['search'].' ASC',$this->params['data']['numresult']);  

            $results = $this->{$this->modelClass}->{$this->params['data']['model']}->find('all', array(
            "conditions" => $this->params['data']['search'].' LIKE \''.$query.'%\' ORDER BY '.$this->params['data']['search'].' ASC',
            "fields" => $fields
            )
                );
            
            
            if($this->params['controller'] == "cours"){
                $controller = "courtags";
            }elseif($this->params['controller'] == "quiz"){
                $controller = "quiztags";
            }
            $this->set('results',$results); 
            $this->set('fields',$fields); 
            $this->set('model',$this->params['data']['model']); 
            $this->set('input_id',$this->params['data']['rand']); 
            $this->set('search',$this->params['data']['search']);
            
            if($this->modelClass == "Message"){
                $this->render('/Messages/destinataire'); 
            }else{              
                $this->set('controller', $controller); 
                $this->render('/common/autocomplete');    
            }
        } 
    } 
    
    /*
     * Methode qui permet de noter un contenu
     */
    public function note($id, $note){
        if(!$this->Auth->user('id')){
            die();
        }
        
        $user_id = $this->Auth->user('id');
        $model = $this->modelClass;
        $table = $model.'Note';
        $field = strtolower($model.'_id');
        
        $alreadyVoted = $this->$model->$table->find('first', array(
            "conditions" => "$table.user_id = $user_id AND $table.$field = $id",
            "fields" => "$table.note",
            "contain" => array()
        ));
        
        if($alreadyVoted){
            $note = $alreadyVoted[$table]['note'];
            $this->$model->id = $id;
            $moyenne = $this->$model->field('moyenne');
        }else{
            $d[$table]['user_id'] = $user_id;
            $d[$table][$field] = $id;
            $d[$table]['note'] = $note;
            
            $this->$model->$table->save($d);
            
            //On met à jour la moyenne
            $cible = strtolower($model.'_notes');
            $moyenne = $this->{$this->modelClass}->Query("SELECT AVG(note) as note FROM $cible WHERE $cible.$field = $id");
            $moyenne = $moyenne[0][0]['note'];
            $this->{$this->modelClass}->updateRatingAverage($id,$moyenne);

            
        }
        $this->set(compact('note', 'moyenne'));
        
    }
    
    /*
     * Gère la redirection des code web sur zeschool.com/code
     */
    public function code($code = null){
        
        if($this->request->is('post') || $this->request->is('put')){
                $code = $this->data['Cour']['code'];
        }
            
        if($code != null){
            $link = $this->Cour->find('first', array(
                "conditions" => 'Cour.raccourci = "'.$code.'" AND Cour.published = 1',
                "fields" => "Cour.id, Cour.slug",
                "contain" => array()
            ));
                        
            if(empty($link)){
                $this->loadModel('Quiz');
                $link = $this->Quiz->find('first', array(
                    "conditions" => 'Quiz.raccourci = "'.$code.'" AND Quiz.published = 1',
                    "fields" => "Quiz.id, Quiz.slug",
                    "contain" => array()
                ));
                
                if(!empty($link)){
                    $target['id'] = $link['Quiz']['id'];
                    $target['slug'] = $link['Quiz']['slug'];

                    $redirect = array('controller' => 'quiz', 'action'=> 'start', $target['id'], $target['slug']);
                    $this->redirect($redirect);
                }
            }else{
                $target['id'] = $link['Cour']['id'];
                $target['slug'] = $link['Cour']['slug'];
                $target['controller'] = 'Cour';
                
                $redirect = array('controller' => 'cours', 'action'=> 'show', $target['id'], $target['slug']);
                $this->redirect($redirect);
            }
            
            if(empty($link)){
                $this->Session->setFlash('Cours ou exercice introuvable. Vérifier bien le code saisi', 'notif', array('type' => 'error'));
                $this->redirect(array('controller' => 'cours', 'action' => 'code'));
                die();
            }   
        }
        
        $this->render('/common/code');
              
    }
    
    /*
     * Méthode qui permet d'envoyer par mail le lien d'un contenu
     */
    public function recommander(){
        if($this->request->is('post') || $this->request->is('put')) {
            $this->loadModel('Recommandation');
            $d = $this->Recommandation->set($this->data);

            if($this->Auth->user('id')){
                $d['Recommandation']['user_id'] = $this->Auth->user('id');
                $d['Recommandation']['username'] = '('.$this->Auth->user('username').') ';
                $d['Recommandation']['email'] = $this->Auth->user('email');    
            }else{
                $d['Recommandation']['user_id'] = null;
                $d['Recommandation']['username'] = '';
                $d['Recommandation']['email'] = 'contact@zeschool.com';
            }

            $type = strtolower($this->modelClass);
            $d['Recommandation']['type'] = $type;
            $d['Recommandation'][$type.'_id'] = $d['Recommandation']['id'];
            $d['Recommandation']['id'] = null;

            $this->Recommandation->save($d, array(
                    'validate' => false,
                    'fieldList' => array(),
                    'callbacks' => false
                )
            );
            
            $username = $d['Recommandation']['username'];
            $from = $d['Recommandation']['email'];
            App::uses('CakeEmail','Network/Email'); 
                $mail = new CakeEmail();
                $mail->from("$from")
                        ->to($d['Recommandation']['sendEmail'])
                        ->subject("Un ami $username vous recommande un lien sur ZeSchool")
                        ->emailFormat('html')
                        ->template('recommandation')
                        ->viewVars(array('username'=>$username,'url'=>$d['Recommandation']['url'],'name'=>$d['Recommandation']['name'] ))
                        ->send();

        }
    }
    
    public function favoris($id){
        if(!$this->Auth->user('id')){
            die();
        }
        
        $user_id = $this->Auth->user('id');
        $model = $this->modelClass;
        $table = $model.'Favori';
        $field = strtolower($model.'_id');
        
        $alreadyFavoris = $this->$model->$table->find('first', array(
            "conditions" => "$table.user_id = $user_id AND $table.$field = $id",
            "fields" => "$table.id",
            "contain" => array()
        ));
        
        if($alreadyFavoris){
           $this->$model->$table->delete($alreadyFavoris[$table]['id']);
           $message = "Cette page a bien été supprimée de vos favoris";
        }else{
            $d[$table]['user_id'] = $user_id;
            $d[$table][$field] = $id;
            $this->$model->$table->save($d);
            
            $message = "Cette page a bien été ajoutée de vos favoris";
        }
        
        $this->set(compact('message'));

    }
    
    protected function _isAdmin(){
        if(!($this->Auth->user('role')) || $this->Auth->user('role') != "admin"){
            $this->Session->setFlash('Seul les administrateurs peuvent accéder à cette partie du site', 'notif', array('type' => 'error'));
            $this->redirect($this->referer());
            die();
        }
    }
        
}
