<?php
// W skrypcie definicji kontrolera nie trzeba dołączać problematycznego skryptu config.php,
// ponieważ będzie on użyty w miejscach, gdzie config.php zostanie już wywołany.

require_once 'CalcForm.class.php';

/** Kontroler kalkulatora
 * @author Przemysław Kudłacik
 *
 */
class CalcCtrl { //wiadomości dla widoku
	private $form;   //dane formularza (do obliczeń i dla widoku)
	private $result; //inne dane dla widoku
	private $smarty;

	/** 
	 * Konstruktor - inicjalizacja właściwości
	 */
	public function __construct(){
		//stworzenie potrzebnych obiektów
		$this->form = new CalcForm();
	}
	
	/** 
	 * Pobranie parametrów
	 */
	public function getParams(){
		$this->form->loan_am = getFromRequest('loan_am');
		$this->form->show_rate = getFromRequest('rate');;
		$this->form->term = getFromRequest('term');;
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
			getMessages()->addError('Nie podano kwoty kredytu');
		}
		if ($this->form->show_rate == "") {
			getMessages()->addError('Nie podano oprocentowania');
		}
		if ($this->form->show_rate == 0) {
			getMessages()->addError('Oprocentowanie nie może być liczbą 0');
		}
		if ($this->form->term == "") {
			getMessages()->addError('Nie podano ilości rat');
		}
		
		// nie ma sensu walidować dalej gdy brak parametrów
		if (! getMessages()->isError()) {
			
			// sprawdzenie, czy $x i $y są liczbami całkowitymi
			if (! is_numeric ( $this->form->loan_am )) {
				getMessages()->addError('Kwota kredytu nie jest liczbą całkowitą');
			}
			
			if (! is_numeric ( $this->form->show_rate )) {
				getMessages()->addError('Oprocentowanie nie jest liczbą całkowitą');
			}

			if (! is_numeric ( $this->form->term )) {
				getMessages()->addError('Ilośś rat nie jest liczbą całkowitą');
			}
		}
		
		return !getMessages()->isError();
	}
	
	
	/**
	 * Wygenerowanie widoku
	 */

	public function showView(){
		global $conf;

		//konfikuracja szablonu smarty
		
		getSmarty()->assign('page_title','Przykład 05');
		getSmarty()->assign('page_description','Profesjonalne szablonowanie oparte na bibliotece Smarty z wykorzystywaniem obiektowości.');
		getSmarty()->assign('page_header','Szablony Smarty');
				
		getSmarty()->assign('form',$this->form);
		getSmarty()->assign('res',$this->result);
		
		getSmarty()->display('calc.html');
		
	}

	/** 
	 * Pobranie wartości, walidacja, obliczenie i wyświetlenie
	 */
	public function process(){

		$this->getparams();
		
		if ($this->validate()){
				//konwersja parametrów na int
				$this->form->loan_am = intval($this->form->loan_am);
				$this->form->rate = intval($this->form->show_rate);
				$this->form->term = intval($this->form->term);
				getMessages()->addInfo('Parametry poprawne.');

				$this->form->rate = ($this->form->rate/100)/12;

				$this->result = ($this->form->loan_am * $this->form->rate * (1 + $this->form->rate))/((1 + $this->form->rate)**$this->form->term - 1);
				$this->result = $this->result * 100;
				$this->result = intval($this->result);
				$this->result = $this->result/100;
				
				getMessages()->addInfo('Wykonano obliczenia.');
		}
		
		$this->showView();
	}
}
