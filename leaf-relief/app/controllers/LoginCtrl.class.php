<?php

namespace app\controllers;

use core\App;
use core\RoleUtils;
use core\ParamUtils;
use core\Message;

class LoginCtrl{

    private $form = array();

    public function __construct(){
        App::getSmarty()->assign("isUser",RoleUtils::inRole("user"));
        App::getSmarty()->assign("isWorker",RoleUtils::inRole("worker"));
        App::getSmarty()->assign("isAdmin",RoleUtils::inRole("admin"));
       
        App::getSmarty()->assign("conf",App::getConf()->app_url);
    }

    public function action_login_display(){
        App::getSmarty()->display("login.html");
    }

    public function validation(){
        $this->form["login"] = ParamUtils::getFromRequest("login");
        $this->form["password"] = ParamUtils::getFromRequest("password");

        $userLogin = App::getDB()->select("user",["login"],[
            "login" => $this->form["login"]
        ]);

        if(!isset($userLogin[0]["login"])){
            App::getMessages()->addMessage(new Message("Login jest niepoprawny",Message::ERROR));
        }

        $userPassword = App::getDB()->select("user",["password"],[
            "login" => $this->form["login"]
        ]);
        
        if(!password_verify($this->form["password"],$userPassword[0]["password"])){
            App::getMessages()->addMessage(new Message("Login lub hasło jest niepoprawne",Message::ERROR));
        } 


        if(App::getMessages()->isError()){
            $this->action_login_display();
            exit();
        }
    }

    public function addRoles(){
        $results = App::getDB()->select("user",["id_user"],[
            "login" => $this->form["login"]
        ]);

        $id_user = $results[0]["id_user"];

        $roles = App::getDB()->select("catalog_user",["id_role"],[
            "id_user" => $id_user
        ]);

        for($i = 0; $i < count($roles); $i++){
            switch($roles[$i]["id_role"]){
                case 1:
                    RoleUtils::addRole("user");
                    break;
                
                case 2:
                    RoleUtils::addRole("worker");
                    break;

                case 3:
                    RoleUtils::addRole("admin");
                    break;
            }

        }
    }

    public function action_login(){
        $this->validation();
        
        $this->addRoles();

        App::getRouter()->forwardTo("main_display");
    }

    public function action_logout(){
        session_destroy();

        App::getRouter()->forwardTo("main_display");
    }

}