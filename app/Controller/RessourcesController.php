<?php
App::uses('RessourcesAppController', 'Controller');
/**
 * Cours Controller
 *
 */
class RessourcesController extends RessourcesAppController {
              
        function beforeFilter() {
            parent::beforeFilter();
            $this->Auth->allow('*');
        }
                
        public $helpers = array('Autocomplete', 'Tinymce');
        
 
        /**
	 * Liste un cours et tous ses enfants à partir d'un slug
	 */
	public function preview($ressourceId){    
            $r = $this->Ressource->find('first',array(
                //"fields" => "Cour.slug, Cour.name, Cour.id, Cour.user_id, Cour.count, Cour.moyenne",
                "conditions" => "Ressource.id = $ressourceId",
                "contain" => array(
                    'User' => array(
                        "fields" => "User.username, User.slug"
                    )
                )
            ));

            $this->set('filAriane', $this->Ressource->filAriane($ressourceId));
            $this->set(compact('r'));
	}
        
        public function edit($ressourceId){
            if($this->request->is('post') || $this->request->is('put')) {
                $d = $this->Ressource->set($this->data);
                $d['Ressource']['user_id'] = $this->Auth->user('id');
             
                //Vérifier si l'utilisateur est l'auteur du cours
                
                if($this->Ressource->save($d['Ressource'])){
                    if($this->RequestHandler->isAjax()){
                        die();
                    }else{
                        $this->Session->setFlash("Votre cours a bien été mis à jour", 'notif');
                        $this->redirect($this->referer());
                    }
                }else{
                    $this->Session->setFlash("Un problème est survenu pendant la création de votre cours. Veuillez réessayer.", 'notif', array('type' => 'error'));
                }
            }
            
            $this->Ressource->id = $ressourceId;
            $this->data = $this->Ressource->find('first', array(
                'conditions' => "Ressource.id = $ressourceId",
                'contain' => array(
                    'User' => array(
                        'fields' => array('User.id, User.username, User.slug')
                    )
                )
            ));
            $this->set('filAriane', $this->Ressource->filAriane($ressourceId));
            $this->set('types', array('cours' => 'Cours simple', 'fiche' => 'Fiche de révision', 'correction' => 'Exercice corrigé', 'dissertation' => 'Dissertation'));           
            $this->set('difficulty', array('1' => 'Facile', '2' => 'Moyen', '3' => 'Difficile'));           
        }
        
        /*
         * Permet de créer une ressource de type:
         * - cours
         * - fiche de révision
         * - exercice corrigé
         * - dissertation
         */
        public function add(){
            
            if($this->request->is('post') || $this->request->is('put')) {
                $d = $this->Ressource->set($this->data);
                $d['Ressource']['user_id'] = $this->Auth->user('id');
                
                if($d['Ressource']['type'] == "cours-complet"){
                    $d['Cour'] = $d['Ressource'];
                    $this->loadModel('Cour');
                    $this->Cour->save($d['Cour']);
                    $this->Session->setFlash("Votre cours a bien été crée. Vous pouvez commencer à créer ses parties.", 'notif');
                    $this->redirect("/cours/edit/".$this->Cour->id);
                }else{
                    if($this->Ressource->save($d['Ressource'])){
                        if($this->RequestHandler->isAjax()){
                            die();
                        }else{
                            $this->Session->setFlash("Votre ressource a bien été créée", 'notif');
                            $this->redirect("/ressources/edit/".$this->Ressource->id);
                        }
                    }else{
                        $this->Session->setFlash("Un problème est survenu pendant la création de votre cours. Veuillez réessayer.", 'notif', array('type' => 'error'));
                    }
                }
            }
            $this->loadModel('Matiere');
            $this->set('matieres', $this->Matiere->getAllMatieres());
            $this->loadModel('Classe');
            $this->set('classes', $this->Classe->getListClasse());
            $this->set('types', array('cours-complet' => 'Cours structuré', 'cours' => 'Cours simple', 'fiche' => 'Fiche de révision', 'correction' => 'Exercice corrigé', 'dissertation' => 'Dissertation'));
        }  
        
        public function manager(){
            
            $userId = $this->Auth->user('id');
            
            $ressources = $this->Ressource->find('all',array(
                "fields" => "Ressource.slug, Ressource.name, Ressource.id, Ressource.published, Ressource.type",
                "conditions" => "Ressource.user_id = $userId ORDER BY created DESC",
                "contain" => array(
                    "Theme" => array(
                        "fields" => array('Theme.name')
                    )
                )
            ));

            $this->loadModel('Cour');
            $cours = $this->Cour->find('all',array(
                "fields" => "Cour.slug, Cour.name, Cour.id, Cour.validation, Cour.published",
                "conditions" => "Cour.user_id = $userId ORDER BY created DESC",
                "contain" => array(
                    "Theme" => array(
                        "fields" => array('Theme.name')
                    )
                )
            ));

            $this->set(compact('cours', 'ressources'));
        }
                
