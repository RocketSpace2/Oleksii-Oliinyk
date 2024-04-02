<?php
require_once dirname(__FILE__).'/../../config.php';

//załaduj kontroler
require_once $conf->root_path.'/app/security/Login.class.php';

//utwórz obiekt i użyj
	$login = new Login();
	$make = false;

$login->processLogin();