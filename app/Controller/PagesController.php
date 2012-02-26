<?php

class PagesController extends AppController{
    
    function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow('*');
    }
    
    function display(){
        $this->set('title_for_layout', 'ZeSchool | Bienvenue');
        $this->render('newhome', 'homenew');
    }
    
    function quisommesnous(){
        $this->set('title_for_layout', 'ZeSchool | Qui sommes nous ?');
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
