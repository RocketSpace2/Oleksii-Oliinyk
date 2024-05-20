<?php
namespace app\controllers;

use core\App;

class MainCtrl{

    public function action_main_display(){
        App::getSmarty()->assign("conf",App::getConf()->app_url);
        App::getSmarty()->display("main.html");
    }
    public function action_products_list_display(){
        App::getSmarty()->assign("conf",App::getConf()->app_url);
        App::getSmarty()->display("products-list.html");
    }
    public function action_products_list_worker_display(){
        App::getSmarty()->assign("conf",App::getConf()->app_url);
        App::getSmarty()->display("products-list-worker.html");
    }
    public function action_profile_display(){
        App::getSmarty()->assign("conf",App::getConf()->app_url);
        App::getSmarty()->display("profile.html");
    }
    public function action_shoping_cart_display(){
        App::getSmarty()->assign("conf",App::getConf()->app_url);
        App::getSmarty()->display("shoping-cart.html");
    }
    public function action_users_list_display(){
        App::getSmarty()->assign("conf",App::getConf()->app_url);
        App::getSmarty()->display("users-list.html");
    }
    public function action_login_display(){
        App::getSmarty()->assign("conf",App::getConf()->app_url);
        App::getSmarty()->display("login.html");
    }
    public function action_registration_display(){
        App::getSmarty()->assign("conf",App::getConf()->app_url);
        App::getSmarty()->display("registration.html");
    }
    public function action_edit_products_list_worker_display(){
        App::getSmarty()->assign("conf",App::getConf()->app_url);
        App::getSmarty()->display("edit-products-list-worker.html");
    }
    public function action_edit_profile_display(){
        App::getSmarty()->assign("conf",App::getConf()->app_url);
        App::getSmarty()->display("edit-profile.html");
    }
    public function action_edit_users_list_display(){
        App::getSmarty()->assign("conf",App::getConf()->app_url);
        App::getSmarty()->display("edit-users-list.html");
    }
    public function action_product_display(){
        App::getSmarty()->assign("conf",App::getConf()->app_url);
        App::getSmarty()->display("product.html");
    }
}