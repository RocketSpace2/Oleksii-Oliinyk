<?php require_once dirname(__FILE__) .'/../config.php';?>
<!DOCTYPE HTML>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="pl" lang="pl">
<head>
<meta charset="utf-8" />
<title>Kalkulator</title>
	<style>
        .block {
			width: 10%;
            display: inline-block; 
        }
    </style>
</head>
<body>


<form action="<?php print(_APP_URL);?>/app/calc.php" method="post">
	<label class="block" for="loan-amount">Kwota kredytu: </label>
	<input id="loan-amount" type="text" name="loan_am" value="<?php isset($loan_am)? print($loan_am): "Write number"; ?>">
	<br>

	<br>
	<label class="block" for="credit-rate">Oprocentowanie (%): </label>
	<input id="credit-rate" type="text" name="rate" value="<?php isset($rate)? print($rate): "Write number"; ?>" />
	<br />

	<br>
	<label class="block" for="loan-term">Ilość rat miesięcznych: </label>
	<input id="loan-term" type="text" name="term" value="<?php isset($term)? print($term): "Write number"; ?>" />
	<br />
	
	<input type="submit" value="Oblicz" />

	</table>	
</form>	

<?php
//wyświeltenie listy błędów, jeśli istnieją
if (isset($messages)) {
	if (count ( $messages ) > 0) {
		echo '<ol style="margin: 20px; padding: 10px 10px 10px 30px; border-radius: 5px; background-color: #f88; width:300px;">';
		foreach ( $messages as $key => $msg ) {
			echo '<li>'.$msg.'</li>';
		}
		echo '</ol>';
	}
}
?>

<?php if (isset($result)){ ?>
<div style="margin: 20px; padding: 10px; border-radius: 5px; background-color: #ff0; width:300px;">
<?php echo 'Rata miesięczna: '.$result; ?>
</div>
<?php } ?>

</body>
</html>