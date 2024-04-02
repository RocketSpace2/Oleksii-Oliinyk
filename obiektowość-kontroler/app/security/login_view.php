{extends file="../../templates/main.html"}

{block name=form}
<div style="width:90%; margin: 2em auto;">

<form id="form" action="{$conf->app_url}/app/security/login.php" method="post" class="pure-form pure-form-stacked">
	<legend>Logowanie</legend>
	<br>
	<fieldset>
		<label for="id_login">login: </label>
		<input id="id_login" type="text" name="login" value="" />
		<label for="id_pass">pass: </label>
		<input id="id_pass" type="password" name="pass" />
	</fieldset>
	<br>
	<input type="submit" value="zaloguj" class="pure-button pure-button-primary"/>
</form>	


{if $msgs->isError()}
	<div>
		<h4>Wystąpiły błędy: </h4>
		<ol>
		{foreach  $msgs->getErrors() as $msg}
		{strip}
			<li>{$msg}</li>
		{/strip}
		{/foreach}
		</ol>
	</div>	
{/if}
<!-- 
{if isset($messages) }
	{if (count ( $messages ) > 0) }
		echo '<ol style="padding: 10px 10px 10px 30px; border-radius: 5px; background-color: #f88; width:300px;">';
		foreach ( $messages as $key => $msg ) {
			echo '<li>'.$msg.'</li>';
		}
		echo '</ol>';
	{/if}
{/if} -->


</div>
{/block}