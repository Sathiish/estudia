<?php

class AppModel extends Model{
    
    public $actsAs = array('Containable');
    
    public function isAuthorized($id){
        
        $req = $this->find('first', array(
            "conditions" => "id = $id",
            "fields" => "id, user_id, public",
            "contain" => array()
        ));
        return $req;  
    }
        
}