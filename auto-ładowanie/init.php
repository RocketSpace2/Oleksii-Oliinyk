<?php
require_once dirname(__FILE__).'/core/Config.class.php';
$conf = new core\Config();
include dirname(__FILE__).'/config.php'; //ustaw konfigurację

function &getConf(){ global $conf; return $conf; }

//załaduj definicję klasy Messages i stwórz obiekt
require_once getConf()->root_path.'/core/Messages.class.php';
$msgs = new core\Messages();

function &getMessages(){ global $msgs; return $msgs; }

//przygotuj Smarty, twórz tylko raz - wtedy kiedy potrzeba
$smarty = null;	
function &getSmarty(){
	global $smarty;
	if (!isset($smarty)){
		//stwórz Smarty i przypisz konfigurację i messages
		include_once getConf()->root_path.'/lib/smarty/Smarty.class.php';
		$smarty = new Smarty();	
		//przypisz konfigurację i messages
		$smarty->assign('conf',getConf());
		$smarty->assign('msgs',getMessages());
		//zdefiniuj lokalizację widoków (aby nie podawać ścieżek przy ich załączaniu)
		$smarty->setTemplateDir(array(
			'one' => getConf()->root_path.'/app/view',
			'two' => getConf()->root_path.'/app/view/templates'
		));
	}
	return $smarty;
}

require_once $conf->root_path.'/core/ClassLoader.class.php';

new core\ClassLoader();

require_once getConf()->root_path.'/core/functions.php';

$action = getFromRequest('action');