        /*
         * Permet à l'administrateur de modifier un cours
         */
        public function admin_edit($coursId = null){
            $this->_isAdmin();
            
            if($this->request->is('post') || $this->request->is('put')) {

                $d = $this->Cour->set($this->data);

                //On crée la matière si celle-ci n'existe pas
                if(!empty($d['Matiere']['name']) && $d['Cour']['matiere_id'] == ""){
                    $d['Matiere']['id'] = null;
                    $this->loadModel('Matiere');
                    $ok = $this->Matiere->save($d['Matiere']);
                    if($ok) $d['Cour']['matiere_id'] = $this->Matiere->id;
                }

                //On crée le thème si celui-ci n'existe pas
                if(isset($d['Theme']['name']) && !empty($d['Theme']['name'])){
                    $d['Theme']['id'] = null;

                    $d['Theme']['matiere_id'] = $d['Cour']['matiere_id'];

                    $this->loadModel('Theme');
                    $ok2 = $this->Theme->save($d['Theme']);
                    if($ok2) $d['Cour']['theme_id'] = $this->Theme->id;
                }


                //On modifie ou on crée un nouveau cours ?
                if($coursId != null){
                    $d['Cour']['id'] = $coursId;
                }else{
                    $d['Cour']['id'] = null;
                }

                //On enregistre le cours
                if($this->Cour->save($d['Cour'])){
                    
                    if($this->RequestHandler->isAjax()){
                        die();
                    }else{
                        if($coursId != null){
                            $this->Session->setFlash("Votre cours a été mis à jour", 'notif');
                            $this->redirect($this->referer());
                        }else{
                            $this->Session->setFlash("Votre cours a bien été crée. Vous pouvez commencer à créer ses parties.", 'notif');
                            $this->redirect("/cours/edit/".$this->Cour->id);
                        }   
                    }

                }else{
                    $this->Session->setFlash("Un problème est survenu pendant la création de votre cours. Veuillez réessayer.", 'notif', array('type' => 'error'));
                    $this->redirect($this->referer());
                }

            }else{
                if($coursId != null){
                    $this->data = $this->Cour->find('first', array(
                        "conditions" => "Cour.id = $coursId",
                        "fields" => 'Cour.id, Cour.name, Cour.slug, Cour.theme_id, Cour.contenu, Cour.validation, Cour.published, Cour.difficult, Cour.meta_description, Cour.meta_keywords',
                        "contain" => array(
                            "Theme" => array(
                                "fields" => array("Theme.id, Theme.name"),
                                "Matiere" => array(
                                    "fields" => array("Matiere.id, Matiere.name")
                                ),
                                "Classe" => array(
                                    "fields" => array("Classe.id, Classe.name")
                                )
                            ),
                            "Partie" => array(
                                "fields" => array("Partie.slug, Partie.name, Partie.id, Partie.validation, Partie.contenu, Partie.published, Partie.sort_order"),
                                "order" => "Partie.sort_order ASC",
                                "SousPartie" => array(
                                    "fields" => array('SousPartie.id', 'SousPartie.name', 'SousPartie.slug', 'SousPartie.contenu', 'SousPartie.sort_order'),
                                    "order" => "SousPartie.sort_order ASC"
                                 )
                            )
                        )
                    ));
                                                 
                }else{
                    $this->request->data['Cour']['id'] = null;
                }
            }
 
            $classes = $this->Cour->Theme->Classe->find('list', array('contain' => array()));
            $matieres = $this->Cour->Theme->Matiere->getAllMatieres() + array("" => "Autre");
            $this->set(compact('matieres', 'classes'));
            //$this->render('edit');
        }
                
        function selectbox(){
            $this->layout = null;

            if($this->request->is('post') || $this->request->is('put')){
                $matiereId = $this->data['matieres'];
                $this->loadModel('Theme'); 
                $themes = $this->Theme->find('list', array(
                    "fields" => "id, name",
                    "conditions" => "Theme.matiere_id = $matiereId"
                ));

                $this->set(compact('themes'));
            }
            
        }
        
        public function delete($coursId){
            if ($this->Ressource->delete($coursId)) {
                $this->Session->setFlash("Ressource définitivement supprimée", 'notif');
            } else {
                $this->Session->setFlash("Un problème est survenu. Veuillez réessayer. Si le problème persiste, vous pouvez contacter l'administrateur du site à contact@zeschool.com", 'notif', array('type' => 'error'));
            }

            $this->redirect($this->referer());
        }
        
        public function admin_manager($isPublished = "unpublished", $enAttente = null){
            $this->_isAdmin();
            
            if($enAttente == "enattente"){
                $condition = "Cour.validation = 1";
            }else{
                $condition = "Cour.validation = 0";
            }

            if($isPublished == "published"){
                $condition .= " AND Cour.published = 1";
            }elseif($isPublished == "unpublished"){
                $condition .= " AND Cour.published = 0";
            }

            $cours = $this->Cour->find('all', array(
                "fields" => "Cour.slug, Cour.name, Cour.id, Cour.validation, Cour.published, Cour.token",
                "conditions" => "$condition ORDER BY Cour.created DESC",
                "contain" => array(
                    "Theme" => array(
                        "fields" => array('Theme.name')
                    ),
                    "User" => array(
                        "fields" => array("User.username, User.id")
                    )
                )
            ));

            $this->set(compact('cours'));   
        }
        
        public function admin_preview($ressourceId){
            $this->_isAdmin();
            
            $contain = array("Theme" => array(
                                "fields" => array("Theme.id, Theme.name"),
                                "Matiere" => array(
                                    "fields" => array("Matiere.id, Matiere.name")
                                )
                            ),
                            "User" => array(
                                    "fields" => array("User.id, User.username")
                            ),
                            "Partie" => array(
                                "fields" => array('Partie.id, Partie.slug, Partie.name, Partie.sort_order'),
                                "SousPartie" => array(
                                    "fields" => array('SousPartie.id, SousPartie.slug, SousPartie.name, SousPartie.sort_order')
                                )
                            )
                        );
            
            $this->_visualiser($coursId, $contain);
            $this->render('visualiser');
        }      

}