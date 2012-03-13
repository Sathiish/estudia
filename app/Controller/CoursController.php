<?php
App::uses('AppController', 'Controller');
/**
 * Cours Controller
 *
 */
class CoursController extends AppController {
              
        function beforeFilter() {
            parent::beforeFilter();
            $this->Auth->allow('index', 'theme', 'show', 'view');
        }
                
        public $helpers = array('Autocomplete', 'Tinymce');
        
 
        /**
	 * Liste un cours et tous ses enfants à partir d'un slug
	 */
	function view($themeId,$slug = null){    
            $cours = $this->Cour->find('all',array(
                "fields" => "Cour.slug, Cour.name, Cour.id, Cour.user_id, Cour.count, Cour.moyenne",
                "conditions" => "Cour.theme_id = $themeId AND Cour.published = 1",
                "contain" => array(
                    'User' => array(
                        "fields" => "User.username, User.slug"
                    )
                )
            ));

            $path = $this->Cour->Theme->findPath($themeId);
            $this->set(compact('cours', 'path'));
	}
	
        public function theme($matiereId, $slug = null){    
            $cours = $this->Cour->Theme->find('all',array(
                "fields" => "Theme.slug, Theme.name, Theme.id, Theme.count_published_cours",
                "conditions" => "Theme.matiere_id = $matiereId AND Theme.count_published_cours > 0",
                "contain" => array()
                    ));

            $this->loadModel('Matiere');
            $matiere = $this->Matiere->find('first', array(
                'conditions' => "Matiere.id = $matiereId", 
                'contain' => array(),
                'fields' => 'Matiere.id, Matiere.slug, Matiere.name'
            ));
            
            $this->set(compact('cours', 'matiere'));
	}
        
        public function show($coursId, $slug = null){
            if($this->Auth->user('id')){
                $user_id = $this->Auth->user('id');
            }else{
                $user_id = 0;
            }
            
            $c = $this->Cour->find('first', array(
                "conditions" => "Cour.id = $coursId AND Cour.published = 1",
                "fields" => array("Cour.id, Cour.slug, Cour.name, Cour.contenu, Cour.theme_id, Cour.created, Cour.moyenne, Cour.raccourci, Cour.meta_description, Cour.meta_keywords"),
                "contain" => array(
                    "User" => array(
                        "fields" => array("User.id, User.username")
                    ),
                    "Partie" => array(
                        "fields" => array('Partie.id, Partie.slug, Partie.name, Partie.sort_order, Partie.contenu, Partie.published'),
//                        "conditions" => array("Partie.published = 1"),
                        "SousPartie" => array(
                            "fields" => array('SousPartie.id, SousPartie.slug, SousPartie.name, SousPartie.sort_order, SousPartie.contenu, SousPartie.published')
//                            ,"conditions" => array("SousPartie.published = 1"),
                        )
                    ),
                    "CourNote" => array(
                        "fields" => array("CourNote.note"),
                        "conditions" => "CourNote.cour_id = $coursId AND CourNote.user_id = $user_id",
                        "limit" => 1
                    ),
                    "CourFavori" => array(
                        "fields" => array("CourFavori.id"),
                        "conditions" => "CourFavori.cour_id = $coursId AND CourFavori.user_id = $user_id",
                        "limit" => 1
                    )
                )
            ));
            
            if(!$c){
                $this->Session->setFlash("Contenu inaccessible", 'notif', array('type' => 'error'));
                $this->redirect($this->referer());
                die();
            }else{
                $this->Cour->id = $c['Cour']['id'];
                $this->Cour->incrementField('count');
                $theme_id = $c['Cour']['theme_id'];
                $coursRelated = $this->Cour->find('all',array(
                    "conditions" => "Cour.theme_id = $theme_id AND Cour.id != $coursId",
                    "fields" => "Cour.id, Cour.name, Cour.slug",
                    "order" => "Cour.moyenne DESC",
                    "limit" => 3
                ));
                
                $this->loadModel('Quiz');
                $quizRelated = $this->Quiz->find('all',array(
                    "conditions" => "Quiz.theme_id = $theme_id",
                    "fields" => "Quiz.id, Quiz.name, Quiz.slug",
                    "order" => "Quiz.moyenne DESC",
                    "limit" => 3
                ));
                
                $path = $this->Cour->Theme->findPath($theme_id);
                $this->set(compact('c', 'path', 'coursRelated'));
                $this->set('title_for_layout', $c['Cour']['name']);
                $this->set('meta_description', $c['Cour']['meta_description']);
                $this->set('meta_keywords', $c['Cour']['meta_keywords']);
            }
  
        }
        
        function manager(){
            
            $userId = $this->Auth->user('id');
            
            $cours = $this->Cour->find('all',array(
                "fields" => "Cour.slug, Cour.name, Cour.id, Cour.validation, Cour.published",
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
                       "fields" => "Cour.slug, Cour.name, Cour.id, Cour.validation, Cour.published"
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
            }else{
                $matieres = $this->Cour->Theme->Matiere->getAllMatieres() + array("" => "Autre");
                $classes = $this->Cour->Theme->Classe->find('list', array('contain' => array()));
                $this->set(compact('matieres', 'classes'));
                $this->render('add');
            }
                        
            if($this->request->is('post') || $this->request->is('put')) {
                $userId = $this->Auth->user('id');

                $d = $this->Cour->set($this->data);
                $d['Cour']['user_id'] = $userId;
                $d['Cour']['tags'] = "";
                unset($d['Cour']['tags']);

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
                    //On met à jour les tags au cas où
//                    if(isset($d['Cour']['matiere_id']) && !empty($d['Cour']['matiere_id']) && isset($d['Cour']['theme_id']) && !empty($d['Cour']['theme_id'])){
//                        $this->Cour->CourTag->updateAll(
//                                array('CourTag.theme_id' => $d['Cour']['theme_id'], 'CourTag.matiere_id' => $d['Cour']['matiere_id']),
//                                array('CourTag.cour_id' => $this->Cour->id)
//                        );
//                    }
                    
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
                 
//                 $userId = $this->Auth->user('id');
//                 $parties = $this->Cour->Partie->find('all',array(
//                    "fields" => "Partie.slug, Partie.name, Partie.id, Partie.validation, Partie.published, Partie.sort_order",
//                    "conditions" => "Partie.cour_id = $coursId AND Partie.user_id = $userId ORDER BY sort_order ASC",
//                    "contain" => array(
//                        "SousPartie" => array(
//                            "fields" => array('SousPartie.name')
//                        )
//                    )
//                ));
                
//                $relatedTags = $this->Cour->Tag->findRelated($this->modelClass,$coursId);
//                $this->set(compact('relatedTags'));
                                
                }else{
                    $this->request->data['Cour']['id'] = null;
                }
            }
 
            $classes = $this->Cour->Theme->Classe->find('list', array('contain' => array()));
            $matieres = $this->Cour->Theme->Matiere->getAllMatieres() + array("" => "Autre");
            $this->set(compact('matieres', 'classes'));
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
        
        public function preview($coursId){
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
                                "fields" => array('Partie.id, Partie.slug, Partie.name, Partie.sort_order, Partie.contenu'),
                                "order" => array('Partie.sort_order ASC'),
                                "SousPartie" => array(
                                    "fields" => array('SousPartie.id, SousPartie.slug, SousPartie.name, SousPartie.sort_order, SousPartie.contenu'),
                                    "order" => array('SousPartie.sort_order ASC'),
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
        
        public function admin_visualiser($coursId){
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