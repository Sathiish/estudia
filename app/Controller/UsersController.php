<?php
App::uses('AppController', 'Controller');
/**
 * Users Controller
 *
 * @property User $User
 */
class UsersController extends AppController {

    public $components = array('Img'); 
        
    function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow('inscription', 'activate', 'login', 'add', 'logout', 'index', 'view', 'recover_password');
    }

/**
 * Voir son profil
 *
 * @return void
 */
        public function index($username = null) {
		if(!empty($username)){
                    $user = $this->User->findByUsername($username);
                }
                else{
                   $user = $this->User->read(null, $this->Auth->user('id'));
                }

                $this->set('user', $user);
	}

/**
 * The homepage of a users giving him an overview about everything
 *
 * @return void
 */
	public function dashboard() {
            $user_id = $this->Auth->user('id');
            $favoris = $this->User->CourFavori->find('all', array(
                "conditions" => "CourFavori.user_id = $user_id ORDER BY CourFavori.created DESC",
                "contain" => array(
                    "Cour" => array(
                        "fields" => array("Cour.id, Cour.name, Cour.slug")
                    )
                )
            ));
            
            $this->set('title_for_layout', 'Mon tableau de bord');
            $this->set(compact('favoris'));

	}

/**
 * Shows a users profile
 *
 * @param string $slug User Slug
 * @return void
 */
	public function view($slug = null) {
		try {
			$this->set('user', $this->User->view($slug));
		} catch (Exception $e) {
			$this->Session->setFlash($e->getMessage());
			$this->redirect('/');
		}
	}

/**
 * Edit
 *
 * @param string $id User ID
 * @return void
 */
        public function edit() {
		$this->User->id = $this->Auth->user('id');
		if ($this->request->is('post') || $this->request->is('put')) {
                    
                    if(!empty($this->request->data['User']['file']['name'])){
                        $this->request->data = $this->avatar($this->data); 
                    }
                    unset($this->request->data[$this->modelClass]['file']);

                        if ($this->User->editProfil($this->User->id, $this->data))
                        {
                                //On met à jour les variables de sessions
                                if(!empty($this->request->data['User']['avatar'])){
                                    //On supprime l'ancien avatar si ce n'est pas l'avatar par défaut
                                    if($_SESSION['Auth']['User']['avatar'] != "avatar.png"){
                                        unlink(IMAGES.DS.$_SESSION['Auth']['User']['avatar']);
                                    }
                                    $_SESSION['Auth']['User']['avatar'] = $this->request->data['User']['avatar'];
                                }
                                $_SESSION['Auth']['User']['name'] = $this->request->data['User']['name'];
                                $_SESSION['Auth']['User']['lastname'] = $this->request->data['User']['lastname'];
                                $_SESSION['Auth']['User']['tag_id'] = $this->request->data['User']['tag_id'];
                                
                                $this->loadModel('Tag');
                                $this->Tag->id = $this->Auth->user("tag_id");
                                $_SESSION['Auth']['User']['classe'] = $this->Tag->field('name');
                                
				$this->Session->setFlash('Votre profil a correctement été mis à jour', 'notif');
			} 
                        else {
				$this->Session->setFlash('Un problème est survenue lors de la mise à jour de votre profil. Veuillez réessayer.', 'notif', array('type' => 'error'));
			}
		} else {
                        
			$this->data = $this->User->read(null, $this->Auth->user('id'));
		}
                
                $this->loadModel('Tag');
                $tags = $this->Tag->find('list', array('contain' => array()));
                $this->set(compact('tags'));
	}
        
        
        public function avatar($data){
            if($data['User']['file']['size'] > 5*1024*1024){
                $this->Session->setFlash("Vous ne pouvez pas utiliser une image de plus de 5Mo", 'notif', array('type' => 'error'));
                $this->redirect($this->referer());
            }
            $dir = IMAGES.date('Y');
			if(!file_exists($dir))
				mkdir($dir,0777);
			$dir .= DS.date('m');
			if(!file_exists($dir))
				mkdir($dir,0777);
			$f = explode('.',$data['User']['file']['name']); 
			$ext = '.'.strtolower(end($f));  
			$filename = trim(strtolower(Inflector::slug(implode('.',array_slice($f,0,-1)),'-')));
                        $filename .= substr(md5(uniqid(microtime())),0,5);
			
			$this->request->data['User']['avatar'] = date('Y').'/'.date('m').'/'.$filename.'_s'.$ext;
                        
			if(!empty($this->request->data['User']['avatar'])){
				$original = move_uploaded_file($data['User']['file']['tmp_name'], $dir.DS.$filename.$ext); 
				if($original){
                                    foreach(Configure::read('Media.formats') as $k=>$v){
                                            $prefix = $k;
                                            $size = explode('x',$v);
                                            $this->Img->crop( $dir.DS.$filename.$ext,$dir.DS.$filename.'_'.$prefix.'.jpg',$size[0],$size[1]); 
                                    }
                                //On ne garde que la miniature
                                unlink($dir.DS.$filename.$ext);
                                }else{
                                    $this->Session->setFlash("Un problème est survenu avec le téléchargement de cette photo. Votre profil n'a pas été mis à jour. Si le problème persiste, nous vous conseillons de changer d'image.", 'notif', array('type' => 'error'));
                                    $this->redirect($this->referer());
                                }
			}else{
				$this->Session->setFlash("L'image n'est pas au bon format", 'notif', array('type' => 'error'));
			}
                        
                        return $this->request->data;
        }

