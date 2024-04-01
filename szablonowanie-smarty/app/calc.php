<?php
// KONTROLER strony kalkulatora
require_once dirname(__FILE__).'/../config.php';
//załaduj Smarty
require_once _ROOT_PATH.'/lib/smarty/Smarty.class.php';


$smarty = new Smarty();

$smarty->assign('app_url',_APP_URL);
$smarty->assign('root_path',_ROOT_PATH);
$smarty->assign('page_title','Przykład 04');
$smarty->assign('page_description','Profesjonalne szablonowanie oparte na bibliotece Smarty');
$smarty->assign('page_header','Szablony Smarty');
$smarty->assign('hide_intro',false);

include _ROOT_PATH.'/app/security/check.php';

if($is_login_view){
	$smarty->display(_ROOT_PATH.'/app/security/login_view.php');
	exit();
}

$is_login_view = false;

//pobranie parametrów
function getParams(&$form){
	$form['loan_am'] = isset($_REQUEST['loan_am']) ? $_REQUEST['loan_am'] : null;
	$form['rate'] = isset($_REQUEST['rate']) ? $_REQUEST['rate'] : null;
	$form['term'] = isset($_REQUEST['term']) ? $_REQUEST['term'] : null;
}

//walidacja parametrów z przygotowaniem zmiennych dla widoku
function validate(&$form,&$messages){
	// sprawdzenie, czy parametry zostały przekazane
	if ( ! (isset($form["loan_am"]) && isset($form["rate"]) && isset($form["term"]))) {
		// sytuacja wystąpi kiedy np. kontroler zostanie wywołany bezpośrednio - nie z formularza
		// teraz zakładamy, ze nie jest to błąd. Po prostu nie wykonamy obliczeń
		return false;
	}

	// sprawdzenie, czy potrzebne wartości zostały przekazane
	if ( $form['loan_am'] == "") {
		$messages [] = 'Nie podano kwoty kredytu';
	}
	if ( $form['rate'] == "") {
		$messages [] = 'Nie podano oprocentowania';
	}
	if ( $form['term'] == "") {
		$messages [] = 'Nie podano ilości rat';
	}

	//nie ma sensu walidować dalej gdy brak parametrów
	if (count ( $messages ) != 0) return false;
	
	// sprawdzenie, czy $x i $y są liczbami całkowitymi
	if (! is_numeric( $form["loan_am"] )) {
		$messages [] = 'Kwota kredytu nie jest liczbą całkowitą';
	}
	
	if (! is_numeric( $form['rate'] )) {
		$messages [] = 'Oprocentowanie nie jest liczbą całkowitą';
	}
	if (! is_numeric( $form['term'] )) {
		$messages [] = 'Ilośś rat nie jest liczbą całkowitą';
	}	

	if (count ( $messages ) != 0) return false;
	else 
	return true;
}

function process(&$form,&$messages,&$result){
	global $role;

	if( $role != 'admin' && $form["loan_am"] > 10000) {
		$messages [] = 'Nie jesteś adminem, więc kwota nie może byc większa, niż 10 000 zł !!!';
	}else{
		//konwersja parametrów na int
		$loan_am = intval($form["loan_am"]);
		$rate = intval($form['rate']);
		$term = intval($form['term']);

		$rate = ($rate/100)/12;
		
		//wykonanie operacji
		$result = ($loan_am * $rate*(1+ $rate)**$term)/((1+ $rate)**$term - 1);
		$result = $result * 100;
		$result = intval( $result );
		$result = $result/100;
	}
}

//definicja zmiennych kontrolera
$form = array();
$result = null;
$messages = array();

//pobierz parametry i wykonaj zadanie jeśli wszystko w porządku
getParams($form);
if ( validate($form,$messages) ) { // gdy brak błędów
	process($form,$messages,$result);
}

// 4. Przygotowanie danych dla szablonu



//pozostałe zmienne niekoniecznie muszą istnieć, dlatego sprawdzamy aby nie otrzymać ostrzeżenia
$smarty->assign('form',$form);
$smarty->assign('result',$result);
$smarty->assign('messages',$messages);

// 5. Wywołanie szablonu
	$smarty->display(_ROOT_PATH.'/app/calc.html');