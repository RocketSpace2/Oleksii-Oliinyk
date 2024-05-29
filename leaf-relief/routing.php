<?php

use core\App;
use core\Utils;

App::getRouter()->setDefaultRoute('main_display'); #default action
App::getRouter()->setLoginRoute('login_display'); #action to forward if no permissions

Utils::addRoute('main_display', 'MainCtrl');
Utils::addRoute('products_list_display', 'MainCtrl');
Utils::addRoute('products_list_worker_display', 'MainCtrl',["worker"]);
Utils::addRoute('shoping_cart_display', 'MainCtrl',["user"]);


Utils::addRoute('edit_products_list_worker_display', 'MainCtrl');

Utils::addRoute('product_display', 'MainCtrl');


Utils::addRoute('registration_display', 'RegistrationCtrl');
Utils::addRoute('registrate', 'RegistrationCtrl');

Utils::addRoute('login_display', 'LoginCtrl');
Utils::addRoute('logout', 'LoginCtrl');
Utils::addRoute('login', 'LoginCtrl');

Utils::addRoute('users_list_display', 'UserListCtrl',["admin"]);
Utils::addRoute('filter_users_list', 'UserListCtrl',["admin"]);
Utils::addRoute('edit_users_list', 'UserListCtrl',["admin"]);
Utils::addRoute('edit_user', 'UserListCtrl',["admin"]);

Utils::addRoute('profile_display', 'ProfileCtrl',["user"]);
Utils::addRoute('edit_profile_display', 'ProfileCtrl',["user"]);
Utils::addRoute('edit_profile', 'ProfileCtrl',["user"]);