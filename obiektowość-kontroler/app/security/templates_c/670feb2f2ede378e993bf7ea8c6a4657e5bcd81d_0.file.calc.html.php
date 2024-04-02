<?php
/* Smarty version 4.3.2, created on 2024-04-02 13:37:32
  from 'D:\Work\XAMPP\htdocs\oleksii-oliinyk\obiektowość-kontroler\app\calc.html' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '4.3.2',
  'unifunc' => 'content_660bedfc1d5ec2_79429586',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '670feb2f2ede378e993bf7ea8c6a4657e5bcd81d' => 
    array (
      0 => 'D:\\Work\\XAMPP\\htdocs\\oleksii-oliinyk\\obiektowość-kontroler\\app\\calc.html',
      1 => 1712054485,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_660bedfc1d5ec2_79429586 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_loadInheritance();
$_smarty_tpl->inheritance->init($_smarty_tpl, true);
?>


<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_228849127660bedfc1c0948_75922617', 'form');
$_smarty_tpl->inheritance->endChild($_smarty_tpl, "../templates/main.html");
}
/* {block 'form'} */
class Block_228849127660bedfc1c0948_75922617 extends Smarty_Internal_Block
{
public $subBlocks = array (
  'form' => 
  array (
    0 => 'Block_228849127660bedfc1c0948_75922617',
  ),
);
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>


<form id="form" method="post" action="<?php echo $_smarty_tpl->tpl_vars['conf']->value->app_url;?>
/app/calc.php">
                <div class="row gtr-uniform">
                    <div class="col-6 off-1">
                        <input type="text" name="loan_am" id="demo-name" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->loan_am;?>
" placeholder="Kwota kredytu" />
                    </div>
                    <div class="col-6 off-1">
                        <input type="text" name="rate" id="demo-email" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->show_rate;?>
" placeholder="Oprocentowanie (%)" />
                    </div>
                    <div class="col-6 off-1">
                        <input type="text" name="term" id="demo-email" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->term;?>
" placeholder="Ilość rat miesięcznych" />
                    </div>
                    <!-- Break  -->
                    <div class="col-12 off-1">
						<?php if ((isset($_smarty_tpl->tpl_vars['res']->value))) {?>
							<h4>Rata miesięczna: <?php echo $_smarty_tpl->tpl_vars['res']->value;?>
 zł</h4>
							<?php }?>
                        <ul class="actions">
                            <li><input type="submit" value="Count" class="primary" /></li>
                        </ul>
                    </div>
                </div>	
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

<?php if ($_smarty_tpl->tpl_vars['msgs']->value->isInfo()) {?>
	<div style="padding-left: 7em;">
		<h4>Informacje: </h4>
		<ol>
		<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['msgs']->value->getInfos(), 'msg');
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

<?php
}
}
/* {/block 'form'} */
}
