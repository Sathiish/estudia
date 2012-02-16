<?php
App::uses('AppController', 'Controller');
/**
 * Ressources Controller
 *
 * @property Ressource $Ressource
 */
class CoursController extends AppController {
              
        function beforeFilter() {
            parent::beforeFilter();
            $this->Auth->allow('index');
        }
        
        public $helpers = array('Autocomplete');
        
	/**
	 * Liste des matières
	 */
	function index()
	{

	}
 
        /**
	 * Liste une ressource et tous ses enfants à partir d'un slug
	 */
	function view($themeId,$slug = null)
	{    
            $cours = $this->Cour->find('all',array(
                "fields" => "Cour.slug, Cour.name, Cour.id",
                "conditions" => "Cour.theme_id = $themeId AND Cour.public = 1",
                "contain" => array()
                    ));

            $this->set(compact('cours'));
	}
        
        function show($coursId, $slug = null){
            $c = $this->Cour->find('first', array(
                "conditions" => "Cour.id = $coursId AND Cour.public = 1",
                "contain" => array(
                    "User" => array(
                        "fields" => array("User.id, User.username")
                    ),
                    "Partie" => array(
                        "fields" => array('Partie.id, Partie.slug, Partie.name, Partie.sort_order, Partie.public'),
                        "conditions" => array("Partie.public = 1"),
                        "SousPartie" => array(
                            "fields" => array('SousPartie.id, SousPartie.slug, SousPartie.name, SousPartie.sort_order, SousPartie.public'),
                            "conditions" => array("SousPartie.public = 1"),
                        )
                    )
                )
            ));
            
            if(!$c){
                $this->Session->setFlash("Contenu inaccessible", 'notif', array('type' => 'error'));
                $this->redirect($this->referer());
                die();
            }
            
            $this->set(compact('c'));
        }
        
        function manager(){
            
            $userId = $this->Auth->user('id');
            
            $cours = $this->Cour->find('all',array(
                "fields" => "Cour.slug, Cour.name, Cour.id, Cour.validation, Cour.public",
                "conditions" => "Cour.user_id = $userId ORDER BY created DESC",
                "contain" => array(
                    "Theme" => array(
                        "fields" => array('Theme.name')
                    )
                )
            ));

            $this->set(compact('cours'));
        }
        
        public function tag($tagId, $themeId){
            $cours = $this->Cour->CourTag->find('all',array(
                "conditions" => "CourTag.tag_id = $tagId AND CourTag.theme_id = $themeId",
                "fields" => "CourTag.cour_id",
                "contain" => array(
                    "Cour" => array(
                       "fields" => "Cour.slug, Cour.name, Cour.id, Cour.validation, Cour.public"
                    )
                )
            ));
            
            $tag = $this->Cour->CourTag->Tag->find('first', array(
                "conditions" => "Tag.id = $tagId",
                "fields" => "Tag.id, Tag.name, Tag.slug",
                "contain" => array()
            ));
            
            $theme = $this->Cour->Theme->find('first', array(
                "conditions" => "Theme.id = $themeId",
                "fields" => "Theme.id, Theme.name, Theme.slug",
                "contain" => array(
                    "Matiere" => array(
                        "fields" => array("Matiere.id, Matiere.name, Matiere.slug")
                    )
                )
            ));

            $this->set(compact('cours', 'tag', 'theme'));
            
        }
        
        /*
         * Permet de créer ou de modifier un cours
         */
        function edit($coursId = null){
            
            if($coursId != null){
                $this->_checkAuthorization($coursId);
            }
                        
            if($this->request->is('post') || $this->request->is('put')) {
                $userId = $this->Auth->user('id');

                $d = $this->Cour->set($this->data);
                $d['Cour']['user_id'] = $userId;
                $d['Cour']['tags'] = "";

                //On crée la matière si celle-ci n'existe pas
                if($d['Cour']['matiere_id'] == ""){
                    $d['Matiere']['id'] = null;
                    $this->loadModel('Matiere');
                    $ok = $this->Matiere->save($d['Matiere']);
                    if($ok) $d['Cour']['matiere_id'] = $this->Matiere->id;
                }

                //On crée le thème si celui-ci n'existe pas
                if(isset($d['Cour']['theme_id']) && empty($d['Cour']['theme_id'])){
                    $d['Theme']['id'] = null;

                    $d['Theme']['matiere_id'] =  $d['Cour']['matiere_id'];

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
                    //On met à jour les tags au cas où
                    $this->Cour->CourTag->updateAll(
                            array('CourTag.theme_id' => $d['Cour']['theme_id'], 'CourTag.matiere_id' => $d['Cour']['matiere_id']),
                            array('CourTag.cour_id' => $this->Cour->id)
                    );
                    if($coursId != null){
                        $this->Session->setFlash("Votre cours a été mis à jour", 'notif');
                        $this->redirect($this->referer());
                    }else{
                        $this->Session->setFlash("Votre cours a bien été crée. Vous pouvez commencer à créer ses parties.", 'notif');
                        $this->redirect("/parties/manager/".$this->Cour->id);
                    }

                }else{
                    $this->Session->setFlash("Un problème est survenu pendant la création de votre cours. Veuillez réessayer.", 'notif', array('type' => 'error'));
                    $this->redirect($this->referer());
                }

            }else{
                if($coursId != null){
                    $this->data = $this->Cour->find('first', array(
                        "conditions" => "Cour.id = $coursId",
                        "fields" => 'Cour.id, Cour.name, Cour.slug, Cour.theme_id, Cour.contenu',
                        "contain" => array(
                            "Theme" => array(
                                "fields" => array("Theme.id, Theme.name"),
                                "Matiere" => array(
                                    "fields" => array("Matiere.id, Matiere.name")
                                )
                            )
                        )
                    ));
                 
                 $userId = $this->Auth->user('id');
                 $parties = $this->Cour->Partie->find('all',array(
                    "fields" => "Partie.slug, Partie.name, Partie.id, Partie.validation, Partie.public, Partie.sort_order",
                    "conditions" => "Partie.cour_id = $coursId AND Partie.user_id = $userId ORDER BY sort_order ASC",
                    "contain" => array(
                        "SousPartie" => array(
                            "fields" => array('SousPartie.name')
                        )
                    )
                ));
                
                $relatedTags = $this->Cour->Tag->findRelated("Cour",$coursId);
                $this->set(compact('parties', 'relatedTags'));
                                
                }else{
                    $this->request->data['Cour']['id'] = null;
                }
            }
 
            $matieres = $this->Cour->Theme->Matiere->getAllMatieres() + array("" => "Autre");
            $this->set(compact('matieres'));
        }
        
