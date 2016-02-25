<?php
$cache_enabled = true;
session_start();
ob_start();
error_reporting(0);
include_once 'lib/EPI/Epi.php';

include_once 'controllers/home.class.php';
include_once 'controllers/login.class.php';
include_once 'controllers/dashboard.class.php';
include_once 'controllers/points.php';
include_once 'controllers/api.class.php';

Epi::setSetting('exceptions',true);
Epi::setPath('base', './lib/EPI');
Epi::setPath('view', './views');
Epi::init('route','template','session','api');


getRoute()->get('/', array('HomeController', 'home'));
getRoute()->get('/home', array('HomeController', 'home'));
getRoute()->get('/home/(\w+)/(\w+)/', array('HomeController', 'home'));
getRoute()->get('/home/(\w+)/(\w+)/(\w+)', array('HomeController', 'home'));


/* special routes */

getRoute()->get('/PayWall', array('DashboardController', 'payment'));
getRoute()->get('/api/', array('ApiController', 'api'));
getRoute()->get('/widgets/(\w+)/(.*+)', array('ApiController', 'widgets'));


getRoute()->get('/testMail/',array('HomeController', 'testMail'));

getRoute()->get('/gapi/', array('PointsController', 'display'));
getRoute()->get('/points/', array('PointsController', 'display'));
getRoute()->get('/3p/(\w+)/', array('PointsController', 'ThirdPartyPoints'));


/* dashboard */
getRoute()->get('/dashboard', array('DashboardController', 'display'));
getRoute()->get('/dashboard/(\w+)/(\w+)/', array('DashboardController', 'dashboard'));
getRoute()->get('/dashboard/(\w+)/(\w+)/(\w+)', array('DashboardController', 'dashboard'));

/* login */
getRoute()->get('/login', array('LoginController', 'display'));
getRoute()->post('/login', array('LoginController', 'processLogin'));
getRoute()->get('/logout', array('LoginController', 'processLogout'));

/* lost password */
getRoute()->get('/forgotpass', array('LoginController', 'forgotPassword'));
getRoute()->post('/forgotpass', array('LoginController', 'processforgotPassword'));
getRoute()->get('/resetpass/(\w+)/(\w+)', array('LoginController', 'resetPassword'));

/* register */
getRoute()->get('/register', array('LoginController', 'register'));
getRoute()->post('/register', array('LoginController', 'processRegister'));
getRoute()->get('/activation/(\w+)/(\w+)', array('LoginController', 'activation'));


//getRoute()->get('(.*+)', array('HomeController', 'reroute'));
getRoute()->get('.*', array('HomeController', 'error404'));

require('init.php');
getRoute()->run();



if (Constants::$CFG->get('Page','Cache') > 0) {
	$html = ob_get_contents();
	ob_end_flush();
	__c("files")->set($keyword_webpage,$html,(Constants::$CFG->get('Page','Cache')));	
}


?>
