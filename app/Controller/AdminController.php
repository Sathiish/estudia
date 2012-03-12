<?php

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @package       cake
 * @subpackage    cake.app
 */
class AdminController extends AppController {
   
        function beforeFilter(){
            parent::beforeFilter();
            $this->_isAdmin();
            
        }
        
        public function index(){
            
        }
        
}
