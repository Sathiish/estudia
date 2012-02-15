<?php
App::uses('AppController', 'Controller');
/**
 * Ressources Controller
 *
 * @property Ressource $Ressource
 */
class RessourcesController extends AppController {
        
        var $helpers = array ('Tree');
        
        function beforeFilter() {
            parent::beforeFilter();
            $this->Auth->allow('index');
        }
        
	/**
	 * Liste des matières
	 */
	function index()
	{
            
                $matieres = $this->Ressource->getAllMatieres();
                $this->set(compact('matieres'));
	}
 
        /**
	 * Liste une ressource et tous ses enfants à partir d'un slug
	 */
	function view($id,$slug = null)
	{    
                $ressources = $this->Ressource->find('all',array(
                    "fields" => "Ressource.slug, Ressource.titre, Ressource.id, Ressource.type",
                    "conditions" => "Ressource.parent_id = $id AND Ressource.etat = 1",
                    "recursive" => -1
                        ));
                
                $parents = $this->Ressource->getPath($id, array('slug','id','titre'));
                $PageActive = $parents[sizeof($parents)-1]['Ressource']['titre'];
 
                 /*
                 * Si la ressource active est un thème, alors les liens affichés sont des cours.
                 * On redirige donc vers l'affichage d'un cours
                 */
                if(count($parents)<2){ 
                    $cible = 'view';
                    $targetBlank = '';
                }else{
                    $cible = 'show';
                    $targetBlank = "_blank";
                }
                
                $this->set('title_for_layout', $PageActive);
		$this->set(compact('ressources','parents','cible','PageActive', 'targetBlank'));
	}
        
        /*
         * Affiche le sommaire de la page
         */
        function sommaire($id, $slug = null){
                
                $active = $this->Ressource->find('first', array(
                    'fields' => 'Ressource.id, Ressource.titre, Ressource.slug, Ressource.contenu, Ressource.created, Ressource.etat, Ressource.type, User.id, User.username',
                    "conditions" => array("Ressource.id" => $id, "Ressource.etat" => 1),
                    "recursive" => 0
                ));               
                $allChildren = $this->Ressource->children($id, false,array("titre", "id", "slug", "type", "contenu", "etat", "user_id"));

                $path = $this->Ressource->getPath($id, array('slug','id','titre','type'));
                
                $this->set('title_for_layout', $active['Ressource']['titre']);
		$this->set(compact('allChildren','active', 'path'));
        }
        
        function partie($id, $slug){
            
                $active = $this->Ressource->find('first', array(
                    'fields' => 'Ressource.id, Ressource.titre, Ressource.slug, Ressource.contenu, Ressource.created, Ressource.lft, Ressource.rght, Ressource.parent_id, Ressource.type, User.id, User.username',
                    "conditions" => array("Ressource.id = $id AND Ressource.etat = 1"),
                    "recursive" => 0
                ));
                
                $pageSuivante = $active['Ressource']['rght'] + 1;
                $page['Suivante'] = $this->Ressource->find('first', array(
                    "fields" => "Ressource.id, Ressource.titre, Ressource.slug, Ressource.type",
                    "conditions" => array("Ressource.lft = $pageSuivante AND Ressource.etat = 1")
                ));

                $pagePrecedente = $active['Ressource']['lft'] - 1;
                $page['Precedente'] = $this->Ressource->find('first', array(
                    "fields" => "Ressource.id, Ressource.titre, Ressource.slug, Ressource.type",
                    "conditions" => array("Ressource.rght = $pagePrecedente AND Ressource.etat = 1")
                ));
                
                $pageParente = $active['Ressource']['parent_id'];
                $page['Parente'] = $this->Ressource->find('first', array(
                    "fields" => "Ressource.id, Ressource.titre, Ressource.slug, Ressource.type",
                    "conditions" => array("Ressource.id = $pageParente AND Ressource.etat = 1")
                ));
                
                
                
//                $allChildren = $this->Ressource->children($id, true);
                $allChildren = $this->Ressource->find('all', array(
                    "fields" =>"Ressource.id, Ressource.etat, Ressource.type, Ressource.titre, Ressource.slug, Ressource.contenu, Ressource.user_id",
                    "conditions" => "Ressource.parent_id = $id",
                    "recursive" => -1
                ));
                //debug($allChildren);
                $path = $this->Ressource->getPath($id, array('slug','id','titre','type'));
                $this->set('title_for_layout', $active['Ressource']['titre']);
		$this->set(compact('allChildren','active','path', 'page')); 
        }
        
        /**
	 * Permet de visualiser une ressource
	 */
	function show($id, $slug = null)
	{
                $this->layout = "ressource";

		$active = $this->Ressource->find('first', array(
                    'fields' => 'Ressource.id, Ressource.titre, Ressource.contenu, Ressource.created, Ressource.type, User.id, User.username',
                    "conditions" => array("Ressource.id" => $id, "Ressource.etat" => 1),
                    "recursive" => 0
                ));               
                $allChildren = $this->Ressource->children($id, false, array("titre", "contenu", "type", "slug"));

                $this->set('title_for_layout', $active['Ressource']['titre']);
		$this->set(compact('allChildren','active'));
	}
        
