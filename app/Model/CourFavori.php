<?php

class CourFavori extends AppModel{
    
    public $actsAs = array('Containable');
     
    public $belongsTo = array('Cour', 'User');
  
   
    
}
?>
