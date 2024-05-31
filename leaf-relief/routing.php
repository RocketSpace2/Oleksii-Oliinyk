<?php

use core\App;
use core\Utils;

App::getRouter()->setDefaultRoute('main_display'); #default action
App::getRouter()->setLoginRoute('login_display'); #action to forward if no permissions

Utils::addRoute('main_display', 'MainCtrl');






Utils::addRoute('registration_display', 'RegistrationCtrl');
Utils::addRoute('registrate', 'RegistrationCtrl');

Utils::addRoute('login_display', 'LoginCtrl');
Utils::addRoute('logout', 'LoginCtrl');
Utils::addRoute('login', 'LoginCtrl');

Utils::addRoute('users_list_display', 'UserListCtrl',["admin"]);
Utils::addRoute('filter_users_list', 'UserListCtrl',["admin"]);
Utils::addRoute('edit_users_list', 'UserListCtrl',["admin"]);
Utils::addRoute('edit_user', 'UserListCtrl',["admin"]);
Utils::addRoute('delete_user', 'UserListCtrl',["admin"]);

Utils::addRoute('profile_display', 'ProfileCtrl',["user"]);
Utils::addRoute('edit_profile_display', 'ProfileCtrl',["user"]);
Utils::addRoute('edit_profile', 'ProfileCtrl',["user"]);

Utils::addRoute('products_list_worker_display', 'ProductsListWorkerCtrl',["worker"]);
Utils::addRoute('add_product_display', 'ProductsListWorkerCtrl',["worker"]);
Utils::addRoute('add_product_worker', 'ProductsListWorkerCtrl',["worker"]);
Utils::addRoute('delete_product', 'ProductsListWorkerCtrl',["worker"]);
Utils::addRoute('edit_product_display', 'ProductsListWorkerCtrl',["worker"]);
Utils::addRoute('edit_product', 'ProductsListWorkerCtrl',["worker"]);


Utils::addRoute('orders', 'OrdersCtrl',["worker"]);
Utils::addRoute('confirm_order', 'OrdersCtrl',["worker"]);


Utils::addRoute('products_list_display', 'ProductListCtrl');
Utils::addRoute('filter_products', 'ProductListCtrl');
Utils::addRoute('product_display', 'ProductListCtrl');
Utils::addRoute('add_product', 'ProductListCtrl',["user"]);

Utils::addRoute('shoping_cart_display', 'ShopingCartCtrl',["user"]);
Utils::addRoute('minus_product', 'ShopingCartCtrl',["user"]);
Utils::addRoute('plus_product', 'ShopingCartCtrl',["user"]);
Utils::addRoute('delete_product_cart', 'ShopingCartCtrl',["user"]);
Utils::addRoute('submit_order', 'ShopingCartCtrl',["user"]);