<?php
// W skrypcie definicji kontrolera nie trzeba dołączać problematycznego skryptu config.php,
// ponieważ będzie on użyty w miejscach, gdzie config.php zostanie już wywołany.
//require_once dirname(__FILE__).'/../config.php';

require_once $conf->root_path.'/lib/smarty/Smarty.class.php';
require_once $conf->root_path.'/lib/Messages.class.php';
require_once $conf->root_path.'/app/CalcForm.class.php';
//require_once $conf->root_path.'/app/CalcResult.class.php';

// include $conf->root_path.'/app/security/check.php';

// if($is_login_view){
// 	$smarty->display($conf->root_path.'/app/security/login_view.php');
// 	exit();
// }

// $is_login_view = false;

/** Kontroler kalkulatora
 * @author Przemysław Kudłacik
 *
 */
class CalcCtrl {

	private $msgs;   //wiadomości dla widoku
	private $form;   //dane formularza (do obliczeń i dla widoku)
	private $result; //inne dane dla widoku
	private $smarty;

	/** 
	 * Konstruktor - inicjalizacja właściwości
	 */
	public function __construct(){
		global $conf;
		//stworzenie potrzebnych obiektów
		$this->msgs = new Messages();
		$this->form = new CalcForm();

		$this->smarty = new Smarty();
		//konfikuracja szablonu smarty
		$this->smarty->assign('conf',$conf);
		
		$this->smarty->assign('page_title','Przykład 05');
		$this->smarty->assign('page_description','Profesjonalne szablonowanie oparte na bibliotece Smarty z wykorzystywaniem obiektowości.');
		$this->smarty->assign('page_header','Szablony Smarty');
				
		$this->smarty->assign('msgs',$this->msgs);
		$this->smarty->assign('form',$this->form);
		$this->smarty->assign('res',$this->result);
	}
	
	/** 
	 * Pobranie parametrów
	 */
	public function getParams(){
		$this->form->loan_am = isset($_REQUEST ['loan_am']) ? $_REQUEST ['loan_am'] : null;
		$this->form->show_rate = isset($_REQUEST ['rate']) ? $_REQUEST ['rate'] : null;
		$this->form->term = isset($_REQUEST ['term']) ? $_REQUEST ['term'] : null;
	}
	
	/** 
	 * Walidacja parametrów
	 * @return true jeśli brak błedów, false w przeciwnym wypadku 
	 */
	public function validate() {
		// sprawdzenie, czy parametry zostały przekazane
		if (! (isset ( $this->form->loan_am ) && isset ( $this->form->show_rate ) && isset ( $this->form->term ))) {
			// sytuacja wystąpi kiedy np. kontroler zostanie wywołany bezpośrednio - nie z formularza
			return false; //zakończ walidację z błędem
		}
		
		// sprawdzenie, czy potrzebne wartości zostały przekazane
		if ($this->form->loan_am == "") {
			$this->msgs->addError('Nie podano kwoty kredytu');
		}
		if ($this->form->show_rate == "") {
			$this->msgs->addError('Nie podano oprocentowania');
		}
		if ($this->form->show_rate == 0) {
			$this->msgs->addError('Oprocentowanie nie może być liczbą 0');
		}
		if ($this->form->term == "") {
			$this->msgs->addError('Nie podano ilości rat');
		}
		
		// nie ma sensu walidować dalej gdy brak parametrów
		if (! $this->msgs->isError()) {
			
			// sprawdzenie, czy $x i $y są liczbami całkowitymi
			if (! is_numeric ( $this->form->loan_am )) {
				$this->msgs->addError('Kwota kredytu nie jest liczbą całkowitą');
			}
			
			if (! is_numeric ( $this->form->show_rate )) {
				$this->msgs->addError('Oprocentowanie nie jest liczbą całkowitą');
			}

			if (! is_numeric ( $this->form->term )) {
				$this->msgs->addError('Ilośś rat nie jest liczbą całkowitą');
			}
		}
		
		return ! $this->msgs->isError();
	}
	
	/** 
	 * Pobranie wartości, walidacja, obliczenie i wyświetlenie
	 */
	public function process(){
		global $role;
		global $conf;

		$this->checkLogin();

		$this->getparams();
		
		if ($this->validate()){
			if($role != 'admin' && $this->form->loan_am > 10000){	
				//konwersja parametrów na int
				$this->form->loan_am = intval($this->form->loan_am);
				$this->form->rate = intval($this->form->show_rate);
				$this->form->term = intval($this->form->term);
				$this->msgs->addInfo('Parametry poprawne.');

				$this->form->rate = ($this->form->rate/100)/12;

				$this->result = ($this->form->loan_am * $this->form->rate * (1 + $this->form->rate))/((1 + $this->form->rate)**$this->form->term - 1);
				$this->result = $this->result * 100;
				$this->result = intval($this->result);
				$this->result = $this->result/100;
				
				$this->msgs->addInfo('Wykonano obliczenia.');
			}else{
				$this->msgs->addError('Nie jesteś adminem, więc kwota nie może byc większa, niż 10 000 zł !!!');
			}
		}
		
		$this->smarty->display($conf->root_path.'/app/calc.html');
	}
	
	

	/**
	 * Wygenerowanie widoku
	 */
	public function checkLogin(){
		global $conf;
		global $role;

		include $conf->root_path.'/app/security/check.php';

		

		//if(empty($role)){
			if($is_login_view){
				$this->smarty->display($conf->root_path.'/app/security/login_view.php');
				exit();
			}

			//$is_login_view = false;
		//}
		
		
	}
}
