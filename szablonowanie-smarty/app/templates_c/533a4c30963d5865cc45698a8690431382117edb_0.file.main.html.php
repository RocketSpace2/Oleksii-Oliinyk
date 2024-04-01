<?php
/* Smarty version 4.3.2, created on 2024-03-25 10:02:05
  from 'D:\Work\XAMPP\htdocs\oleksii-oliinyk\szablonowanie-smarty\templates\main.html' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '4.3.2',
  'unifunc' => 'content_66013d8d816b52_36237692',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '533a4c30963d5865cc45698a8690431382117edb' => 
    array (
      0 => 'D:\\Work\\XAMPP\\htdocs\\oleksii-oliinyk\\szablonowanie-smarty\\templates\\main.html',
      1 => 1711307775,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_66013d8d816b52_36237692 (Smarty_Internal_Template $_smarty_tpl) {
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

	<link rel="stylesheet" href="<?php echo $_smarty_tpl->tpl_vars['app_url']->value;?>
/css/main.css" />
    <noscript><link rel="stylesheet" href="<?php echo $_smarty_tpl->tpl_vars['app_url']->value;?>
/css/noscript.css" /></noscript>
	
</head>
<body class="<?php if (!(isset($_smarty_tpl->tpl_vars['result']->value))) {?>is-preload<?php }?>">

    <!-- Wrapper -->
        <div id="wrapper">

            <!-- Header -->
                <header id="header" class="alt">
                    <a href="<?php echo $_smarty_tpl->tpl_vars['app_url']->value;?>
" class="logo"><strong>Kalkulator</strong> <span>kredytowy</span></a>
                    <nav>
                        <a href="#menu">Menu</a>
                    </nav>
                </header>

            <!-- Menu -->
                <nav id="menu">
                    <ul class="actions stacked">
                        <li><a href="<?php echo $_smarty_tpl->tpl_vars['app_url']->value;?>
" class="button primary fit">Home</a></li>
                        <li><a href="<?php echo $_smarty_tpl->tpl_vars['app_url']->value;?>
/app/security/logout.php" class="button fit">Log out</a></li>
                    </ul>
                </nav>
            
            <?php if (!(isset($_smarty_tpl->tpl_vars['result']->value))) {?>
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
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_92736582266013d8d815bd0_71903432', "form");
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
 src="<?php echo $_smarty_tpl->tpl_vars['app_url']->value;?>
/js/jquery.min.js"><?php echo '</script'; ?>
>
        <?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['app_url']->value;?>
/js/jquery.scrolly.min.js"><?php echo '</script'; ?>
>
        <?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['app_url']->value;?>
/js/jquery.scrollex.min.js"><?php echo '</script'; ?>
>
        <?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['app_url']->value;?>
/js/browser.min.js"><?php echo '</script'; ?>
>
        <?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['app_url']->value;?>
/js/breakpoints.min.js"><?php echo '</script'; ?>
>
        <?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['app_url']->value;?>
/js/util.js"><?php echo '</script'; ?>
>
        <?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['app_url']->value;?>
/js/main.js"><?php echo '</script'; ?>
>

</body>
</html><?php }
/* {block "form"} */
class Block_92736582266013d8d815bd0_71903432 extends Smarty_Internal_Block
{
public $subBlocks = array (
  'form' => 
  array (
    0 => 'Block_92736582266013d8d815bd0_71903432',
  ),
);
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>
Default text<?php
}
}
/* {/block "form"} */
}
