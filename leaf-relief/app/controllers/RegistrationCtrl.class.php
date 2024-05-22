<?php
namespace app\controllers;

use core\App;
use core\RoleUtils;
use core\ParamUtils;
use core\Validator;

class RegistrationCtrl{

    private $form = array();

    public function __construct(){
        App::getSmarty()->assign("isUser",RoleUtils::inRole("user"));
        App::getSmarty()->assign("isWorker",RoleUtils::inRole("worker"));
        App::getSmarty()->assign("isAdmin",RoleUtils::inRole("admin"));
       
        App::getSmarty()->assign("conf",App::getConf()->app_url);
    }

    public function action_registration_display(){
        App::getSmarty()->display("registration.html");
    }

    public function validation(){
        $this->form["login"] = ParamUtils::getFromRequest("login",true,"Dane pole jest wymagane");
        $this->form["password"] = ParamUtils::getFromRequest("password",true,"Dane pole jest wymagane");
        $this->form["postcode"] = ParamUtils::getFromRequest("postcode",true,"Dane pole jest wymagane");
        $this->form["city"] = ParamUtils::getFromRequest("city",true,"Dane pole jest wymagane");
        $this->form["street"] = ParamUtils::getFromRequest("street",true,"Dane pole jest wymagane");
        $this->form["street_number"] = ParamUtils::getFromRequest("street_number",true,"Dane pole jest wymagane");
        $this->form["apartment_number"] = ParamUtils::getFromRequest("apartment_number");
    }

    public function action_registrate(){
        $this->validation();
        App::getDB()->insert("addres",[
            "postcode" => $this->form["postcode"],
            "city" => $this->form["city"],
            "street" => $this->form["street"],
            "street_number" => $this->form["street_number"],
            "apartment_number" => $this->form["apartment_number"]
        ]);

        App::getDB()->insert("user",[
            "postcode" => $this->form["postcode"],
            "login" => $this->form["login"],
            "password" => $this->form["password"]
        ]);

        App::getRouter()->forwardTo("main_display");
    }
}