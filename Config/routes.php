<?php
/**
 * Routes configuration
 *
 * In this file, you set up routes to your controllers and their actions.
 * Routes are very important mechanism that allows you to freely connect
 * different URLs to chosen controllers and their actions (functions).
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Config
 * @since         CakePHP(tm) v 0.2.9
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */
/**
 * Here, we are connecting '/' (base path) to controller called 'Pages',
 * its action called 'display', and we pass a param to select the view file
 * to use (in this case, /app/View/Pages/home.ctp)...
 */
	Router::connect('/', array('controller' => 'artists', 'action' => 'index'));
        Router::connect('/social_login/*', array( 'controller' => 'users', 'action' => 'social_login'));
        Router::connect('/social_endpoint/*', array( 'controller' => 'users', 'action' => 'social_endpoint'));
  
        
	Router::connect('/hunermend/*', array('controller' => 'artists', 'action' => 'index'));
	Router::connect('/berhem/*', array('controller' => 'albums', 'action' => 'index'));
	Router::connect('/gotin/karemin/*', array('controller' => 'lyrics', 'action' => 'lyricslist'));        
	Router::connect('/gotin/guhertin/*', array('controller' => 'lyrics', 'action' => 'history'));        
	Router::connect('/gotin/*', array('controller' => 'lyrics', 'action' => 'index'));
        
        
	Router::connect('/sererastkirin/hunermend/*', array('controller' => 'artists', 'action' => 'edit'));
	Router::connect('/sererastkirin/berhem/*', array('controller' => 'albums', 'action' => 'edit'));
	Router::connect('/sererastkirin/gotin/*', array('controller' => 'lyrics', 'action' => 'edit'));
        
        Router::connect('/tevlekirin/gotin/berhem/*', array('controller' => 'lyrics', 'action' => 'add','album'));
        Router::connect('/tevlekirin/gotin/hunermend/*', array('controller' => 'lyrics', 'action' => 'add','artist'));
	Router::connect('/tevlekirin/hunermend/wene/*', array('controller' => 'artists', 'action' => 'add','photo'));
	Router::connect('/tevlekirin/hunermend/*', array('controller' => 'artists', 'action' => 'add'));
	Router::connect('/tevlekirin/berhem/wene/*', array('controller' => 'albums', 'action' => 'add','photo'));
	Router::connect('/tevlekirin/berhem/*', array('controller' => 'albums', 'action' => 'add'));
	Router::connect('/tevlekirin/gotin/*', array('controller' => 'lyrics', 'action' => 'add'));
	Router::connect('/tevlekirin/endam/*', array('controller' => 'users', 'action' => 'add'));
        

        
	
        Router::connect('/endam', array('controller' => 'users', 'action' => 'index'));
        Router::connect('/endam/hemiendam/*', array('controller' => 'users', 'action' => 'userslist'));
        Router::connect('/endam/calaki/hunermend/*', array('controller' => 'users', 'action' => 'property','artists'));
        Router::connect('/endam/calaki/berhem/*', array('controller' => 'users', 'action' => 'property','albums'));
        Router::connect('/endam/calaki/gotin/*', array('controller' => 'users', 'action' => 'property','lyrics'));
        
        Router::connect('/endam/calaki/*', array('controller' => 'users', 'action' => 'property'));
        Router::connect('/endam/penasin/*', array('controller' => 'users', 'action' => 'profile'));
        Router::connect('/endam/miheng/wene/*', array('controller' => 'users', 'action' => 'settings','photo'));
        Router::connect('/endam/miheng/*', array('controller' => 'users', 'action' => 'settings'));
        Router::connect('/endam/tomar/*', array('controller' => 'users', 'action' => 'signup'));
        Router::connect('/endam/tekeve/*', array('controller' => 'users', 'action' => 'login'));
        Router::connect('/endam/derkeve/*', array('controller' => 'users', 'action' => 'logout'));        
        
        
        Router::connect('/tekeve/*', array('controller' => 'users', 'action' => 'login'));
        Router::connect('/derkeve/*', array('controller' => 'users', 'action' => 'logout'));        
        Router::connect('/login/*', array('controller' => 'users', 'action' => 'login'));
        Router::connect('/logout/*', array('controller' => 'users', 'action' => 'logout'));        
        
        
        Router::connect('/daxwaz/tablo/*', array('controller' => 'requests', 'action' => 'panel'));
        Router::connect('/daxwaz/hunermend/*', array('controller' => 'requests', 'action' => 'artist'));
        Router::connect('/daxwaz/berhem/*', array('controller' => 'requests', 'action' => 'album'));
        Router::connect('/daxwaz/stran/*', array('controller' => 'requests', 'action' => 'lyric'));
        Router::connect('/daxwaz', array('controller' => 'requests', 'action' => 'index'));

        Router::connect('/legerin', array('controller' => 'find', 'action' => 'index'));
        Router::connect('/legerin/:key/*', array('controller' => 'find', 'action' => 'index','key' => ':key'));
/**
 * ...and connect the rest of 'Pages' controller's URLs.
 */
        
        Router::connect('/derbar/*', array('controller' => 'pages', 'action' => 'about'));
	Router::connect('/peywendi/*', array('controller' => 'pages', 'action' => 'contact'));
        Router::connect('/about/*', array('controller' => 'pages', 'action' => 'about'));
        Router::connect('/contact/*', array('controller' => 'pages', 'action' => 'contact'));
        
        
	Router::connect('/sitemap/*', array('controller' => 'pages', 'action' => 'sitemap'));
	Router::connect('/nexse/*', array('controller' => 'pages', 'action' => 'sitemap'));        

        
        Router::connect('/player/hunermend/*', array('controller' => 'artist', 'action' => 'index','plugin' => 'player'));        
        Router::connect('/player/berhem/*', array('controller' => 'album', 'action' => 'index','plugin' => 'player'));        
        
        
/**
 * Load all plugin routes. See the CakePlugin documentation on
 * how to customize the loading of plugin routes.
 */
	CakePlugin::routes();

/**
 * Load the CakePHP default routes. Only remove this if you do not want to use
 * the built-in default routes.
 */
	require CAKE . 'Config' . DS . 'routes.php';
