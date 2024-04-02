<?php
/* Smarty version 4.3.2, created on 2024-04-02 13:24:45
  from 'D:\Work\XAMPP\htdocs\oleksii-oliinyk\obiektowość-kontroler\app\security\login_view.php' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '4.3.2',
  'unifunc' => 'content_660beafd8debb1_99810539',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '0e9b6fd674e93c2790d887ae034b50fc4977f001' => 
    array (
      0 => 'D:\\Work\\XAMPP\\htdocs\\oleksii-oliinyk\\obiektowość-kontroler\\app\\security\\login_view.php',
      1 => 1712055827,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_660beafd8debb1_99810539 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_loadInheritance();
$_smarty_tpl->inheritance->init($_smarty_tpl, true);
?>


<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_659822714660beafd8ca428_42052147', 'form');
$_smarty_tpl->inheritance->endChild($_smarty_tpl, "../../templates/main.html");
}
/* {block 'form'} */
class Block_659822714660beafd8ca428_42052147 extends Smarty_Internal_Block
{
public $subBlocks = array (
  'form' => 
  array (
    0 => 'Block_659822714660beafd8ca428_42052147',
  ),
);
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

<div style="width:90%; margin: 2em auto;">

<form id="form" action="<?php echo $_smarty_tpl->tpl_vars['conf']->value->app_url;?>
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


<?php if ($_smarty_tpl->tpl_vars['msgs']->value->isError()) {?>
	<div style="padding-left: 7em;">
		<h4>Wystąpiły błędy: </h4>
		<ol>
		<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['msgs']->value->getErrors(), 'msg');
$_smarty_tpl->tpl_vars['msg']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['msg']->value) {
$_smarty_tpl->tpl_vars['msg']->do_else = false;
?>
		<li><?php echo $_smarty_tpl->tpl_vars['msg']->value;?>
</li>
		<?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
		</ol>
	</div>	
<?php }?>
<!-- 
<?php if ((isset($_smarty_tpl->tpl_vars['messages']->value))) {?>
	<?php if ((count($_smarty_tpl->tpl_vars['messages']->value) > 0)) {?>
		echo '<ol style="padding: 10px 10px 10px 30px; border-radius: 5px; background-color: #f88; width:300px;">';
		foreach ( $messages as $key => $msg ) {
			echo '<li>'.$msg.'</li>';
		}
		echo '</ol>';
	<?php }
}?> -->


</div>
<?php
}
}
/* {/block 'form'} */
}
