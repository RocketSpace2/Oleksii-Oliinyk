<?php
/* Smarty version 4.3.2, created on 2024-03-24 21:07:33
  from 'D:\Work\XAMPP\htdocs\oleksii-oliinyk\szablonowanie-smarty\app\security\login_view.php' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '4.3.2',
  'unifunc' => 'content_66008805cbc875_91681346',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '38fe0e2cbfd04b34d9b452da46913255acec9153' => 
    array (
      0 => 'D:\\Work\\XAMPP\\htdocs\\oleksii-oliinyk\\szablonowanie-smarty\\app\\security\\login_view.php',
      1 => 1711308158,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_66008805cbc875_91681346 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_loadInheritance();
$_smarty_tpl->inheritance->init($_smarty_tpl, true);
?>


<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_120687520766008805cb7973_13011013', 'form');
$_smarty_tpl->inheritance->endChild($_smarty_tpl, "../../templates/main.html");
}
/* {block 'form'} */
class Block_120687520766008805cb7973_13011013 extends Smarty_Internal_Block
{
public $subBlocks = array (
  'form' => 
  array (
    0 => 'Block_120687520766008805cb7973_13011013',
  ),
);
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

<div style="width:90%; margin: 2em auto;">

<form id="form" action="<?php echo $_smarty_tpl->tpl_vars['app_url']->value;?>
/app/security/login.php" method="post" class="pure-form pure-form-stacked">
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


<?php if ((isset($_smarty_tpl->tpl_vars['messages']->value))) {?>
	<?php if ((count($_smarty_tpl->tpl_vars['messages']->value) > 0)) {?>
		echo '<ol style="padding: 10px 10px 10px 30px; border-radius: 5px; background-color: #f88; width:300px;">';
		foreach ( $messages as $key => $msg ) {
			echo '<li>'.$msg.'</li>';
		}
		echo '</ol>';
	<?php }
}?>


</div>
<?php
}
}
/* {/block 'form'} */
}
