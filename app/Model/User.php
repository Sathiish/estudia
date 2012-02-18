<?php
App::uses('AppModel', 'Model');
/**
 * User Model
 *
 * @property  $
 */
class User extends AppModel {
    
        var $hasMany = array(
            'MessageExpediteur' => array(
                'className' => 'Message',
                'foreignKey' => 'expediteur'
            ),
            'MessageDestinataire' => array(
                'className' => 'Message',
                'foreignKey' => 'destinataire'
            )
        );

        public $displayField = 'username';
    
    /**
 * Validation parameters
 *
 * @var array
 */
	public $validate = array(
			'username' => array(
				'required' => array(
					'rule' => array('notEmpty'),
					'required' => true, 'allowEmpty' => false,
					'message' => 'Veuillez entrer un pseudo'),
				'alpha' => array(
					'rule' => array('alphaNumeric'), 
					'message' => 'Le pseudo ne peut contenir que des chiffres et des lettres'),
				'unique_username' => array(
					'rule'=>array('isUnique','username'),
					'message' => 'Ce pseudo est déjà utilisé'),
				'username_min' => array(
					'rule' => array('minLength', '3'),
					'message' => 'Le pseudo doit contenir au moins 3 caractères')),
			'email' => array(
                                'required' => array(
					'rule' => 'notEmpty',
					'message' => 'Veuillez entrer un mot de passe'),
				'isValid' => array(
					'rule' => 'email',
					'required' => true,
					'message' => 'Votre adresse email ne semble pas avoir un format valide'),
				'unique_email' => array(
					'rule' => array('isUnique','email'),
					'message' => 'Cet email est déjà utilisé')),
			'password' => array(
				'required' => array(
					'rule' => 'notEmpty',
					'message' => 'Veuillez entrer un mot de passe'),
                                'to_short' => array(
                                            'rule' => array('minLength', '6'),
                                            'message' => 'Le mot de passe doit contenir au moins 6 caractères')
                            ),
			'temppassword' => array(
				'rule' => 'confirmPassword',
				'message' => 'Vous avez entré deux mots de passe différents'),
			'tos' => array(
				'rule' => array('custom','[1]'),
				'message' => 'Vous devez accepter les conditions d\'utilisation'));


