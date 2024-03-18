<?php
require_once dirname(__FILE__).'/../config.php';

// KONTROLER strony kalkulatora

// W kontrolerze niczego nie wysyła się do klienta.
// Wysłaniem odpowiedzi zajmie się odpowiedni widok.
// Parametry do widoku przekazujemy przez zmienne.

//ochrona kontrolera - poniższy skrypt przerwie przetwarzanie w tym punkcie gdy użytkownik jest niezalogowany
include _ROOT_PATH.'/app/security/check.php';

//pobranie parametrów
function getParams(&$loan_am,&$show_rate,&$term){
	$loan_am = isset($_REQUEST['loan_am']) ? $_REQUEST['loan_am'] : null;
	$show_rate = isset($_REQUEST['rate']) ? $_REQUEST['rate'] : null;
	$term = isset($_REQUEST['term']) ? $_REQUEST['term'] : null;	
}

//walidacja parametrów z przygotowaniem zmiennych dla widoku
function validate(&$loan_am,&$show_rate,&$term,&$messages){
	// sprawdzenie, czy parametry zostały przekazane
	if ( ! (isset($loan_am) && isset($show_rate) && isset($term))) {
		// sytuacja wystąpi kiedy np. kontroler zostanie wywołany bezpośrednio - nie z formularza
		// teraz zakładamy, ze nie jest to błąd. Po prostu nie wykonamy obliczeń
		return false;
	}

	// sprawdzenie, czy potrzebne wartości zostały przekazane
	if ( $loan_am == "") {
		$messages [] = 'Nie podano kwoty kredytu';
	}
	if ( $show_rate == "") {
		$messages [] = 'Nie podano oprocentowania';
	}
	if ( $term == "") {
		$messages [] = 'Nie podano ilości rat';
	}

	//nie ma sensu walidować dalej gdy brak parametrów
	if (count ( $messages ) != 0) return false;
	
	// sprawdzenie, czy $x i $y są liczbami całkowitymi
	if (! is_numeric( $loan_am )) {
		$messages [] = 'Kwota kredytu nie jest liczbą całkowitą';
	}
	
	if (! is_numeric( $show_rate )) {
		$messages [] = 'Oprocentowanie nie jest liczbą całkowitą';
	}
	if (! is_numeric( $term )) {
		$messages [] = 'Ilośś rat nie jest liczbą całkowitą';
	}	

	if (count ( $messages ) != 0) return false;
	else return true;
}

function process(&$loan_am,&$show_rate,&$term,&$messages,&$result){
	global $role;

	if( $role != 'admin' && $loan_am > 10000) {
		$messages [] = 'Nie jesteś adminem, więc kwota nie może byc większa, niż 10 000 zł !!!';
	}else{
		//konwersja parametrów na int
		$loan_am = intval($loan_am);
		$rate = intval($show_rate);
		$term = intval($term);

		$rate = ($rate/100)/12;
		
		//wykonanie operacji
		$result = ($loan_am * $rate*(1+ $rate)**$term)/((1+ $rate)**$term - 1);
		$result = $result * 100;
		$result = intval( $result );
		$result = $result/100;
	}
}

//definicja zmiennych kontrolera
$loan_am = null;
$show_rate = null;
$term = null;
$result = null;
$messages = array();

//pobierz parametry i wykonaj zadanie jeśli wszystko w porządku
getParams($loan_am,$show_rate,$term);
if ( validate($loan_am,$show_rate,$term,$messages) ) { // gdy brak błędów
	process($loan_am,$show_rate,$term,$messages,$result);
}

// Wywołanie widoku z przekazaniem zmiennych
// - zainicjowane zmienne ($messages,$x,$y,$operation,$result)
//   będą dostępne w dołączonym skrypcie
include 'calc_view.php';

{
// // 1. pobranie parametrów
// global $role;

// $loan_am = isset($_REQUEST ['loan_am']) ? $_REQUEST['loan_am'] : null;
// $show_rate = isset($_REQUEST ['rate']) ? $_REQUEST['rate'] : null;
// $term = isset($_REQUEST ['term']) ? $_REQUEST['term'] : null;

// if($loan_am !=null){

// // 2. walidacja parametrów z przygotowaniem zmiennych dla widoku

// // sprawdzenie, czy parametry zostały przekazane
// if ( ! (isset($loan_am) && isset($show_rate) && isset($term))) {
// 	//sytuacja wystąpi kiedy np. kontroler zostanie wywołany bezpośrednio - nie z formularza
// 	$messages [] = 'Błędne wywołanie aplikacji. Brak jednego z parametrów.';
// }

// // sprawdzenie, czy potrzebne wartości zostały przekazane
// if ( $loan_am == "") {
// 	$messages [] = 'Nie podano kwoty kredytu';
// }
// if ( $show_rate == "") {
// 	$messages [] = 'Nie podano oprocentowania';
// }
// if ( $term == '') {
// 	$messages [] = 'Nie podano ilości rat';
// }

// //nie ma sensu walidować dalej gdy brak parametrów
// if (empty( $messages )) {
	
// 	// sprawdzenie, czy $x i $y są liczbami całkowitymi
// 	if (! is_numeric( $loan_am )) {
// 		$messages [] = 'Kwota kredytu nie jest liczbą całkowitą';
// 	}else{
// 		if($role != 'admin' && $loan_am > 10000){
// 			$messages [] = 'Nie jesteś adminem, więc kwota nie może byc większa, niż 10 000 zł !!!';
// 		}
// 	}
	
// 	if (! is_numeric( $show_rate )) {
// 		$messages [] = 'Oprocentowanie nie jest liczbą całkowitą';
// 	}
	
// 	if (! is_numeric( $term )) {
// 		$messages [] = 'Ilośś rat nie jest liczbą całkowitą';
// 	}

// }

// // 3. wykonaj zadanie jeśli wszystko w porządku

// if (empty ( $messages )) { // gdy brak błędów
	
// 	//konwersja parametrów na int
// 	$loan_am = intval($loan_am);
// 	$rate = intval($show_rate);
// 	$term = intval($term);

// 	$rate = ($rate/100)/12;
	
// 	//wykonanie operacji
// 	$result = ($loan_am * $rate*(1+ $rate)**$term)/((1+ $rate)**$term - 1);
// 	$result = $result * 100;
// 	$result = intval( $result );
// 	$result = $result/100;
// }
// }
// // 4. Wywołanie widoku z przekazaniem zmiennych
// // - zainicjowane zmienne ($messages,$x,$y,$operation,$result)
// //   będą dostępne w dołączonym skrypcie
// include 'calc_view.php';
}