<?php
/* Smarty version 4.3.2, created on 2024-04-02 18:41:23
  from 'D:\Work\XAMPP\htdocs\oleksii-oliinyk\obiektowość-kontroler\app\security\login_view.php' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '4.3.2',
  'unifunc' => 'content_660c35335aef57_00687246',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '7198ade602602f416d9b4e18f5155815fcfc01e9' => 
    array (
      0 => 'D:\\Work\\XAMPP\\htdocs\\oleksii-oliinyk\\obiektowość-kontroler\\app\\security\\login_view.php',
      1 => 1712076080,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_660c35335aef57_00687246 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_loadInheritance();
$_smarty_tpl->inheritance->init($_smarty_tpl, true);
?>


<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_2060933725660c35335a0567_62934634', 'form');
$_smarty_tpl->inheritance->endChild($_smarty_tpl, "../../templates/main.html");
}
/* {block 'form'} */
class Block_2060933725660c35335a0567_62934634 extends Smarty_Internal_Block
{
public $subBlocks = array (
  'form' => 
  array (
    0 => 'Block_2060933725660c35335a0567_62934634',
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
	<div><!-- <div style="padding-left: 4em;"> -->
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