	/**
	 * Ajout/édition d'une ressource
	 *
	 * @param int $id Id de la ressource
	 */
	function edit($id = null)
	{
            if($this->RequestHandler->isAjax()){
                $this->layout= null;
            }else{
                $this->layout = "vierge";
            }
            
            $rang = "";
            $title = "Créer une ressource";
            
            
		if($this->request->is('post'))
		{
			//$this->Ressource->set($this->data);
                        
//                        $ParentRang = $this->Ressource->getRang($this->data['Ressource']['parent_id']);
//                        if($ParentRang == "matiere"){
//                            $this->Session->setFlash("Vous devez obligatoirement choisir un thème. Attention, une matière n'est pas un thème.");
//                            $this->redirect($this->referer());
//                        }
                        $d = $this->data;
                        if($id == null){
                            $d['Ressource']['id'] = null;
                            $whitelist = array();
                        }else{
                            $whitelist = array('titre', 'slug', 'contenu');
                        }

                        
			if($this->Ressource->save($d, true, $whitelist)){
                            $this->Session->setFlash("Ressource enregistrée.");
                            $this->redirect($this->referer());
                        }else
			{
                            $this->Session->setFlash("Corrigez les erreurs mentionnées.");
                            //return false;
                            //$this->redirect(array('action'=> 'index'));
			}
		}
                if($id != null){
                    $this->Ressource->id = $id;
                    $this->data = $this->Ressource->read();
                    $rang = $this->Ressource->getRang($id);
                    
                    $title = "Modifier ";
                    ($rang == "partie" OR $rang == "matière")? $title.= "une": $title.= "un";
                    $title .= " $rang";
                                        
                }

//                $themes = array('Nouvelle matière') + $this->Ressource->generateTreeList(null, null, null, '...',1);
                $themes = $this->Ressource->generateTreeList(null, null, null, '...',1);
                $matieres = array('Choisissez votre matière') + $this->Ressource->find('list', array(
                    "fields" => "id, titre",
                    "conditions" => "parent_id = 0 AND Ressource.etat = 1"
                ));
                
                $path = $this->Ressource->getPath($id, array('slug','id','titre','type'));
                $allChildren = $this->Ressource->children($id);
                
                $this->set('title_for_layout', $title);
                $this->set(compact('matieres', 'themes','rang', 'title','allChildren','active', 'path'));
                if($this->RequestHandler->isAjax()){
                    $this->render('edition');
                }
	}
 
        function selectbox($id = null){
            $this->layout = null;

            if($this->request->is('post') || $this->request->is('put')){
                $parent_id = $this->data['matieres'];
                $themes = $this->Ressource->find('list', array(
                    "fields" => "id, titre",
                    "conditions" => "Ressource.parent_id = $parent_id"
                ));

                $this->set(compact('themes'));
            }
            
        }
        
        /*
         * Gestion des parties d'un cours
         */
        function manager($id = null){
            $user_id = $this->Auth->user('id');
            
            if($id != null){                
                $active = $this->Ressource->find('first', array(
                    'fields' => 'Ressource.id, Ressource.titre, Ressource.contenu, Ressource.created,Ressource.slug, Ressource.type, User.id, User.username',
                    "conditions" => array("Ressource.id" => $id),
                    "recursive" => 0
                ));
                
                if($active['User']['id'] != $user_id){
                    $this->Session->setFlash("Vous n'êtes pas l'auteur de ce cours. Vous ne pouvez donc pas modifier ce cours");
                    $this->redirect(array('controller'=>'ressources', 'action' => 'index')); 
                }
                
                $allChildren = $this->Ressource->children($id);

                $this->set('title_for_layout', $active['Ressource']['titre']);
                $this->set(compact('allChildren','active'));
            }else{
                $this->set('title_for_layout', 'Mes cours');
                
                
                $mescours = $this->Ressource->find('all', array(
                    "conditions" => array(
                        "Ressource.type" => "cours",
                        "Ressource.user_id" => $user_id
                    ),
                    "fields" => "Ressource.id, Ressource.titre, Ressource.slug",
                    "order" => "Ressource.created DESC",
                    "contain" => array()
                ));
               
                $this->set(compact('mescours'));
                $this->render("mescours");
                
            }
        }
        
        /*
         * Création d'une partie d'un cours
         */
        function add($idParent){
            $this->layout = "modal";
            
            if($this->request->is('post') || $this->request->is('put'))
		{
			$this->Ressource->set($this->data);
                           
			if($this->Ressource->save()){
                            $this->Session->setFlash("Données enregistrées.");
                            $this->redirect($this->referer());                            
//                            $this->redirect(array('action'=> 'create', $parent_id)); 
                        }else
			{
                            $this->Session->setFlash("Corrigez les erreurs mentionnées.");
                            $this->redirect($this->referer()); 
                            //return false;
                            //$this->redirect(array('action'=> 'index'));
			}
		}
                
            $parent = $this->Ressource->find('first', array(
                "conditions" => "Ressource.id = $idParent",
                "fields" => "Ressource.id, Ressource.type",
                "recursive" => -1
            ));
            
            if($parent['Ressource']['type'] == "cours"){
                $childrenType = "partie";
            }else{
                $childrenType = "sous-partie";
            }
            

            
              $this->set(compact('parent', 'childrenType'));  
            
        }
        
