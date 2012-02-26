<?php
App::uses('AppController', 'Controller');
/**
 * Ressources Controller
 *
 * @property Ressource $Ressource
 */
class SousPartiesController extends AppController {
              
        function beforeFilter() {
            parent::beforeFilter();
            $this->Auth->allow('index');
            
        }
                
        public function manager($partieId){

            $sousParties = $this->SousPartie->find('all', array(
                "fields" => "SousPartie.id, SousPartie.name, SousPartie.slug, SousPartie.validation, SousPartie.published, SousPartie.sort_order",
                "conditions" => "SousPartie.partie_id = $partieId ORDER BY sort_order ASC",
                "contain" => array(
                    "Partie" => array(
                        "fields" => array("Partie.name, Partie.slug, Partie.id"),
                        "Cour" => array(
                            "fields" => array("Cour.name, Cour.slug, Cour.id")
                        )   
                    )
                )
            ));
            
            $path = $this->SousPartie->Partie->getPath($partieId);

            $this->set(compact('sousParties', 'path'));           
        }
        
        public function edit($sousPartieId = null){

            $this->_checkAuthorization($sousPartieId);
            
            if($this->request->is('post') || $this->request->is('put')) {
 
                $d = $this->SousPartie->set($this->data);
                
                if($sousPartieId == null){
                    $sousPartieId = $d['SousPartie']['id'];
                }
                
//                //On vérifie que l'utilisateur qui essaye d'enregistrer est bien l'auteur
//                $auteur = $this->SousPartie->find('first', array(
//                        "conditions" => "Partie.id = $partieId",
//                        "fields" => array("Partie.cour_id"),
//                        "contain" => array(
//                            "Cour" => array(
//                                "fields" => array("Cour.user_id")
//                            )
//                        )
//                ));
//                
//                if($auteur['Cour']['user_id'] != $this->Auth->user('id')){
//                    $this->Session->setFlash("Votre n'êtes pas l'auteur de ce cours. Vous ne pouvez donc pas le modifier.");
//                    $this->redirect("/cours/manager");
//                }
            
//                $d['SousPartie']['partie_id'] = $auteur['Partie']['cour_id'];
                                //debug($d['SousPartie']); die();
                if($this->SousPartie->save($d['SousPartie'], array(    
                    'validate' => true,    
                    'fieldList' => array(),    
                    'callbacks' => false
                ))){
                    $this->Session->setFlash("Mise à jour correctement effectuée.");
                    $this->redirect($this->referer()); 

                }else{
                    $this->Session->setFlash("Un problème est survenu pendant l'ajout de cette partie. Veuillez réessayer.");
                    $this->redirect($this->referer());
                }

            }else{
                if($sousPartieId != null){
                    $this->data = $this->SousPartie->find('first', array(
                        "conditions" => "SousPartie.id = $sousPartieId",
                        "fields" => 'SousPartie.id, SousPartie.name, SousPartie.slug, SousPartie.contenu',
                        "contain" => array()
                    ));
                }
            }
            
            $path = $this->SousPartie->getPath($sousPartieId);
            $this->set(compact('path'));
        }
        
        public function add($partieId){

            if($this->request->is('post') || $this->request->is('put')) {
 
                $d = $this->SousPartie->set($this->data);
                $d['SousPartie']['partie_id'] = $partieId;
                $d['SousPartie']['id'] = null;
                $d['SousPartie']['user_id'] = $this->Auth->user('id');
                
                $lastPosition = $this->SousPartie->find('first', array(
                    "fields" => "SousPartie.sort_order",
                    "conditions" => "SousPartie.partie_id = $partieId ORDER BY sort_order DESC"
                ));
                
                if(!$lastPosition){
                    $d['SousPartie']['sort_order'] = 1;
                }
                else{
                    $d['SousPartie']['sort_order'] = $lastPosition['SousPartie']['sort_order'] + 1;
                }
                
                if($this->SousPartie->save($d['SousPartie'])){
                    $this->Session->setFlash("Mise à jour correctement effectué.");
                    $this->redirect("/sousparties/manager/$partieId"); 

                }else{
                    $this->Session->setFlash("Un problème est survenu pendant l'ajout de cette partie. Veuillez réessayer.");
                    $this->redirect($this->referer());
                }
                
            }
            
            $path = $this->SousPartie->Partie->getPath($partieId);

            $this->set(compact('path'));

        }
        
        public function monter($sousPartieId){

            $req = $this->SousPartie->find('first', array(
               "conditions" => "SousPartie.id = $sousPartieId",
               "fields" => "SousPartie.partie_id, SousPartie.sort_order"
            ));

            $partieId = $req['SousPartie']['partie_id'];
            $sortOrder = $req['SousPartie']['sort_order'];

            if($sortOrder <= 1){
                $this->Session->setFlash("Cette sous-partie est déjà la première");
                $this->redirect($this->referer());
                die();
            }

            $newsortOrder = $sortOrder -1;

            $liste = $this->SousPartie->find('list', array(
               "conditions" => "SousPartie.partie_id = $partieId AND (SousPartie.sort_order = $sortOrder OR SousPartie.sort_order = $newsortOrder)",
               "fields" => "SousPartie.sort_order, SousPartie.id"
            ));


            $new = $this->_array_change_key($liste, $sortOrder, $newsortOrder);

            foreach($new as $k=>$v){
                $this->SousPartie->id =  $v;
                $this->SousPartie->saveField('sort_order',$k);
            }

            $this->redirect($this->referer());

        }

