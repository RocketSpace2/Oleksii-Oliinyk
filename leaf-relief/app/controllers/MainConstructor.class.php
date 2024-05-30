<?php
namespace app\controllers;

use core\App;
use core\RoleUtils;
use core\SessionUtils;
class MainConstructor{
    public static function main_construct(){
        App::getSmarty()->assign("isUser",RoleUtils::inRole("user"));
        App::getSmarty()->assign("isWorker",RoleUtils::inRole("worker"));
        App::getSmarty()->assign("isAdmin",RoleUtils::inRole("admin"));
        
        $login = SessionUtils::load("login", true);
       
        App::getSmarty()->assign("login",$login);       
        App::getSmarty()->assign("conf",App::getConf()->app_url);
        self::count_products_cart();
    }

    public static function count_products_cart(){
        $order = App::getDB()->select("order",["[><]user" => "id_user"],["id_order"],[
            "login" => SessionUtils::load("login", true),
            "id_state" => 1
        ]);

        $product_amount = null;

        if(isset($order[0]["id_order"])){

            $id_order = $order[0]["id_order"];

            $products = App::getDB()->select("order_product",["id_product"],[
                "id_order" => $id_order
            ]);

            $product_amount = count($products);            
        }

        App::getSmarty()->assign("product_amount",$product_amount);
    }

}