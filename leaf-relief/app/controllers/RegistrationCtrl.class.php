<?php
namespace app\controllers;

use core\App;
use core\RoleUtils;
use core\ParamUtils;
use core\Message;
use core\Validator;
use core\SessionUtils;
class RegistrationCtrl{

    private $form = array();

    public function __construct(){
        MainConstructor::main_construct();
    }

    public function action_registration_display(){
        App::getSmarty()->display("registration.html");
    }

    public function validation(){
        $valid = new Validator();

        $this->form["login"] = $valid->validateFromRequest("login",[
            'trim' => true,
            'required' => true,
            'min_length' => 3,
            'max_length' => 15,
            'validator_message' => 'Login jest za długi lub za krótki'
        ]);

        $this->form["password"] = $valid->validateFromRequest("password",[
            'trim' => true,
            'required' => true,
            'min_length' => 5,
            'max_length' => 15,
            'validator_message' => 'Hasło jest za długie lub za krótkie'
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
            'required' => true,
            'min_length' => 3,
            'max_length' => 15,
            'validator_message' => 'Nazwa ulicy jest za długa lub za krótka'
        ]);

        $this->form["street_number"] = $valid->validateFromRequest("street_number",[
            'required' => true,
            'trim' => true,
            'int' => true,
            'validator_message' => 'Numer ulicy musi być liczbą'
        ]);

        $this->form["apartment_number"] = $valid->validateFromRequest("apartment_number",[
            
            'trim' => true,
            'int' => true,
            'validator_message' => 'Numer lokalu musi być liczbą'
        ]);
        
        $this->form["postcode"] = ParamUtils::getFromRequest("postcode");
        
        //Login validation
//__________________________________________________________________________________________________________________        

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

        if(!App::getMessages()->isEmpty()){
            $this->action_registration_display();
            exit();
        }
    }

    public function findIdAddres(){
        $results = App::getDB()->select("addres",["id_addres"],[
            "postcode" => $this->form["postcode"],
            "city" => $this->form["city"],
            "street" => $this->form["street"],
            "street_number" => $this->form["street_number"],
            "apartment_number" => $this->form["apartment_number"]
        ]);

        return isset($results[0]["id_addres"]) ? $results[0]["id_addres"] : null;
    }

    public function findIdUser(){
        $results = App::getDB()->select("user",["id_user"],[
            "login" => $this->form["login"]
        ]);

        return $results[0]["id_user"];
    }

    public function action_registrate(){
        $this->validation();

        SessionUtils::store("login",$this->form["login"]);
        SessionUtils::store("city",$this->form["city"]);
        SessionUtils::store("street",$this->form["street"]);
        SessionUtils::store("street_number",$this->form["street_number"]);
        SessionUtils::store("apartment_number",$this->form["apartment_number"]);
        SessionUtils::store("postcode",$this->form["postcode"]);

        $id_addres = $this->findIdAddres();

        if(!isset($id_addres)){

            App::getDB()->insert("addres",[
                "postcode" => $this->form["postcode"],
                "city" => $this->form["city"],
                "street" => $this->form["street"],
                "street_number" => $this->form["street_number"],
                "apartment_number" => $this->form["apartment_number"]
            ]);

            $id_addres = $this->findIdAddres();
        }

        

        $this->form["password"] = password_hash($this->form["password"], PASSWORD_ARGON2ID);

        App::getDB()->insert("user",[
            "id_addres" => $id_addres,
            "login" => $this->form["login"],
            "password" => $this->form["password"]
        ]);

        

        $id_user = $this->findIdUser();

        App::getDB()->insert("catalog_user",[

            "id_role" => 1,//1 -> user

            "id_user" => $id_user,
            
            "date_of_activation" => date("Y-m-d H:i:s")


        ]);

    
        RoleUtils::addRole("user");

        App::getRouter()->forwardTo("main_display");
    }
}