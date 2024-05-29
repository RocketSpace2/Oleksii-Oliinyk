<?php
namespace app\controllers;

use core\App;
use core\RoleUtils;
use core\SessionUtils;

class MainCtrl{

    public function __construct(){
        App::getSmarty()->assign("isUser",RoleUtils::inRole("user"));
        App::getSmarty()->assign("isWorker",RoleUtils::inRole("worker"));
        App::getSmarty()->assign("isAdmin",RoleUtils::inRole("admin"));
        
        $login = SessionUtils::load("login", true);
       
        App::getSmarty()->assign("login",$login);       
        App::getSmarty()->assign("conf",App::getConf()->app_url);
    }
    public function action_main_display(){

        App::getSmarty()->display("main.html");
    }
    public function action_products_list_display(){
        App::getSmarty()->display("products-list.html");
    }
    
    
    public function action_shoping_cart_display(){
        App::getSmarty()->display("shoping-cart.html");
    }
    
    
    public function action_edit_products_list_worker_display(){
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