        public function visualiser($coursId){
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
        }
        
        
        function selectbox(){
            $this->layout = null;

            if($this->request->is('post') || $this->request->is('put')){
                $matiereId = $this->data['matieres'];
                $themes = $this->Cour->Theme->find('list', array(
                    "fields" => "id, name",
                    "conditions" => "Theme.matiere_id = $matiereId"
                ));

                $this->set(compact('themes'));
            }
            
        }
        
        public function delete($coursId){
            if ($this->Cour->delete($coursId, true)) {
                $this->Session->setFlash("Cour définitivement supprimé", 'notif');
            } else {
                $this->Session->setFlash("Un problème est survenu. Veuillez réessayer. Si le problème persiste, vous pouvez contacter l'administrateur du site à contact@zeschool.com", 'notif', array('type' => 'error'));
            }

            $this->redirect(array('controller' => 'cours', 'action' => 'manager'));
        }
        
        public function admin_manager($isPublic, $enAttente = null){

            if($enAttente == "enattente"){
                $condition = "Cour.validation = 1";
            }else{
                $condition = "Cour.validation = 0";
            }

            if($isPublic == "public"){
                $condition .= " AND Cour.public = 1";
            }elseif($isPublic == "nonpublic"){
                $condition .= " AND Cour.public = 0";
            }

            $cours = $this->Cour->find('all', array(
                "fields" => "Cour.slug, Cour.name, Cour.id, Cour.validation, Cour.public",
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
        
        public function admin_visualiser($coursId){
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

        public function admin_edit($coursId = null){
                                    
            if($this->request->is('post') || $this->request->is('put')) {

                $d = $this->Cour->set($this->data);

                //On crée la matière si celle-ci n'existe pas
                if($d['Cour']['matiere_id'] == ""){
                    $d['Matiere']['id'] = null;
                    $this->loadModel('Matiere');
                    $ok = $this->Matiere->save($d['Matiere']);
                    if($ok) $d['Cour']['matiere_id'] = $this->Matiere->id;
                }

                //On crée le thème si celui-ci n'existe pas
                if($d['Cour']['theme_id'] == ""){
                    $d['Theme']['id'] = null;

                    $d['Theme']['matiere_id'] =  $d['Cour']['matiere_id'];

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
                    $this->Session->setFlash("Votre cours a bien été crée. Vous pouvez commencer à créer ses parties.", 'notif');
                    $this->redirect("/parties/manager/".$this->Cour->id);
                }else{
                    $this->Session->setFlash("Un problème est survenu pendant la création de votre cours. Veuillez réessayer.", 'notif', array('type' => 'error'));
                    $this->redirect($this->referer());
                }

            }else{
                if($coursId != null){
                    $this->data = $this->Cour->find('first', array(
                        "conditions" => "Cour.id = $coursId",
                        "fields" => 'Cour.id, Cour.name, Cour.slug, Cour.theme_id, Cour.contenu',
                        "contain" => array(
                            "Theme" => array(
                                "fields" => array("Theme.id, Theme.name"),
                                "Matiere" => array(
                                    "fields" => array("Matiere.id, Matiere.name")
                                )
                            )
                        )
                    ));
                 
                 $parties = $this->Cour->Partie->find('all',array(
                    "fields" => "Partie.slug, Partie.name, Partie.id, Partie.validation, Partie.public, Partie.sort_order",
                    "conditions" => "Partie.cour_id = $coursId ORDER BY sort_order ASC",
                    "contain" => array(
                        "SousPartie" => array(
                            "fields" => array('SousPartie.name')
                        )
                    )
                ));
                 
                  $this->set(compact('parties'));
                                
                }
            }
 
            $matieres = $this->Cour->Theme->Matiere->getAllMatieres() + array("" => "Autre");
            $this->set(compact('matieres'));
            $this->render('edit');
        }
}