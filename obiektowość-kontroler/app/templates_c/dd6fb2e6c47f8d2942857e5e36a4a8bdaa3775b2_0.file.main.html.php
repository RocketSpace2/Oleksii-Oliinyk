<?php
/* Smarty version 4.3.2, created on 2024-04-02 12:38:18
  from 'D:\Work\XAMPP\htdocs\oleksii-oliinyk\obiektowość-kontroler\templates\main.html' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '4.3.2',
  'unifunc' => 'content_660be01a127d72_11814734',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'dd6fb2e6c47f8d2942857e5e36a4a8bdaa3775b2' => 
    array (
      0 => 'D:\\Work\\XAMPP\\htdocs\\oleksii-oliinyk\\obiektowość-kontroler\\templates\\main.html',
      1 => 1712054295,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_660be01a127d72_11814734 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_loadInheritance();
$_smarty_tpl->inheritance->init($_smarty_tpl, false);
?>
<!doctype html>
<html lang="pl">
<head>
    <meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="<?php echo (($tmp = $_smarty_tpl->tpl_vars['page_description']->value ?? null)===null||$tmp==='' ? "Opis domyślny" ?? null : $tmp);?>
">

    <title><?php echo (($tmp = $_smarty_tpl->tpl_vars['page_title']->value ?? null)===null||$tmp==='' ? "Tytuł domyślny" ?? null : $tmp);?>
</title>

	<link rel="stylesheet" href="<?php echo $_smarty_tpl->tpl_vars['conf']->value->app_url;?>
/css/main.css" />
    <noscript><link rel="stylesheet" href="<?php echo $_smarty_tpl->tpl_vars['conf']->value->app_url;?>
/css/noscript.css" /></noscript>
	
</head>
<body class="<?php if (!(isset($_smarty_tpl->tpl_vars['res']->value))) {?>is-preload<?php }?>">

    <!-- Wrapper -->
        <div id="wrapper">

            <!-- Header -->
                <header id="header" class="alt">
                    <a href="<?php echo $_smarty_tpl->tpl_vars['conf']->value->app_url;?>
" class="logo"><strong>Kalkulator</strong> <span>kredytowy</span></a>
                    <nav>
                        <a href="#menu">Menu</a>
                    </nav>
                </header>

            <!-- Menu -->
                <nav id="menu">
                    <ul class="actions stacked">
                        <li><a href="<?php echo $_smarty_tpl->tpl_vars['conf']->value->app_url;?>
" class="button primary fit">Home</a></li>
                        <li><a href="<?php echo $_smarty_tpl->tpl_vars['conf']->value->app_url;?>
/app/security/logout.php" class="button fit">Log out</a></li>
                    </ul>
                </nav>
            
            <?php if (!(isset($_smarty_tpl->tpl_vars['res']->value))) {?>
            <!-- Banner -->
                <section id="banner" class="major">
                    <div class="inner">
                        <header class="major">
                            <h1>Szablonowanie smarty</h1>
                        </header>
                        <div class="content">
                            <p>Kalkulator kredytowy z wykorzystaniem szablonowania</p>
                        </div>
                        <a href="#form" class="button next scrolly">Get Started</a></li>
                        
                    </div>
                </section>
            <?php }?>

            <hr class="major">

            <?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_1483718944660be01a121f53_96940939', "form");
?>


            <!-- Footer -->
                <footer id="footer">
                    <div class="inner">
                        <ul class="copyright">
                            <li>&copy; Untitled</li>
                            <li>Design: <a href="https://html5up.net">HTML5 UP</a></li>
                            <li>Created (altered) by Oleksii Oliinyk</li>
                        </ul>
                    </div>
                </footer>

        </div>

    <!-- Scripts -->
        <?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['conf']->value->app_url;?>
/js/jquery.min.js"><?php echo '</script'; ?>
>
        <?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['conf']->value->app_url;?>
/js/jquery.scrolly.min.js"><?php echo '</script'; ?>
>
        <?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['conf']->value->app_url;?>
/js/jquery.scrollex.min.js"><?php echo '</script'; ?>
>
        <?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['conf']->value->app_url;?>
/js/browser.min.js"><?php echo '</script'; ?>
>
        <?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['conf']->value->app_url;?>
/js/breakpoints.min.js"><?php echo '</script'; ?>
>
        <?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['conf']->value->app_url;?>
/js/util.js"><?php echo '</script'; ?>
>
        <?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['conf']->value->app_url;?>
/js/main.js"><?php echo '</script'; ?>
>

</body>
</html><?php }
/* {block "form"} */
class Block_1483718944660be01a121f53_96940939 extends Smarty_Internal_Block
{
public $subBlocks = array (
  'form' => 
  array (
    0 => 'Block_1483718944660be01a121f53_96940939',
  ),
);
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>
Default text<?php
}
}
/* {/block "form"} */
}