/**
 * Admin edit
 *
 * @param string $id User ID
 * @return void
 */
	public function admin_edit($userId = null) {
		try {
			$result = $this->User->edit($userId, $this->data);
			if ($result === true) {
				$this->Session->setFlash(__d('users', 'User saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->data = $result;
			}
		} catch (OutOfBoundsException $e) {
			$this->Session->setFlash($e->getMessage());
			$this->redirect(array('action' => 'index'));
		}

		if (empty($this->data)) {
			$this->data = $this->User->read(null, $userId);
		}
	}

/**
 * Delete a user account
 *
 * @param string $userId User ID
 * @return void
 */
	public function admin_delete($userId = null) {
		if ($this->User->delete($userId)) {
			$this->Session->setFlash(__d('users', 'User deleted', true));
		} else {
			$this->Session->setFlash(__d('users', 'Invalid User', true));
		}

		$this->redirect(array('action' => 'index'));
	}

/**
 * Search for a user
 *
 * @return void
 */
	public function admin_search() {
		$this->search();
	}

/**
 * User action qui permet au User de s'inscrire
 *
 * @return void
 */
        public function inscription(){
		if($this->request->is('post')){
			$d = $this->request->data; 
			
                        $this->User->set($d);
                        if ($this->User->validates()) {
                            $d['User']['id'] = null;
                            if(!empty($d['User']['password'])){
                                    $d['User']['password'] = Security::hash($d['User']['password'],null,true);
                            }
                            $d['User']['username'] = trim(strtolower($d['User']['username']));
                            $d['User']['slug'] = strtolower(Inflector::slug($d['User']['username'], '-'));
                            $d['User']['email_token'] = $this->User->generateToken();
                            $d['User']['email_token_expiry'] = date('Y-m-d H:i:s', time() + 604800);
                            
                            if($this->User->save($d,false,array('username','slug','password','email','email_token','email_token_expiry'))){
				$link = array('controller'=>'users','action'=>'activate', $d['User']['email_token']);
				App::uses('CakeEmail','Network/Email'); 
				$mail = new CakeEmail(); 
				$mail->from('inscription@zeschool.com')
					->to($d['User']['email'])
					->subject('Confirmer votre adresse email')
					->emailFormat('html')
					->template('inscription')
					->viewVars(array('username'=>$d['User']['username'],'link'=>$link))
					->send();
				$this->Session->setFlash("Votre compte a bien été créé. Vous devez maintenant valider votre inscription en cliquant sur le lien qui vous a été envoyé par email. Attention, ce lien ne sera plus accessible dans 7 jours.", 'notif');
				$this->request->data = array();
                                $this->redirect($this->referer());
                            }else{
                                $this->Session->setFlash("Un problème est survenu. Veuillez réessayer", 'notif', array('type' => 'error'));                               
                            }
                            
                        } else {
                            $this->Session->setFlash("Merci de corriger vos erreurs", 'notif', array('type' => 'error'));                           
                        }
		}
	}
        
        public function activate($token){
		$user = $this->User->find('first',array(
			'conditions' => array('email_token' => $token,'email_verified' => 0,'active' => 0, 'email_token_expiry >=' => date('Y-m-d H:i:s'))
		)); 
		if(!empty($user)){
			$this->User->id = $user['User']['id']; 
			$this->User->saveField('active',1);
			$this->User->saveField('email_token',0); 
			$this->User->saveField('email_verified',1); 
			$this->User->saveField('email_token_expiry',0); 
			$this->Session->setFlash("Votre compte a bien été activé. Vous pouvez compléter dès à présent les informations manquantes de votre profil ci-dessous.", 'notif');
			$this->Auth->login($user['User']); 
                        $this->redirect('/users/edit'); 
		}else{
			$this->Session->setFlash("Ce lien d'activation n'est pas valide", 'notif', array('type' => 'error'));
                        $this->redirect('/login');
		}
		die(); 
	}
        
/**
 * login action
 *
 * @return void
 */
	public function login() {
            //On vérifie que l'utilisateur n'est pas déjà connecté
            if($this->Auth->user('id')) {
                $this->Session->setFlash("Vous êtes déjà connecté", 'notif');
                $this->redirect('/users/dashboard');
            }

		if($this->request->is('post')){
			if($this->Auth->login()){
				$this->User->id =  $this->Auth->user("id");
                                $this->_setCookie();
				$this->User->saveField('lastlogin',date('Y-m-d H:i:s'));
                                
                                $this->loadModel('Tag');
                                $this->Tag->id = $this->Auth->user("tag_id");
                                $_SESSION['Auth']['User']['classe'] = $this->Tag->field('name');
                                $this->redirect($this->referer());
			}else{
				$this->Session->setFlash("Identifiants incorrects", 'notif', array('type' => 'error'));
                                $this->redirect($this->referer());
			}
		}

      }

/**
 * Search
 *
 * @return void
 */
	public function search() {
		if (!App::import('Component', 'Search.Prg')) {
			throw new MissingPluginException(array('plugin' => 'Search'));
		}

		$searchTerm = '';
		$this->Prg->commonProcess($this->modelClass, $this->modelClass, 'search', false);

		if (!empty($this->request->params['named']['search'])) {
			$searchTerm = $this->request->params['named']['search'];
			$by = 'any';
		}
		if (!empty($this->request->params['named']['username'])) {
			$searchTerm = $this->request->params['named']['username'];
			$by = 'username';
		}
		if (!empty($this->request->params['named']['email'])) {
			$searchTerm = $this->request->params['named']['email'];
			$by = 'email';
		}
		$this->request->data[$this->modelClass]['search'] = $searchTerm;

		$this->paginate = array(
			'search',
			'limit' => 12,
			'by' => $by,
			'search' => $searchTerm,
			'conditions' => array(
					'AND' => array(
						$this->modelClass . '.active' => 1,
						$this->modelClass . '.email_verified' => 1)));

		$this->set('users', $this->paginate($this->modelClass));
		$this->set('searchTerm', $searchTerm);
	}
        
/**
 * Common logout action
 *
 * @return void
 */
	public function logout() {
		$this->Session->destroy();
		$this->Cookie->destroy();
		$message = "Vous avez été correctement déconnecté";
		$this->Session->setFlash($message, 'notif');
		$this->redirect($this->referer());
	}


/**
 * Allows the user to enter a new password, it needs to be confirmed
 *
 * @return void
 */
	public function change_password() {
                if ($this->request->is('post')) {
			$this->request->data[$this->modelClass]['id'] = $this->Auth->user('id');
			if ($this->User->changePassword($this->request->data)) {
                                $this->Session->setFlash('Votre mot de passe a été changé avec succès', 'notif');
				$this->redirect('/users/edit');
			}
		}
	}
      
        public function recover_password(){
                if ($this->Auth->user()) {
                    $this->Session->setFlash("Vous êtes déjà connecté. Pour changer votre mot de passe, <a href=\"/users/change_password\">cliquez ici</a>", 'notif');
                    $this->redirect('/dashboard');
                }
            
		if(!empty($this->request->params['named']['token'])) {
			$token = $this->request->params['named']['token']; 
			$user = $this->User->find('first',array(
				'conditions' => array('password_token' => $token, 'active' => 1)
			)); 
			if($user){
				$this->User->id = $user['User']['id']; 
				$password = substr(md5(uniqid(rand(),true)),0,8); 
				$this->User->saveField('password',Security::hash($password,null,true));
				$this->Session->setFlash("Votre mot de passe a bien été réinitialisé, votre nouveau mot de passe temporaire est: $password. Nous vous conseillons de le changer immédiatement.", 'notif');
                                $this->User->saveField('password_token', 0);
                                $this->Auth->login($user['User']);
                                $this->redirect('/users/change_password');
			}else{
				$this->Session->setFlash("Ce lien n'est pas ou n'est plus valide");
                                $this->redirect('/inscription');
			}
		} 

		if($this->request->is('post')){
			$v = current($this->request->data); 
			$user = $this->User->find('first',array(
				'conditions' => array('email'=>$v['mail'],'active'=>1)
			));
			if(empty($user)){
				$this->Session->setFlash("Aucun utilisateur ne correspond à cet email", 'notif', array('type' => 'error'));
			}else{
                                $token = $this->User->generateToken();
                                $this->User->id = $user['User']['id'];
                                $this->User->saveField('password_token', $token); 
				App::uses('CakeEmail','Network/Email');
				$link = array('controller'=>'users','action'=>'recover_password','token' => $token);
				$mail = new CakeEmail();
				$mail->from('noreply@zeschool.com')
					->to($user['User']['email'])
					->subject('Récupérer votre mot de passe')
					->emailFormat('html')
					->template('mdp')
					->viewVars(array('username'=>$user['User']['username'],'link'=>$link))
					->send();
                                
                                $this->Session->setFlash("Vous allez recevoir un email pour finaliser votre changement de mot de passe.", 'notif');
                                $this->redirect('/login');
			}
                        
		}
		
	}


/**
 * Sets the cookie to remember the user
 *
 * @param array Cookie component properties as array, like array('domain' => 'yourdomain.com')
 * @param string Cookie data keyname for the userdata, its default is "User". This is set to User and NOT using the model alias to make sure it works with different apps with different user models across different (sub)domains.
 * @return void
 * @link http://api13.cakephp.org/class/cookie-component
 */
	protected function _setCookie($options = array(), $cookieKey = 'User') {
		if (empty($this->request->data[$this->modelClass]['remember_me'])) {
			$this->Cookie->delete($cookieKey);
		} else {
			$validProperties = array('domain', 'key', 'name', 'path', 'secure', 'time');
			$defaults = array(
				'name' => 'rememberMe');

			$options = array_merge($defaults, $options);
			foreach ($options as $key => $value) {
				if (in_array($key, $validProperties)) {
					$this->Cookie->{$key} = $value;
				}
			}

			$cookieData = array(
				'username' => $this->request->data[$this->modelClass]['username'],
				'password' => $this->request->data[$this->modelClass]['password']);
			$this->Cookie->write($cookieKey, $cookieData, true, '1 Month');
		}
		unset($this->request->data[$this->modelClass]['remember_me']);
	}
}