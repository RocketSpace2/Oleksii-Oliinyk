<?php
namespace app\controllers;

use core\App;
use core\Message;
use core\ParamUtils;
use core\Validator;
use core\SessionUtils;
use core\RoleUtils;

class ProductListCtrl{
    public function __construct(){
        MainConstructor::main_construct();
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

    public function action_add_product(){
        $valid = new Validator();
        
        $name = $valid->validateFromRequest("name");

        $amount = $valid->validateFromRequest("amount",[
            "trim" => true,
            "int" => true,
            "min" => 1,
            'validator_message' => 'ERROR'
        ]);

        if(!App::getMessages()->isEmpty()){
            App::getRouter()->forwardTo("product_display");
        }

        $user = App::getDB()->select("user",["id_user"],[
            "login" => SessionUtils::load("login",true)
        ]);

        $id_user = $user[0]["id_user"];


        //Checking whether there is any order for current user and whether it's still not ordered or confirmed 
//____________________________________________________________________________________________________________
        
        $order = App::getDB()->select("order",["id_order"],[
            "id_user" => $id_user,
            "id_state" => 1
        ]);

        if(!isset($order[0]["id_order"])){
            App::getDB()->insert("order",[
                "id_user" => $id_user,
                "id_state" => 1
            ]);

            $order = App::getDB()->select("order",["id_order"],[
                "id_user" => $id_user,
                "id_state" => 1
            ]);
        }
        
        // 
//____________________________________________________________________________________________________________

        $produt = App::getDB()->select("product",["id_product"],[
            "name" => $name
        ]);

        $id_product = $produt[0]["id_product"];
        $id_order = $order[0]["id_order"];

        //checking whether there is already such row in order_product table
        $order_product = App::getDB()->select("order_product",["id_order"],[
            "id_order" => $id_order,
            "id_product" => $id_product
        ]);

        if(!isset($order_product[0]["id_order"])){
            App::getDB()->insert("order_product",[
                "id_order" => $id_order,
                "id_product" => $id_product,
                "amount" => $amount
            ]);
        }else{
            App::getMessages()->addMessage(new Message("Dany produkt jest już w koszyku", Message::WARNING));
            App::getRouter()->forwardTo("product_display");
        }

        App::getRouter()->forwardTo("products_list_display");
        
    }

} 