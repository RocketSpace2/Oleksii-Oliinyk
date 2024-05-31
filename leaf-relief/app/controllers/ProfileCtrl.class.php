<?php
namespace app\controllers;

use core\App;
use core\RoleUtils;
use core\Message;
use core\SessionUtils;
use core\Validator;
use core\ParamUtils;

class ProfileCtrl{
    private $form = array();
    private $user = array();
    public function __construct(){
        App::getSmarty()->assign("isUser",RoleUtils::inRole("user"));
        App::getSmarty()->assign("isWorker",RoleUtils::inRole("worker"));
        App::getSmarty()->assign("isAdmin",RoleUtils::inRole("admin"));

        $result = App::getDB()->select("user",["[><]addres" => "id_addres"],
        ["login","city","postcode","street", "street_number","apartment_number","image"],[
            "login" => SessionUtils::load("login",true)
        ]);

        $this->user["login"] = $result[0]["login"];
        SessionUtils::store("login",$this->user["login"]);
        $this->user["city"] = $result[0]["city"];
        $this->user["postcode"] = $result[0]["postcode"];
        $this->user["street"] = $result[0]["street"];
        $this->user["street_number"] = $result[0]["street_number"];
        $this->user["apartment_number"] = $result[0]["apartment_number"];
        $this->user["image"] = $result[0]["image"];
        
        
        if(isset($this->user["image"])){
            $this->user["image"] = 'data:image/png;base64,'.base64_encode($this->user["image"]);
        }
        
       
        App::getSmarty()->assign("login",$this->user["login"]);    
        App::getSmarty()->assign("city",$this->user["city"]); 
        App::getSmarty()->assign("street",$this->user["street"]); 
        App::getSmarty()->assign("street_number",$this->user["street_number"]); 
        App::getSmarty()->assign("apartment_number",$this->user["apartment_number"]); 
        App::getSmarty()->assign("postcode",$this->user["postcode"]);  
        App::getSmarty()->assign("image",$this->user["image"]);    
        App::getSmarty()->assign("conf",App::getConf()->app_url);

        MainConstructor::count_products_cart();
    }

    public function action_profile_display(){
        App::getSmarty()->display("profile.html");
    }

    public function action_edit_profile_display(){
        App::getSmarty()->display("edit-profile.html");
    }

    public function validation(){
        $valid = new Validator();

        $this->form["login"] = $valid->validateFromRequest("login",[
            'trim' => true,
            'min_length' => 3,
            'max_length' => 15,
            'validator_message' => 'Login jest za długi lub za krótki'
        ]);

        $this->form["city"] = $valid->validateFromRequest("city",[
            'trim' => true,
            'required' => true,
            'min_length' => 3,
            'max_length' => 15,
            'validator_message' => 'Nazwa mista jest za długa lub za krótka'
        ]);

        $this->form["street"] = $valid->validateFromRequest("street",[
            'trim' => true,
            'min_length' => 3,
            'max_length' => 15,
            'validator_message' => 'Nazwa ulicy jest za długa lub za krótka'
        ]);

        $this->form["street_number"] = $valid->validateFromRequest("street_number",[
            'trim' => true,
            'int' => true,
            'validator_message' => 'Numer ulicy musi być liczbą'
        ]);

        if(isset($this->user["apartment_number"])){
            $this->form["apartment_number"] = $valid->validateFromRequest("apartment_number",[
                'trim' => true,
                'int' => true,
                'validator_message' => 'Numer lokalu musi być liczbą'
            ]);
        }
        
        $this->form["postcode"] = ParamUtils::getFromRequest("postcode");
        
        //Login validation
//__________________________________________________________________________________________________________________  
        
        if($this->form["login"] != $this->user["login"])
        $user = App::getDB()->select("user", ["login"], ["login" => $this->form["login"]]);

        if(isset($user[0]["login"])){
            App::getMessages()->addMessage(new Message("Podany login jest już zajęty",Message::ERROR));
        }

        //Postcode validation
//__________________________________________________________________________________________________________________

        if(strlen($this->form["postcode"]) != 6){

            App::getMessages()->addMessage(new Message("Podany kod pocztowy jest niepoprawny",Message::ERROR));

        }else if(!preg_match('/^\d{2}-\d{3}$/', $this->form["postcode"])){

            App::getMessages()->addMessage(new Message("Podany kod pocztowy jest niepoprawny",Message::ERROR));

        }

        if(isset($_FILES['image']) && $_FILES['image']['error'] == 0){
            $this->form["image"] = file_get_contents($_FILES['image']['tmp_name']);
        }else{
            $image = App::getDB()->select("user",["image"],[
                "login" => $this->user["login"]
            ]);

            $this->form["image"] = $image[0]["image"];
        }

        if(!App::getMessages()->isEmpty()){
            $this->action_edit_profile_display();
            exit();
        }
    }

    public function action_edit_profile(){
        $this->validation();

        $login_tmp = $this->user["login"];

        $addres = App::getDB()->select("addres","*",[
            "city" => $this->user["city"],
            "street" => $this->user["street"],
            "street_number" => $this->user["street_number"],
            "apartment_number" => $this->user["apartment_number"],
            "postcode" => $this->user["postcode"]
        ]);

        $id_addres = $addres[0]["id_addres"];

        $result_user =  App::getDB()->select("user","*",[
           "id_addres" => $id_addres
        ]);

        SessionUtils::store("login",$this->form["login"]);

        

        if(count($result_user) < 2){
            App::getDB()->update("addres",[
                "city" => $this->form["city"],
                "street" => $this->form["street"],
                "street_number" => $this->form["street_number"],
                "apartment_number" => $this->form["apartment_number"],
                "postcode" => $this->form["postcode"]
            ],[
                "city" => $addres[0]["city"],
                "street" => $addres[0]["street"],
                "street_number" => $addres[0]["street_number"],
                "apartment_number" => $addres[0]["apartment_number"],
                "postcode" => $addres[0]["postcode"]
            ]);
        }else{
            App::getDB()->insert("addres",[
                "city" => $this->form["city"],
                "street" => $this->form["street"],
                "street_number" => $this->form["street_number"],
                "apartment_number" => $this->form["apartment_number"],
                "postcode" => $this->form["postcode"]
            ]);
        }

        $addres = App::getDB()->select("addres",["id_addres"],[
            "city" => $this->form["city"],
            "street" => $this->form["street"],
            "street_number" => $this->form["street_number"],
            "apartment_number" => $this->form["apartment_number"],
            "postcode" => $this->form["postcode"]
        ]);

        $id_addres = $addres[0]["id_addres"];

        App::getDB()->update("user",[
            "login" => SessionUtils::load("login", true),
            "id_addres" => $id_addres,
            "image" => $this->form["image"]
        ],[
            "login" =>$login_tmp
        ]);

        App::getRouter()->forwardTo("profile_display");
    }

}