	/**
	 * Monte une ressource d'un cran
	 *
	 * @param int $id Id de la ressource
	 */
	function monter($id = null)
	{
		if(!$this->Ressource->moveUp($id))
		{
			$this->Session->setFlash("La catégorie ne peut pas aller plus haut.");
		}
		else
		{
			$this->Session->setFlash("Ordre mis à jour.");
		}
 
		$this->redirect($this->referer());
	}
 
	/**
	 * Descend une ressource d'un cran
	 *
	 * @param int $id Id de la ressource
	 */
	function descendre($id = null)
	{
            if(!$this->Ressource->moveDown($id))
            {
                    $this->Session->setFlash("La catégorie ne peut pas aller plus bas.");
            }
            else
            {
                    $this->Session->setFlash("Ordre mis à jour.");
            }

            $this->redirect($this->referer());
	}
 
	/**
	 * Suppression d'une ressource
	 *
	 * @param int $id Id de la ressource
	 */
	function delete($id = null)
	{
            $this->Ressource->id = $id;

            if(!$this->Ressource->exists())
            {
                    $this->Session->setFlash("Ressource introuvable.");
            }
            else
            {
                    $this->Ressource->delete($id);
                    $this->Session->setFlash("La ressource a bien été supprimée.");
            }

            $this->redirect($this->referer());
	}
        
        function admin_index(){
             $matieres = $this->Ressource->find('all', array(
                "fields" => "Ressource.id, Ressource.titre, Ressource.contenu, Ressource.slug, Ressource.type, Ressource.etat",
                "conditions" => "parent_id = 0",
                "recursive" => "-1"
             ));
             
             $this->set(compact('matieres'));
        }
        
        function admin_edit($id = null){
           $this-> layout = "vierge";
            
           if($this->request->is('post'))
		{
                        $this->Ressource->set($this->data);                        
			if($this->Ressource->save()){
                            $this->Session->setFlash("Ressource enregistrée.");
                            $this->redirect($this->referer());
                        }else
			{
                            $this->Session->setFlash("Corrigez les erreurs mentionnées.");
			}
		}
                
                if($id != null){                
                    $this->data = $this->Ressource->find('first', array(
                        "conditions" => "Ressource.id = $id",
                        "fields" => "Ressource.id, Ressource.titre, Ressource.contenu, Ressource.type, Ressource.parent_id, Ressource.etat",
                        "recursive" => -1
                    ));
                }
                $parents = $this->Ressource->getPath($id, array('slug','id','titre'));
                if(empty($parents)){
                    $parents = array();
                }
                    
                $this->set('title_for_layout', "Créer/Modifier une matière");
                $this->set(compact('parents'));
 
        }
        
        function admin_create($matiere_id){
            
            $this->set(compact('matiere_id'));
        }
        
        function admin_view($id){
                $active = $this->Ressource->find('first', array(
                        "conditions" => "Ressource.id = $id",
                        "fields" => "Ressource.id, Ressource.titre, Ressource.slug, Ressource.contenu, Ressource.type, Ressource.parent_id, Ressource.etat",
                        "recursive" => -1
                    ));
                
                $themes = $this->Ressource->children($id, true);

                $this->set('title_for_layout', $active['Ressource']['titre']);
                $this->set(compact('themes','active'));

        }
        
        function admin_add($id){
           if($this->request->is('post'))
		{
                        $this->Ressource->set($this->data);                        
			if($this->Ressource->save()){
                            $this->Session->setFlash("Ressource enregistrée.");
                            $this->redirect($this->referer());
                        }else
			{
                            $this->Session->setFlash("Corrigez les erreurs mentionnées.");
                            //return false;
                            //$this->redirect(array('action'=> 'index'));
			}
		}
                
                if($id != null){                
                    $active = $this->Ressource->find('first', array(
                        "conditions" => "Ressource.id = $id",
                        "fields" => "Ressource.id, Ressource.titre, Ressource.contenu, Ressource.parent_id",
                        "order" => "Ressource.created DESC",
                        "recursive" => -1
                    ));
                }
                    
                $this->set('title_for_layout', "Gérer les thèmes");
                $this->set(compact('active'));
        }

	function admin_delete($id = null)
	{
            $this->Ressource->id = $id;

            if(!$this->Ressource->exists())
            {
                    $this->Session->setFlash("Ressource introuvable.");
            }
            else
            {
                    $this->Ressource->delete($id);
                    $this->Session->setFlash("La ressource a bien été supprimée.");
            }

            $this->redirect($this->referer());
	}
}