    function beforeSave($options = array()) {

        return true;
    }
    
/**
 * Custom validation method to ensure that the two entered passwords match
 *
 * @param string $password Password
 * @return boolean Success
 */
	public function confirmPassword($password = null) {
            
		if ((isset($this->data[$this->alias]['password']) && isset($password['temppassword']))
			&& !empty($password['temppassword'])
			&& ($this->data[$this->alias]['password'] === $password['temppassword'])) {
			return true;
		}
                $this->_removeExpiredRegistrations();
		return false;
	}

/**
 * Compares the email confirmation
 *
 * @param array $email Email data
 * @return boolean
 */
	public function confirmEmail($email = null) {
		if ((isset($this->data[$this->alias]['email']) && isset($email['confirm_email']))
			&& !empty($email['confirm_email'])
			&& (strtolower($this->data[$this->alias]['email']) === strtolower($email['confirm_email']))) {
				return true;
		}
		return false;
	}


/**
 * Updates the last activity field of a user
 *
 * @param string $user User ID
 * @return boolean True on success
 */
	public function updateLastActivity($userId = null) {
		if (!empty($userId)) {
			$this->id = $userId;
		}
		if ($this->exists()) {
			return $this->saveField('last_action', date('Y-m-d H:i:s', time()));
		}
		return false;
	}


/**
 * Changes the password for a user
 *
 * @param array $postData Post data from controller
 * @return boolean True on success
 */
	public function changePassword($postData = array()) {
		$this->set($postData);
		$this->validate = array(
			'new_password' => $this->validate['password'],
			'confirm_password' => array(
				'required' => array('rule' => array('compareFields', 'new_password', 'confirm_password'), 'required' => true, 'message' => 'Les deux mots de passes saisies ne correspondent pas.')),
			'old_password' => array(
				'to_short' => array('rule' => 'validateOldPassword', 'required' => true, 'message' => 'Mot de passe incorrect')));

		if ($this->validates()) {
			$this->data['User']['password'] = AuthComponent::password($this->data['User']['new_password']);
			$this->save($postData, array(
				'validate' => false,
				'callbacks' => false));
			return true;
		}

		return false;
	}

/**
 * Validation method to check the old password
 *
 * @param array $password 
 * @return boolean True on success
 */
	public function validateOldPassword($password) {
		if (!isset($this->data[$this->alias]['id']) || empty($this->data[$this->alias]['id'])) {
			if (Configure::read('debug') > 0) {
				throw new OutOfBoundsException(__d('users', '$this->data[\'' . $this->alias . '\'][\'id\'] has to be set and not empty'));
			}
		}

		$current_password = $this->field('password', array($this->alias . '.id' => $this->data[$this->alias]['id']));
		return $current_password === Security::hash($password['old_password'], null, true);
	}

/**
 * Validation method to compare two fields
 *
 * @param mixed $field1 Array or string, if array the first key is used as fieldname
 * @param string $field2 Second fieldname
 * @return boolean True on success
 */
	public function compareFields($field1, $field2) {
		if (is_array($field1)) {
			$field1 = key($field1);
		}
		if (isset($this->data[$this->alias][$field1]) && isset($this->data[$this->alias][$field2]) && 
			$this->data[$this->alias][$field1] == $this->data[$this->alias][$field2]) {
			return true;
		}
		return false;
	}

/**
 * Returns all data about a user
 *
 * @param string $slug user slug
 * @return array
 */
	public function view($slug = null) {
		$user = $this->find('first', array(
			'contain' => array(),
			'conditions' => array(
				$this->alias . '.slug' => $slug,
				'OR' => array(
					'AND' =>
						array($this->alias . '.active' => 1, $this->alias . '.email_verified' => 1)))));

		if (empty($user)) {
			throw new Exception(__d('users', 'The user does not exist.'));
		}

		return $user;
	}


/**
 * Generate token used by the user registration system
 *
 * @param int $length Token Length
 * @return string
 */
	public function generateToken($length = 10) {
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


/**
 * Returns the search data
 *
 * @param string $state Find State
 * @param string $query Query options
 * @param string $results Result data
 * @return array
 */
	protected function _findSearch($state, $query, $results = array()) {
		if ($state == 'before') {
			$this->Behaviors->attach('Containable', array('autoFields' => false));
			$results = $query;
			if (!empty($query['by'])) {
				$by = $query['by'];
			}

			if (empty($query['search'])) {
				$query['search'] = '';
			}

			$db =& ConnectionManager::getDataSource($this->useDbConfig);
			$by = $query['by'];
			$search = $query['search'];
			$byQuoted = $db->value($search);
			$like = '%' . $query['search'] . '%';

			switch ($by) {
				case 'username':
					$results['conditions'] = Set::merge(
						$query['conditions'],
						array($this->alias . '.username LIKE' => $like));
					break;
				case 'email':
					$results['conditions'] = Set::merge(
						$query['conditions'],
						array($this->alias . '.email LIKE' => $like));
					break;
				case 'any':
					$results['conditions'] = Set::merge(
						$query['conditions'],
						array('OR' => array(
							array($this->alias . '.username LIKE' => $like),
							array($this->alias . '.email LIKE' => $like))));
					break;
				case '' :
					$results['conditions'] = $query['conditions'];
					break;
				default :
					$results['conditions'] = Set::merge(
						$query['conditions'],
						array($this->alias . '.username LIKE' => $like));
					break;
			}

			if (isset($query['operation']) && $query['operation'] == 'count') {
				$results['fields'] = array('COUNT(DISTINCT ' . $this->alias . '.id)');
			} else {
				//$results['fields'] = array('DISTINCT User.*');
			}
			return $results;
		} elseif ($state == 'after') {
			if (isset($query['operation']) && $query['operation'] == 'count') {
				if (isset($query['group']) && is_array($query['group']) && !empty($query['group'])) {
					return count($results);
				}
				return $results[0][0]['COUNT(DISTINCT ' . $this->alias . '.id)'];
			}
			return $results;
		}
	}

/**
 * Customized paginateCount method
 *
 * @param array $conditions Find conditions
 * @param int $recursive Recursive level
 * @param array $extra Extra options
 * @return array
 */
	function paginateCount($conditions = array(), $recursive = 0, $extra = array()) {
		$parameters = compact('conditions');
		if ($recursive != $this->recursive) {
			$parameters['recursive'] = $recursive;
		}
		if (isset($extra['type']) && isset($this->_findMethods[$extra['type']])) {
			$extra['operation'] = 'count';
			return $this->find($extra['type'], array_merge($parameters, $extra));
		} else {
			return $this->find('count', array_merge($parameters, $extra));
		}
	}

/**
 * Adds a new user
 * 
 * @param array post data, should be Controller->data
 * @return boolean True if the data was saved successfully.
 */
	public function add($postData = null) {
		if (!empty($postData)) {
			$this->create();
			$result = $this->save($postData);
			if ($result) {
				$result[$this->alias][$this->primaryKey] = $this->id;
				$this->data = $result;
				return true;
			}
		}
		return false;
	}

/**
 * Edits an existing user
 *
 * @param string $userId User ID
 * @param array $postData controller post data usually $this->data
 * @return mixed True on successfully save else post data as array
 */
	public function editProfil($userId = null, $postData = null) {
		$user = $this->find('first', array(
			'contain' => array(),
			'conditions' => array($this->alias . '.id' => $userId)
		));

		$this->set($user);
		if (empty($user)) {
			throw new OutOfBoundsException(__d('users', 'Invalid User'));
		}

                $this->validate = array(
			'email' => $this->validate['email'],
			'name' => array(
                            'custom' => array( 
                                'rule' => '!^[[:alpha:][:blank:]- \pL]+$!u', 
                                'message' => 'Votre nom ne peut contenir que des lettres' 
                         )), 
                        'lastname' => array(
                            'lastname' => array(
                                'rule' => '!^[[:alpha:][:blank:]- \pL]+$!u',
                                'message' => 'Votre prénom ne peut contenir que des lettres'
                         ))
                    );

		if (!empty($postData)) {
			$this->set($postData);
			$result = $this->save(null, array(
                            "validate" => true,
                            "callbacks" => false
                        ));
			if ($result) {
				$this->data = $result;
				return true;
			} else {
				return $postData;
			}
		}
	}


/**
 * Removes all users from the user table that are outdated
 *
 * Override it as needed for your specific project
 *
 * @return void
 */
	protected function _removeExpiredRegistrations() {
		$this->deleteAll(array(
			$this->alias . '.email_verified' => 0,
			$this->alias . '.email_token_expiry <' => date('Y-m-d H:i:s')));
	}
}
