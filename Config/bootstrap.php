<?php



Cache::config('default', array('engine' => 'File'));

CakePlugin::loadAll();

Configure::write('Dispatcher.filters', array('AssetDispatcher','CacheDispatcher'));



/**

 * Configures default file logging options

 */

App::uses('CakeLog', 'Log');

CakeLog::config('debug', array(

	'engine' => 'File',

	'types' => array('notice', 'info', 'debug'),

	'file' => 'debug',

));

CakeLog::config('error', array(

	'engine' => 'File',

	'types' => array('warning', 'error', 'critical', 'alert', 'emergency'),

	'file' => 'error',

));



Configure::write('App.imageBaseUrl','wene/');

CakePlugin::load('Contacter');

if (!defined('USER_DIC')){define('USER_DIC', 'endam/');}

if (!defined('HUNER_DIC')){define('HUNER_DIC', 'hunermend/');}

if (!defined('BERHEM_DIC')){define('BERHEM_DIC', 'berhem/');}
