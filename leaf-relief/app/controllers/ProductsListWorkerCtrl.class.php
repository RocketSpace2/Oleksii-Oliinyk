<?php
namespace app\controllers;

use core\App;
use core\RoleUtils;
use core\SessionUtils;
use core\Validator;
use core\Message;
use core\ParamUtils;

class ProductsListWorkerCtrl{
    private $form = array();
    private $editing;
    public function __construct(){
        MainConstructor::main_construct();
        
        $this->editing = false;
    }

    public function action_products_list_worker_display(){
        $query = ParamUtils::getFromRequest("query");
        $type = ParamUtils::getFromRequest("type");
        

        if(!isset($query) && !isset($type)){
            $products = App::getDB()->select("product",["[><]type" => "id_type"], ["type_name", "name", "description", "price", "image"]);
        }else{
            $query = $query."%";
            if($type != 0){
                $products = App::getDB()->select("product",["[><]type" => "id_type"], ["type_name", "name", "description", "price", "image"],[
                    "name[~]" =>$query,
                    "id_type" => $type
                ]);
            }else{
                $products = App::getDB()->select("product",["[><]type" => "id_type"], ["type_name", "name", "description", "price", "image"],[
                    "name[~]" =>$query
                ]);
            }
            
        }


        $i = 0;
        while(isset($products[$i])){
            if(strlen($products[$i]["description"]) > 263){
                $products[$i]["description"] = substr($products[$i]["description"],0,262)."...";   
            }

            $products[$i]["image"] = 'data:image/png;base64,'.base64_encode($products[$i]["image"]);

            $i++;
        }
        
        App::getSmarty()->assign("products",$products);
        App::getSmarty()->display("products-list-worker.html");
    }

    public function action_add_product_display(){
        App::getSmarty()->display("add-product.html");
    }

    
    public function validation(){
        $valid = new Validator();
        $this->form["name"] = $valid->validateFromRequest("name",[
            "trim" => true,
            'min_length' => 5,
            'max_length' => 40,
            'validator_message' => 'Nazwa produktu jest za mała lub za duża'
        ]);

        if(!$this->editing){
            $check = App::getDB()->select("product",["name"],["name" => $this->form["name"]]);

            if(isset($check[0]["name"])){
                App::getMessages()->addMessage(new Message("Podana nazwa produktu już istnieje", Message::ERROR));
            }
        }else{
            if($this->form["name"] != SessionUtils::load("name",true)){
                $check = App::getDB()->select("product",["name"],["name" => $this->form["name"]]);

                if(isset($check[0]["name"])){
                    App::getMessages()->addMessage(new Message("Podana nazwa produktu już istnieje", Message::ERROR));
                }
            }
        }

        $this->form["type"] = $valid->validateFromRequest("type");

        $this->form["price"] = $valid->validateFromRequest("price",[
            "trim" => true,
            "float" => true,
            'validator_message' => 'Cena musi być liczbą'
        ]);

        $this->form["description"] = $valid->validateFromRequest("description",[
            'min_length' => 50,
            'validator_message' => 'Opis produkty jest za mały'
        ]);

        
            if(isset($_FILES['image']) && $_FILES['image']['error'] == 0){
                $this->form["image"] = file_get_contents($_FILES['image']['tmp_name']);
            }else{
                if($this->editing){
                    $this->form["image"] = null;
                }else{
                    App::getMessages()->addMessage(new Message("Zdjęcie dla produkty nie zostało podane",Message::ERROR));
                }
            }

        if(!App::getMessages()->isEmpty()){
            if($this->editing){
                $this->action_edit_product_display();
            }else{
                $this->action_add_product_display();
            }
            exit();
        }

    }
    public function action_add_product_worker(){
        $this->validation();

        App::getDB()->insert("product",[
            "id_type" => $this->form["type"],
            "name" => $this->form["name"],
            "description" => $this->form["description"],
            "price" => $this->form["price"],
            "image" => $this->form["image"]
        ]);

        App::getRouter()->forwardTo("products_list_worker_display");
    }

    public function action_delete_product(){
        $name = ParamUtils::getFromRequest("name");

        App::getDB()->delete("product",[
            "name" => $name
        ]);

        App::getRouter()->forwardTo("products_list_worker_display");
    }


    public function action_edit_product_display(){

        if(!$this->editing){
            SessionUtils::store("name", ParamUtils::getFromRequest("name"));
        }


        $product = App::getDB()->select("product",["[><]type" => "id_type"], ["type_name", "name", "description", "price", "image"],[
            "name" =>SessionUtils::load("name",true)
        ]);

        $product[0]["image"] = 'data:image/png;base64,'.base64_encode($product[0]["image"]);


        App::getSmarty()->assign("type_name", $product[0]["type_name"]);
        App::getSmarty()->assign("name", $product[0]["name"]);
        App::getSmarty()->assign("description", $product[0]["description"]);
        App::getSmarty()->assign("price", $product[0]["price"]);
        //App::getSmarty()->assign("image", $product[0]["image"]);

        App::getSmarty()->display("edit-products-list-worker.html");
    }

    public function action_edit_product(){
        $this->editing = true;

        $this->validation();

        if(!isset($this->form["image"])){
            $image = App::getDB()->select("product", ["image"],[
                "name" => SessionUtils::load("name", true)
            ]);
            $this->form["image"] = $image[0]["image"];

        }

        App::getDB()->update("product",[
            "id_type" => $this->form["type"],
            "name" => $this->form["name"],
            "description" => $this->form["description"],
            "price" => $this->form["price"],
            "image" => $this->form["image"]
        ],[
            "name" => SessionUtils::load("name", true)
        ]
        );

        App::getRouter()->redirectTo("products_list_worker_display");
    }
} 