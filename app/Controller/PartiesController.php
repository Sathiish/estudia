<?php
App::uses('AppController', 'Controller');
/**
 * Ressources Controller
 *
 * @property Ressource $Ressource
 */
class PartiesController extends AppController {
              
        function beforeFilter() {
            parent::beforeFilter();
            $this->Auth->allow('index');
        }
        
	function index()
	{

	}
 
	function show($partieId, $slug = null){    
            $partie = $this->Partie->find('first',array(
                "fields" => "Partie.slug, Partie.name, Partie.id, Partie.contenu",
                "conditions" => "Partie.id = $partieId",
                "contain" => array(
                    "SousPartie" => array(
                        "fields" => "SousPartie.id, SousPartie.name, SousPartie.slug, SousPartie.contenu"
                    )
                )
            ));
            
            if(!$partie){
                $this->Session->setFlash('Action impossible', 'notif', array('type' => 'error'));
                $this->redirect("/cours/manager");
            }
            $this->set(compact('partie'));
	}
        
        public function manager($coursId){
            
            $parties = $this->Partie->find('all', array(
                "fields" => "Partie.id, Partie.name, Partie.slug, Partie.validation, Partie.published, Partie.sort_order",
                "conditions" => "Partie.cour_id = $coursId ORDER BY Partie.sort_order ASC",
                "contain" => array(
                    "Cour" => array(
                        "fields" => array("Cour.name, Cour.slug, Cour.id")
                    )
                )
            ));
            
            $path = $this->Partie->Cour->getPath($coursId);

            $this->set(compact('parties', 'path'));           
        }
        
        public function edit($partieId = null){

            $this->_checkAuthorization($partieId);
            
            if($this->request->is('post') || $this->request->is('put')) {
 
                $d = $this->Partie->set($this->data);
                
                if($partieId == null){
                    $partieId = $d['Partie']['id'];
                }
                
                //On vérifie que l'utilisateur qui essaye d'enregistrer est bien l'auteur
                $auteur = $this->Partie->find('first', array(
                        "conditions" => "Partie.id = $partieId",
                        "fields" => array("Partie.cour_id"),
                        "contain" => array(
                            "Cour" => array(
                                "fields" => array("Cour.user_id")
                            )
                        )
                ));
                
                if($auteur['Cour']['user_id'] != $this->Auth->user('id')){
                    $this->Session->setFlash("Votre n'êtes pas l'auteur de ce cours. Vous ne pouvez donc pas le modifier", 'notif', array('type' => 'error'));
                    $this->redirect("/cours/manager");
                }
            
                $d['Partie']['cour_id'] = $auteur['Partie']['cour_id'];
                                
                if($this->Partie->save($d['Partie'])){
                    if($partieId != null){
                       $this->Session->setFlash("Mise à jour correctement effectué", 'notif');
                        $this->redirect($this->referer()); 
                        //$this->redirect("/parties/manager/".$d['Partie']['cour_id']); 
                    }else{
                        $this->Session->setFlash("Votre cours a bien été crée. Vous pouvez commencer à créer des sous-parties.", 'notif');
                        $this->redirect("/sousparties/manager/".$this->Partie->id);
                    }
                }else{
                    $this->Session->setFlash("Un problème est survenu pendant l'ajout de cette partie. Veuillez réessayer.", 'notif', array('type' => 'error'));
                    $this->redirect($this->referer());
                }

            }else{
                if($partieId != null){
                    $this->data = $this->Partie->find('first', array(
                        "conditions" => "Partie.id = $partieId",
                        "fields" => 'Partie.id, Partie.name, Partie.slug, Partie.contenu, Partie.cour_id',
                        "contain" => array()
                    ));
                }
            }


        }
        
        public function add($coursId){
            if($this->request->is('post') || $this->request->is('put')) {
 
                $d = $this->Partie->set($this->data);
                $d['Partie']['cour_id'] = $coursId;
                $d['Partie']['id'] = null;
                $d['Partie']['user_id'] = $this->Auth->User('id');
                
                $lastPosition = $this->Partie->find('first', array(
                    "fields" => "Partie.sort_order",
                    "conditions" => "Partie.cour_id = $coursId ORDER BY sort_order DESC"
                ));
                
                if(!$lastPosition){
                    $d['Partie']['sort_order'] = 1;
                }
                else{
                    $d['Partie']['sort_order'] = $lastPosition['Partie']['sort_order'] + 1;
                }
                
                if($this->Partie->save($d['Partie'])){
                    $this->Session->setFlash("Mise à jour correctement effectué.");
                    $this->redirect($this->referer());
                }else{
                    $this->Session->setFlash("Un problème est survenu pendant l'ajout de cette partie. Veuillez réessayer.", 'notif', array('type' => 'error'));
                    $this->redirect($this->referer());
                }
                
            }
            
            $path = $this->Partie->Cour->getPath($coursId);

            $this->set(compact('path'));

        }
        
