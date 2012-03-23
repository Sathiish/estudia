<?php
App::uses('AppController', 'Controller');

class NiveauxController extends AppController {
    
    function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow('menu');
    }
    
    public function menu(){
        return $menu = $this->Niveau->find('all', array(
            "fields" => array("Niveau.id, Niveau.name, Niveau.slug"),
            "conditions" => array('Niveau.published' => '1'),
            "contain" => array(
                "Classe"=> array(
                    'fields' => array('Classe.id, Classe.name, Classe.slug'),
                    "conditions" => array('Classe.published' => '1'),
                    "Matiere" => array(
                        'fields' => array('Matiere.id, Matiere.name, Matiere.slug'),
                        "conditions" => array('Matiere.published' => '1')
                    )
                )
            )
        ));
    }
}