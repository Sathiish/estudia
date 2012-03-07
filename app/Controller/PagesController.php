<?php

class PagesController extends AppController{
    
    function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow('*');
    }
    
    function display(){
        
        if($this->Auth->user('id')){
            $this->redirect('/dashboard');
        }else{
            $this->set('index', 'index');
            $this->set('title_for_layout', 'ZeSchool | Tous vos cours et exercices en ligne');
            $this->set('meta_description', 'ZeSchool est une plateforme totalement gratuite sur laquelle tous les élèves peuvent réviser leurs cours et s\'exercer en ligne');
            $this->set('meta_keywords', 'cours, online, ligne, pdf, réviser, anglais, exercices, gratuit, école, school, quiz, math, mathématiques, physique, chimie, svt');
            $this->render('index', 'home');
        }
    }
    
    function arguments(){
        $this->set('title_for_layout', '10 bonnes raisons de s\'incrire');
    }
    
    function quisommesnous(){
        $this->set('title_for_layout', 'ZeSchool | Qui sommes nous ?');
    }
    
    function cgu(){
        $this->set('title_for_layout', 'ZeSchool | Conditions générales d\'utilisation');   
    }
    
    function mentionslegales(){
        $this->set('title_for_layout', 'ZeSchool | Mentions légales');   
    }
    
    function tutoriel_cours(){
        $this->layout = "home";
        $this->set('title_for_layout', 'Tutoriel de création d\'un cours');
    }
    
    function tutoriel_quiz(){
        $this->layout = "home";
        $this->set('title_for_layout', 'Tutoriel de création d\'un cours');
    }
    
    function tutoriel_eclasse(){
        $this->layout = "home";
        $this->set('title_for_layout', 'Tutoriel de création d\'un cours');
    }
}
?>