        public function monter($partieId){

            $req = $this->Partie->find('first', array(
               "conditions" => "Partie.id = $partieId",
               "fields" => "Partie.cour_id, Partie.sort_order"
            ));

            $coursId = $req['Partie']['cour_id'];
            $sortOrder = $req['Partie']['sort_order'];

            if($sortOrder <= 1){
                $this->Session->setFlash("Cette partie est déjà la première", 'notif', array('type' => 'error'));
                $this->redirect($this->referer());
                die();
            }

            $newsortOrder = $sortOrder -1;

            $liste = $this->Partie->find('list', array(
               "conditions" => "Partie.cour_id = $coursId AND (Partie.sort_order = $sortOrder OR Partie.sort_order = $newsortOrder)",
               "fields" => "Partie.sort_order, Partie.id"
            ));


            $new = $this->_array_change_key($liste, $sortOrder, $newsortOrder);

            foreach($new as $k=>$v){
                $this->Partie->id =  $v;
                $this->Partie->saveField('sort_order',$k);
            }

            $this->redirect($this->referer());

        }

        public function descendre($partieId){

            $req = $this->Partie->find('first', array(
               "conditions" => "Partie.id = $partieId",
               "fields" => "Partie.cour_id, Partie.sort_order"
            ));

            $coursId = $req['Partie']['cour_id'];
            $sortOrder = $req['Partie']['sort_order'];

            $newsortOrder = $sortOrder +1;

            $liste = $this->Partie->find('list', array(
               "conditions" => "Partie.cour_id = $coursId AND (Partie.sort_order = $sortOrder OR Partie.sort_order = $newsortOrder)",
               "fields" => "Partie.sort_order, Partie.id"
            ));

            if(count($liste) <= 1){
                $this->Session->setFlash("Cette partie est déjà la dernière", 'notif', array('type' => 'error'));
                $this->redirect($this->referer());
                die();
            }

            $new = $this->_array_change_key($liste, $sortOrder, $newsortOrder);

            foreach($new as $k=>$v){
                $this->Partie->id =  $v;
                $this->Partie->saveField('sort_order',$k);
            }

            $this->redirect($this->referer());

        }
        
        public function visualiser($partieId){
            $contain = array(
                            "SousPartie" => array(
                                "fields" => "SousPartie.id, SousPartie.name, SousPartie.slug, SousPartie.contenu"
                            ),
                            "Cour" => array(
                                    "fields" => array("Cour.name, Cour.slug, Cour.id, Cour.created"),
                                    "Theme" => array(
                                        "fields" => array("Theme.id, Theme.name"),
                                        "Matiere" => array(
                                            "fields" => array("Matiere.id, Matiere.name")
                                        )
                                    )
                            ),
                            "User" => array(
                                    "fields" => array("User.id, User.username")
                            )
                        );
            
            $this->_visualiser($partieId, $contain);
        }
        
        public function delete($partieId){
            $partieToDelete = $this->Partie->find("first", array(
                "fields" => "Partie.cour_id, Partie.sort_order",
                "conditions" => "Partie.id = $partieId AND Partie.published = 0", 
                "recursive" => -1
                ));
            $coursId = $partieToDelete['Partie']['cour_id'];
            $currentSortOrder = $partieToDelete['Partie']['sort_order']; 

            $partiesToUpdate = $this->Partie->find("list", array(
                "fields" => "Partie.sort_order, Partie.id",
                "conditions" => "Partie.cour_id = $coursId AND Partie.sort_order > $currentSortOrder ORDER BY sort_order ASC", 
                "recursive" => 0
            ));
            
            if ($this->Partie->delete($partieId, true)) {
                //On update l'ordre des questions suivantes
                foreach($partiesToUpdate as $k=>$v){
                    $this->Partie->id =  $v; $value = $k - 1;
                    $this->Partie->saveField('sort_order',$value);            
                }
                $this->Session->setFlash("Partie définitivement supprimée", 'notif');
            } else {
                $this->Session->setFlash("Un problème est survenu. Veuillez réessayer. Si le problème persiste, vous pouvez contacter l'administrateur du site à contact@zeschool.com", 'notif', array('type' => 'error'));
            }
            $this->redirect($this->referer());
        }
        
