<?php
require_once 'init.php';

getConf()->login_action = 'login';

switch ($action) {
	default :
		control('app\\controllers', 'CalcCtrl', 'showView', ['user','admin']);
	case 'login': 
		control('app\\controllers', 'LoginCtrl','doLogin');
	case 'calcCompute' : 
		control('app\\controllers', 'CalcCtrl',	'process',	['user','admin']);
	case 'logout' : 
		control('app\\controllers', 'LoginCtrl','doLogout',	['user','admin']);
}