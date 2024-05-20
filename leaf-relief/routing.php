<?php

use core\App;
use core\Utils;

App::getRouter()->setDefaultRoute('main_display'); #default action
//App::getRouter()->setLoginRoute('login'); #action to forward if no permissions

Utils::addRoute('main_display', 'MainCtrl');
Utils::addRoute('products_list_display', 'MainCtrl');
Utils::addRoute('products_list_worker_display', 'MainCtrl');
Utils::addRoute('profile_display', 'MainCtrl');
Utils::addRoute('shoping_cart_display', 'MainCtrl');
Utils::addRoute('users_list_display', 'MainCtrl');
Utils::addRoute('login_display', 'MainCtrl');
Utils::addRoute('registration_display', 'MainCtrl');

Utils::addRoute('edit_products_list_worker_display', 'MainCtrl');
Utils::addRoute('edit_profile_display', 'MainCtrl');
Utils::addRoute('edit_users_list_display', 'MainCtrl');
Utils::addRoute('product_display', 'MainCtrl');