        public function admin_manager($coursId, $isPublic = null, $enAttente = null){
    
            if($coursId == "tous"){
                if($enAttente == "enattente"){
                    $condition = "Partie.validation = 1";
                }else{
                    $condition = "Partie.validation = 0";
                }

                if($isPublic == "public"){
                    $condition .= " AND Partie.published = 1";
                }elseif($isPublic == "nonpublic"){
                    $condition .= " AND Partie.published = 0";
                }
            }else{
                $condition = "Partie.id = $coursId ORDER BY sort_order ASC";
            }
   
            $parties = $this->Partie->find('all', array(
                "fields" => "Partie.id, Partie.name, Partie.slug, Partie.validation, Partie.published, Partie.token, Partie.sort_order",
                "conditions" => $condition,
                "contain" => array(
                    "Cour" => array(
                        "fields" => array("Cour.name, Cour.slug, Cour.id")
                    )
                )
            ));
            
            $path = $this->Partie->Cour->getPath($coursId);

            $this->set(compact('parties', 'path', 'coursId'));           
        }
        
        public function admin_visualiser($partieId){
            $contain = array(
                            "SousPartie" => array(
                                "fields" => "SousPartie.id, SousPartie.name, SousPartie.slug, SousPartie.contenu"
                            ),
                            "Cour" => array(
                                    "fields" => array("Cour.name, Cour.slug, Cour.id, Cour.created"),
                                    "Theme" => array(
                                        "fields" => array("Theme.id, Theme.name"),
                                        "Matiere" => array(
                                            "fields" => array("Matiere.id, Matiere.name")
                                        )
                                    )
                            ),
                            "User" => array(
                                    "fields" => array("User.id, User.username")
                            )
                        );
            
            $this->_visualiser($partieId, $contain);
            $this->render('visualiser');
        }
        
        public function admin_edit($partieId = null){
            
            if($this->request->is('post') || $this->request->is('put')) {
 
                $d = $this->Partie->set($this->data);
                
                if($partieId == null){
                    $partieId = $d['Partie']['id'];
                }
                
                //On vérifie que l'utilisateur qui essaye d'enregistrer est bien l'auteur
                $info = $this->Partie->find('first', array(
                        "conditions" => "Partie.id = $partieId",
                        "fields" => array("Partie.cour_id"),
                        "contain" => array()
                ));

            
                $d['Partie']['cour_id'] = $info['Partie']['cour_id'];
                                
                if($this->Partie->save($d['Partie'])){
                    if($partieId != null){
                       $this->Session->setFlash("Mise à jour correctement effectué.");
                        $this->redirect("/parties/manager/".$d['Partie']['cour_id']); 
                    }else{
                        $this->Session->setFlash("Votre cours a bien été crée. Vous pouvez commencer à créer des sous-parties.", 'notif');
                        $this->redirect("/sousparties/manager/".$this->Partie->id);
                    }
                }else{
                    $this->Session->setFlash("Un problème est survenu pendant l'ajout de cette partie. Veuillez réessayer.", 'notif', array('type' => 'error'));
                    $this->redirect($this->referer());
                }

            }else{
                if($partieId != null){
                    $this->data = $this->Partie->find('first', array(
                        "conditions" => "Partie.id = $partieId",
                        "fields" => 'Partie.id, Partie.name, Partie.slug, Partie.contenu',
                        "contain" => array()
                    ));
                }
            }

            $path = $this->Partie->getPath($partieId);
            
            $sousParties = $this->Partie->SousPartie->find('all', array(
                "fields" => "SousPartie.id, SousPartie.name, SousPartie.slug, SousPartie.validation, SousPartie.public, SousPartie.sort_order",
                "conditions" => "SousPartie.partie_id = $partieId ORDER BY SousPartie.sort_order ASC",
                "contain" => array(
                    "Partie" => array(
                        "fields" => array("Partie.name, Partie.slug, Partie.id"),
                        "Cour" => array(
                            "fields" => array("Cour.name, Cour.slug, Cour.id")
                        )
                    )
                )
            ));
            
            $this->set(compact('sousParties', 'path')); 
            $this->render('edit');
        }
        
}