<?php

namespace app\controllers;

use app\controllers\MainConstructor;
use core\App;
use core\ParamUtils;
use core\SessionUtils;

class OrdersCtrl{

    public function __construct(){
        MainConstructor::main_construct();
    }

    public function action_orders(){
        $order = App::getDB()->select("order",["[><]user" => "id_user"],["id_order","id_user"],[
            "id_state" => 2
        ]);

        $empty = null;
        $products_user = array(array(
            "products" => null,
            "user" => null,
            "sum" => null
        ));

        if(isset($order[0])){

            $j = 0;

            while(isset($order[$j])){
                    //taking products from data base
                $id_order = $order[$j]["id_order"];

                $products = App::getDB()->select("order_product",["[><]product" => "id_product"],["id_product", "name","description","price","amount","image"],[
                    "id_order" => $id_order
                ]);

            
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


                    //taking user from data base
                    $id_user = $order[$j]["id_user"];
                    $user = App::getDB()->select("user",["[><]addres" => "id_addres"],
                    ["login","city", "postcode","street","street_number","apartment_number"],[
                        "id_user" => $id_user
                    ]);

                    $products_user[$j]["products"] = $products;
                    $products_user[$j]["user"] = $user[0];
                    $products_user[$j]["sum"] = $sum;

                $j++;
            }
            
            App::getSmarty()->assign("products_user",$products_user);
        }else{
            $empty = "Brak zamówień";
            
        }

        App::getSmarty()->assign("empty",$empty);
        
        App::getSmarty()->display("orders.html");
    }

    public function action_confirm_order(){
        $login = ParamUtils::getFromRequest("login");
        $order = App::getDB()->select("order",["[><]user" => "id_user"],["id_order"],[
            "id_state" => 2,
            "login" => $login
        ]);

        $id_order = $order[0]["id_order"];

        App::getDB()->update("order",["id_state" => 3],[
            "id_order" => $id_order
        ]);

        App::getRouter()->forwardTo("orders");
    }
} 