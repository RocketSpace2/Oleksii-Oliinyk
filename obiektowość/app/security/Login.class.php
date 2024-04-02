<?php
require_once dirname(__FILE__).'/../../config.php';
require_once $conf->root_path.'/lib/smarty/Smarty.class.php';
include $conf->root_path.'/lib/Messages.class.php';

class Login{
    private $form;
    private $messages;
    private $smarty;
    
    public function __construct(){
        $this->form = array();
        $this->messages = new Messages();
        $this->smarty = new Smarty();

        global $conf;
		//konfikuracja szablonu smarty
		$this->smarty->assign('conf',$conf);
		
		$this->smarty->assign('page_title','Przykład 05');
		$this->smarty->assign('page_description','Profesjonalne szablonowanie oparte na bibliotece Smarty z wykorzystywaniem obiektowości.');
		$this->smarty->assign('page_header','Szablony Smarty');
				
		$this->smarty->assign('msgs',$this->messages);
    }

    public function getParamsLogin(){
        $this->form['login'] = isset ($_REQUEST ['login']) ? $_REQUEST ['login'] : null;
        $this->form['pass'] = isset ($_REQUEST ['pass']) ? $_REQUEST ['pass'] : null;
    }

    public function validateLogin(){

        if ( ! (isset($this->form['login']) && isset($this->form['pass']))) {
            return false;
        }
    
        if ( $this->form['login'] == "") {
            $this->messages->addError('Nie podano loginu');
        }
        if ( $this->form['pass'] == "") {
            $this->messages->addError('Nie podano hasła');
        }
        
        //nie ma sensu walidować dalej, gdy brak parametrów

        if ($this->messages->isError()) return false;

            if ($this->form['login'] == "admin" && $this->form['pass'] == "admin") {
                session_start();
                $_SESSION['role'] = 'admin';
                return true;                
            }
            if ($this->form['login'] == "user" && $this->form['pass'] == "user") {
                session_start();
                $_SESSION['role'] = 'user';
                return  true;
            }

            $this->messages->addError('Niepoprawny login lub hasło');

        return false;
}

    public function processLogin(){
        global $conf;
        $this->getParamsLogin();
        
        if ($this->validateLogin()){
            //include $conf->root_path.'/app/calc.php';
            header("Location: ".$conf->app_url);
        }else{
            $this->smarty->display($conf->root_path.'/app/security/login_view.php');
        }
    }

}