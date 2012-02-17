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
        
        function beforeFilter(){
            if($this->RequestHandler->isAjax()){
                $this->layout= null;
            }
            $this->Auth->loginAction = array('controller'=>'users','action'=>'login','tuto'=>false,'admin'=>false);
            $this->Auth->authError = 'Créer un compte ou connectez-vous pour accéder à cette page';
            $this->Auth->Redirect(array('controller'=>'users', 'action'=>'dashboard'));
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
                $this->Session->setFlash("Vous n'êtes pas authorisé à accéder à cette page car vous n'êtes pas l'auteur");
                $this->redirect($this->referer());
                die();
            }

            if($info[$model]['public'] == 1){
                $this->Session->setFlash("Vous n'êtes pas authorisé à accéder à cette page car son contenu est protégé contre les modifications");
                $this->redirect($this->referer());
                die();
            }

        }
        
        protected function _visualiser($id, $contain){
            $userId = $this->Auth->user('id'); 
            $p = $this->{$this->modelClass}->find('first', array(
                "conditions" => "{$this->modelClass}.id = $id AND {$this->modelClass}.user_id = $userId",
                "contain" => $contain
            ));
            
            $this->set(compact('p'));            
        }
        
        public function publier($id, $tken = null){

            $this->loadModel('SousPartie');
            $userId = $this->Auth->user('id'); 
            $model = $this->{$this->modelClass}->name;
            
            $p = $this->{$this->modelClass}->find('first', array(
                "conditions" => "{$this->modelClass}.id = $id AND {$this->modelClass}.user_id = $userId",
                "contain" => array(
                    "User" => array(
                        "fields" => array("User.id, User.username, User.email")
                    )
                )
            ));

            if(!$p){
                $this->Session->setFlash("Un problème est survenu lors de la validation de votre demande. Veuillez réessayer. Si le problème persiste, contactez nos équipes par mail à contact@zeschool.com");
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
                        $d[$model]['public'] = 1;
                        $d[$model]['validation'] = 0;
                        $d[$model]['token'] = 0;
            
                        $this->_savePublication($d, $model, $p);
                    }else{
                        $this->Session->setFlash("Votre demande de publication a déjà été transmise");
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
                $this->Session->setFlash("Votre demande de validation a bien été transmise. Celle-ci sera traitée très rapidement.");
                $this->redirect($this->referer());   
            }else{
                $this->Session->setFlash("La demande de publication n'a pas été transmise. Un problème est survenu. Veuillez envoyer votre demande à contact@zeschool.com directement.");
                $this->redirect($this->referer());  
            }
        }
        
        protected function _savePublication($d, $model, $p){     
              debug($d);
            if($this->{$this->modelClass}->save($d,true,array('validation','public','token'))){ 
                App::uses('CakeEmail','Network/Email'); 
                $mail = new CakeEmail();
                $mail->from('noreply@zeschool.com')
                        ->to($p['User']['email'])
                        ->subject('Votre demande de publication a été validée')
                        ->emailFormat('html')
                        ->template('released')
                        ->viewVars(array('username'=>$p['User']['username']))
                        ->send();
                $this->Session->setFlash("Publication validée");
                $this->redirect($this->referer());  
            }else{
                $this->Session->setFlash("La demande de publication n'a pas été transmise. Un problème est survenu.");
                $this->redirect($this->referer());  
            }
        }
        
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
    
    public function autocomplete() { 
        if ($this->RequestHandler->isAjax() && $this->RequestHandler->isPost()) { 
            $fields = explode(",",$this->params['data']['fields']); //debug($this->params['data']);die();
            //$results = $this->{$this->modelClass}->{$this->params['data']['model']}->find('all', $this->params['data']['search'].' LIKE '.$this->params['data']['query'].'%\'',$fields,$this->params['data']['search'].' ASC',$this->params['data']['numresult']);  

            $results = $this->{$this->modelClass}->{$this->params['data']['model']}->find('all', array(
            "conditions" => $this->params['data']['search'].' LIKE \''.$this->params['data']['query'].'%\' ORDER BY '.$this->params['data']['search'].' ASC',
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
        
}
