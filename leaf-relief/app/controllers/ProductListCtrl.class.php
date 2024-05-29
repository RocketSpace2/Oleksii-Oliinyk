<?php
namespace app\controllers;

use core\App;
use core\ParamUtils;
use core\Validator;
use core\SessionUtils;
use core\RoleUtils;

class ProductListCtrl{
    public function __construct(){
        App::getSmarty()->assign("isUser",RoleUtils::inRole("user"));
        App::getSmarty()->assign("isWorker",RoleUtils::inRole("worker"));
        App::getSmarty()->assign("isAdmin",RoleUtils::inRole("admin"));
        
        $login = SessionUtils::load("login", true);
       
        App::getSmarty()->assign("login",$login);       
        App::getSmarty()->assign("conf",App::getConf()->app_url);
    }

    public function action_products_list_display(){
        $products = App::getDB()->select("product",["[><]type" => "id_type"],["type_name", "name", "description", "price", "image"]);


        $i = 0;
        while(isset($products[$i])){
            if(strlen($products[$i]["description"]) > 263){
                $products[$i]["description"] = substr($products[$i]["description"],0,262)."...";   
            }

            $products[$i]["image"] = 'data:image/png;base64,'.base64_encode($products[$i]["image"]);

            $i++;
        }
        
        App::getSmarty()->assign("products",$products);
        App::getSmarty()->display("products-list.html");

    }

    public function action_filter_products(){
        //$valid = new Validator();
        
        $query = ParamUtils::getFromRequest("query");

        if(isset($name)){
            $query = $query.'%';
        }

        
        $products = App::getDB()->select("product",["[><]type" => "id_type"],["type_name", "name", "description", "price", "image"], [
            "name[~]" => $query
        ]);


        $i = 0;
        while(isset($products[$i])){
            if(strlen($products[$i]["description"]) > 263){
                $products[$i]["description"] = substr($products[$i]["description"],0,262)."...";   
            }

            $products[$i]["image"] = 'data:image/png;base64,'.base64_encode($products[$i]["image"]);

            $i++;
        }
        
        App::getSmarty()->assign("products",$products);
        App::getSmarty()->display("products-list.html");
    }

    public function action_product_display(){
        $name = ParamUtils::getFromRequest("name");

        $product = App::getDB()->select("product",["[><]type" => "id_type"],["type_name", "name", "description", "price", "image"], [
            "name" => $name
        ]);

        $product[0]["image"] = 'data:image/png;base64,'.base64_encode($product[0]["image"]);

        App::getSmarty()->assign("name",$product[0]["name"]);
        App::getSmarty()->assign("type_name",$product[0]["type_name"]);
        App::getSmarty()->assign("description",$product[0]["description"]);
        App::getSmarty()->assign("price",$product[0]["price"]);
        App::getSmarty()->assign("image",$product[0]["image"]);

        App::getSmarty()->display("product.html");
    }

} 