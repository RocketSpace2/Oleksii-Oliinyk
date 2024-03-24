<?php
require_once dirname(__FILE__).'/../../config.php';
//inicjacja mechanizmu sesji
session_start();
//pobranie roli
$role = isset($_SESSION['role']) ? $_SESSION['role'] : '';

//jeśli brak parametru (niezalogowanie) to idź na stronę logowania
if ( empty($role) ){
	$is_login_view = true;	
}