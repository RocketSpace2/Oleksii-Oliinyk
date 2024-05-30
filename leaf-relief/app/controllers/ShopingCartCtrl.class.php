<?php
namespace app\controllers;

use core\App;
use core\ParamUtils;
use core\RoleUtils;
use core\SessionUtils;

class ShopingCartCtrl{
    public function __construct(){
       MainConstructor::main_construct();
    }

    public function action_shoping_cart_display(){
        $order = App::getDB()->select("order",["[><]user" => "id_user"],["id_order"],[
            "login" => SessionUtils::load("login", true),
            "id_state" => 1
        ]);

        $empty = null;

        if(isset($order[0]["id_order"])){

            $id_order = $order[0]["id_order"];

            $products = App::getDB()->select("order_product",["[><]product" => "id_product"],["id_product", "name","description","price","amount","image"],[
                "id_order" => $id_order
            ]);

            if(isset($products[0]["id_product"])){
                $sum = 0;

                $i = 0;
                while(isset($products[$i])){
                if(strlen($products[$i]["description"]) > 263){
                    $products[$i]["description"] = substr($products[$i]["description"],0,262)."...";   
                }

                $products[$i]["image"] = 'data:image/png;base64,'.base64_encode($products[$i]["image"]);

                $amount = $products[$i]["amount"];

                $price = $products[$i]["price"];

                $sum = $sum + ($amount * $price);

                $i++;
                }

                App::getSmarty()->assign("sum",$sum);
                App::getSmarty()->assign("products",$products); 
            }else{
                $empty = "Koszyk jest pusty";
            }
        }else{
            $empty = "Koszyk jest pusty";
            
        }
        
        App::getSmarty()->assign("empty",$empty); 
        App::getSmarty()->display("shoping-cart.html");
    }

    public function action_minus_product(){
        $order = App::getDB()->select("order",["[><]user" => "id_user"],["id_order"],[
            "login" => SessionUtils::load("login", true),
            "id_state" => 1
        ]);

        $id_order = $order[0]["id_order"];

        $name = ParamUtils::getFromRequest("name");

        $product =$product = App::getDB()->select("product",["id_product"],[
            "name" => $name
        ]);

        $id_product = $product[0]["id_product"];

        $order_product = App::getDB()->select("order_product",["amount"],[
            "id_order" => $id_order,
            "id_product" => $id_product
        ]);

        if($order_product[0]["amount"] > 1){
            $amount = $order_product[0]["amount"];
            $amount--;

            App::getDB()->update("order_product",["amount" => $amount],[
                "id_order" => $id_order,
                "id_product" => $id_product
            ]);
        }

        App::getRouter()->redirectTo("shoping_cart_display");
    }

    public function action_plus_product(){
        $order = App::getDB()->select("order",["[><]user" => "id_user"],["id_order"],[
            "login" => SessionUtils::load("login", true),
            "id_state" => 1
        ]);

        $id_order = $order[0]["id_order"];

        $name = ParamUtils::getFromRequest("name");

        $product =$product = App::getDB()->select("product",["id_product"],[
            "name" => $name
        ]);

        $id_product = $product[0]["id_product"];

        $order_product = App::getDB()->select("order_product",["amount"],[
            "id_order" => $id_order,
            "id_product" => $id_product
        ]);

            $amount = $order_product[0]["amount"];
            $amount++;

            App::getDB()->update("order_product",["amount" => $amount],[
                "id_order" => $id_order,
                "id_product" => $id_product
            ]);

        App::getRouter()->redirectTo("shoping_cart_display");
    }

    public function action_delete_product_cart(){
        $order = App::getDB()->select("order",["[><]user" => "id_user"],["id_order"],[
            "login" => SessionUtils::load("login", true),
            "id_state" => 1
        ]);

        $id_order = $order[0]["id_order"];

        $name = ParamUtils::getFromRequest("name");

        $product =$product = App::getDB()->select("product",["id_product"],[
            "name" => $name
        ]);

        $id_product = $product[0]["id_product"];

        App::getDB()->delete("order_product",[
            "id_order" => $id_order,
            "id_product" => $id_product
        ]);

        App::getRouter()->redirectTo("shoping_cart_display");
    }
    
    public function action_submit_order(){
        $order = App::getDB()->select("order",["[><]user" => "id_user"],["id_order"],[
            "login" => SessionUtils::load("login", true),
            "id_state" => 1
        ]);

        $id_order = $order[0]["id_order"];

        App::getDB()->update("order",[
            "id_state" => 2
        ],[
            "id_order" =>$id_order,
            "id_state" => 1
        ]);

        MainConstructor::count_products_cart();
        
        App::getSmarty()->display("shoping-cart-submited.html");
    }
}