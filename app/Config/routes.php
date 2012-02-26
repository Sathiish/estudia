<?php
/**
 * Routes configuration
 *
 * In this file, you set up routes to your controllers and their actions.
 * Routes are very important mechanism that allows you to freely connect
 * different urls to chosen controllers and their actions (functions).
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2011, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2005-2011, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.config
 * @since         CakePHP(tm) v 0.2.9
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
/**
 * Here, we are connecting '/' (base path) to controller called 'Pages',
 * its action called 'display', and we pass a param to select the view file
 * to use (in this case, /app/View/Pages/home.ctp)...
 */
	Router::connect('/', array('controller' => 'pages', 'action' => 'display', 'home'));
/**
 * ...and connect the rest of 'Pages' controller's urls.
 */
	//Router::connect('/pages/*', array('controller' => 'pages', 'action' => 'display'));
	//Router::connect('/tutoriel/*', array('controller' => 'pages', 'action' => 'cours'));
        Router::connect('/qui-sommes-nous', array('controller'=>'pages', 'action' =>'quisommesnous'));
        Router::connect('/mentions-legales', array('controller'=>'pages', 'action' =>'mensionslegales'));
        Router::connect('/dashboard', array('controller'=>'users', 'action' =>'dashboard'));
        Router::connect('/profil/*', array('controller'=>'users', 'action' =>'index'));
        Router::connect('/inscription', array('controller'=>'users', 'action' =>'inscription'));
        Router::connect('/login', array('controller'=>'users', 'action' =>'login'));
        Router::connect('/logout', array('controller'=>'users', 'action' =>'logout'));      
        Router::connect(
                '/forum/:id-:slug',
                array('controller' => 'topics', 'action' => 'index'),
                array('pass' => array( 
                        'id', 'slug'
                    ),
                    'id' => '[0-9]+', 
                    'slug' => '[a-zA-Z0-9_-]+'                  
                ) 
        );
        Router::connect('/forum', array('controller'=>'categories', 'action' =>'index'));
        Router::connect(
                '/topic/:id-:slug',
                array('controller' => 'posts', 'action' => 'index'),
                array('pass' => array( 
                        'id', 'slug'
                    ),
                    'id' => '[0-9]+', 
                    'slug' => '[a-zA-Z0-9_-]+'                  
                ) 
        );
//        Router::connect(
//                '/cours/:slug-:id',
//                array('controller' => 'cours', 'action' => 'view'),
//                array('pass' => array( 
//                        'id', 'slug'
//                    ),
//                    'id' => '[0-9]+', 
//                    'slug' => '[a-zA-Z0-9_-]+'                  
//                ) 
//        );
        Router::connect(
                '/quiz/theme/:slug-:id',
                array('controller' => 'quiz', 'action' => 'view'),
                array('pass' => array( 
                        'id', 'slug'
                    ),
                    'id' => '[0-9]+', 
                    'slug' => '[a-zA-Z0-9_-]+'                  
                ) 
        );
        Router::connect(
                '/quiz/start/:restart/:slug-:id',
                array('controller' => 'quiz', 'action' => 'start'),
                array('pass' => array( 
                        'id', 'slug', 'restart' 
                    ),
                    'id' => '[0-9]+', 
                    'slug' => '[a-zA-Z0-9_-]+'                  
                ) 
        );
        Router::connect(
                '/quiz/:slug-:id',
                array('controller' => 'quiz', 'action' => 'theme'),
                array('pass' => array( 
                        'id', 'slug'
                    ),
                    'id' => '[0-9]+', 
                    'slug' => '[a-zA-Z0-9_-]+'                  
                ) 
        );


/**
 * Load all plugin routes.  See the CakePlugin documentation on 
 * how to customize the loading of plugin routes.
 */
	CakePlugin::routes();

/**
 * Load the CakePHP default routes. Remove this if you do not want to use
 * the built-in default routes.
 */
	require CAKE . 'Config' . DS . 'routes.php';