        public function descendre($sousPartieId){

            $req = $this->SousPartie->find('first', array(
               "conditions" => "SousPartie.id = $sousPartieId",
               "fields" => "SousPartie.partie_id, SousPartie.sort_order"
            ));

            $partieId = $req['SousPartie']['partie_id'];
            $sortOrder = $req['SousPartie']['sort_order'];

            $newsortOrder = $sortOrder +1;

            $liste = $this->SousPartie->find('list', array(
               "conditions" => "SousPartie.partie_id = $partieId AND (SousPartie.sort_order = $sortOrder OR SousPartie.sort_order = $newsortOrder)",
               "fields" => "SousPartie.sort_order, SousPartie.id"
            ));

            if(count($liste) <= 1){
                $this->Session->setFlash("Cette sous-partie est déjà la dernière");
                $this->redirect($this->referer());
                die();
            }

            $new = $this->_array_change_key($liste, $sortOrder, $newsortOrder);

            foreach($new as $k=>$v){
                $this->SousPartie->id =  $v;
                $this->SousPartie->saveField('sort_order',$k);
            }

            $this->redirect($this->referer());

        }
        
        public function delete($sousPartieId){

            $sousPartieToDelete = $this->SousPartie->find("first", array(
                "fields" => "SousPartie.partie_id, SousPartie.sort_order",
                "conditions" => "SousPartie.id = $sousPartieId", 
                "recursive" => -1
                ));
            $partieId = $sousPartieToDelete['SousPartie']['partie_id'];
            $currentSortOrder = $sousPartieToDelete['SousPartie']['sort_order']; 

            $sousPartiesToUpdate = $this->SousPartie->find("list", array(
                "fields" => "SousPartie.sort_order, SousPartie.id",
                "conditions" => "SousPartie.partie_id = $partieId AND SousPartie.sort_order > $currentSortOrder ORDER BY sort_order ASC", 
                "recursive" => 0
            ));
                        
            if ($this->SousPartie->delete($sousPartieId, true)) {
                //On update l'ordre des questions suivantes
                foreach($sousPartiesToUpdate as $k=>$v){
                    $this->SousPartie->id =  $v; $value = $k - 1;
                    $this->SousPartie->saveField('sort_order',$value);            
                }
                
                $this->Session->setFlash("Sous-partie définitivement supprimée");
            } else {
                $this->Session->setFlash("Un problème est survenu. Veuillez réessayer. Si le problème persiste, vous pouvez contacter l'administrateur du site à contact@zeschool.com");
            }
            $this->redirect($this->referer());
        }
        
        public function admin_manager($partieId, $isPublic = null, $enAttente = null){

            if($partieId == "tous"){
                if($enAttente == "enattente"){
                    $condition = "SousPartie.validation = 1";
                }else{
                    $condition = "SousPartie.validation = 0";
                }

                if($isPublic == "public"){
                    $condition .= " AND SousPartie.published = 1";
                }elseif($isPublic == "nonpublic"){
                    $condition .= " AND SousPartie.published = 0";
                }
            }else{
                $condition = "SousPartie.partie_id = $partieId ORDER BY sort_order ASC";
                $path = $this->SousPartie->Partie->getPath($partieId);
            }
           
            $this->loadModel('SousPartie');
            $sousParties = $this->SousPartie->find('all', array(
                "fields" => "SousPartie.id, SousPartie.name, SousPartie.slug, SousPartie.validation, SousPartie.published, SousPartie.token, SousPartie.sort_order",
                "conditions" => $condition,
                "contain" => array(
                    "Partie" => array(
                        "fields" => array("Partie.name, Partie.slug, Partie.id"),
                        "Cour" => array(
                            "fields" => array("Cour.name, Cour.slug, Cour.id")
                        )   
                    )
                )
            ));
             
            

            $this->set(compact('sousParties', 'path', 'partieId'));           
        }
        
        public function admin_edit($sousPartieId = null){
            
            if($this->request->is('post') || $this->request->is('put')) {
 
                $d = $this->SousPartie->set($this->data);
                
                if($sousPartieId == null){
                    $sousPartieId = $d['SousPartie']['id'];
                }
                
                if($this->SousPartie->save($d['SousPartie'])){
                    $this->Session->setFlash("Mise à jour correctement effectuée.");
                    $this->redirect($this->referer()); 

                }else{
                    $this->Session->setFlash("Un problème est survenu pendant l'ajout de cette partie. Veuillez réessayer.");
                    $this->redirect($this->referer());
                }

            }else{
                if($sousPartieId != null){
                    $this->data = $this->SousPartie->find('first', array(
                        "conditions" => "SousPartie.id = $sousPartieId",
                        "fields" => 'SousPartie.id, SousPartie.name, SousPartie.slug, SousPartie.contenu',
                        "contain" => array()
                    ));
                }
            }
            
            $path = $this->SousPartie->getPath($sousPartieId);
            $this->set(compact('path'));
            $this->render('edit');
        }
        
}