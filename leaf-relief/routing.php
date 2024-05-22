<?php

use core\App;
use core\Utils;

App::getRouter()->setDefaultRoute('main_display'); #default action
App::getRouter()->setLoginRoute('login_display'); #action to forward if no permissions

Utils::addRoute('main_display', 'MainCtrl');
Utils::addRoute('products_list_display', 'MainCtrl');
Utils::addRoute('products_list_worker_display', 'MainCtrl');
Utils::addRoute('profile_display', 'MainCtrl',["user"]);
Utils::addRoute('shoping_cart_display', 'MainCtrl',["user"]);
Utils::addRoute('users_list_display', 'MainCtrl');
Utils::addRoute('login_display', 'MainCtrl');

Utils::addRoute('edit_products_list_worker_display', 'MainCtrl');
Utils::addRoute('edit_profile_display', 'MainCtrl');
Utils::addRoute('edit_users_list_display', 'MainCtrl');
Utils::addRoute('product_display', 'MainCtrl');


Utils::addRoute('registration_display', 'RegistrationCtrl');
Utils::addRoute('registrate', 'RegistrationCtrl');