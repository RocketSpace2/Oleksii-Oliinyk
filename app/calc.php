<?php
// KONTROLER strony kalkulatora
require_once dirname(__FILE__).'/../config.php';

// W kontrolerze niczego nie wysyła się do klienta.
// Wysłaniem odpowiedzi zajmie się odpowiedni widok.
// Parametry do widoku przekazujemy przez zmienne.

// 1. pobranie parametrów

$loan_am = $_REQUEST ['loan_am'];
$show_rate = $_REQUEST ['rate'];
$term = $_REQUEST ['term'];

// 2. walidacja parametrów z przygotowaniem zmiennych dla widoku

// sprawdzenie, czy parametry zostały przekazane
if ( ! (isset($loan_am) && isset($show_rate) && isset($term))) {
	//sytuacja wystąpi kiedy np. kontroler zostanie wywołany bezpośrednio - nie z formularza
	$messages [] = 'Błędne wywołanie aplikacji. Brak jednego z parametrów.';
}

// sprawdzenie, czy potrzebne wartości zostały przekazane
if ( $loan_am == "") {
	$messages [] = 'Nie podano kwoty kredytu';
}
if ( $show_rate == "") {
	$messages [] = 'Nie podano oprocentowania';
}
if ( $term == '') {
	$messages [] = 'Nie podano ilości rat';
}

//nie ma sensu walidować dalej gdy brak parametrów
if (empty( $messages )) {
	
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

}

// 3. wykonaj zadanie jeśli wszystko w porządku

if (empty ( $messages )) { // gdy brak błędów
	
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

// 4. Wywołanie widoku z przekazaniem zmiennych
// - zainicjowane zmienne ($messages,$x,$y,$operation,$result)
//   będą dostępne w dołączonym skrypcie
include 'calc_view.php';