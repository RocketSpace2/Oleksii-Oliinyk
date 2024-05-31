<?php

namespace app\controllers;

use core\App;
use core\RoleUtils;
use core\ParamUtils;
use core\Validator;
use core\SessionUtils;

class UserListCtrl{
    public function __construct(){
        MainConstructor::main_construct();
    }

    public function action_users_list_display(){
        $catalog_users = App::getDB()->select("catalog_user",[
            "[><]user" => "id_user",
            "[><]catalog" => "id_role"
        ], ["login","role_name","date_of_activation", "date_of_deactivation"],[
            "ORDER" => "login",
            "login[!]" => SessionUtils::load("login",true)
        ]);
        
        
        App::getSmarty()->assign("catalog_users",$catalog_users);
        App::getSmarty()->display("users-list.html");
    }
    public function action_filter_users_list(){
        $role = ParamUtils::getFromRequest("role");

        if($role == "deactivated"){
            $catalog_users = App::getDB()->select("catalog_user",[
                "[><]user" => "id_user",
                "[><]catalog" => "id_role"
            ], ["login","role_name","date_of_activation", "date_of_deactivation"],[
                "ORDER" => "login",
                "date_of_deactivation[!]" => null,
                "login[!]" => SessionUtils::load("login",true)
            ]);
        }
        elseif($role == "activated"){
            $catalog_users = App::getDB()->select("catalog_user",[
                "[><]user" => "id_user",
                "[><]catalog" => "id_role"
            ], ["login","role_name","date_of_activation", "date_of_deactivation"],[
                "ORDER" => "login",
                "date_of_deactivation" => null,
                "login[!]" => SessionUtils::load("login",true)
            ]);
        }else{
            $valid = new Validator();
            $query = $valid->validateFromRequest("query",[
                'trim' => true,
            ]);

            $query = $query."%";

            $catalog_users = App::getDB()->select("catalog_user",[
                "[><]user" => "id_user",
                "[><]catalog" => "id_role"
            ], ["login","role_name","date_of_activation", "date_of_deactivation"],[
                "ORDER" => "login",
                "login[~]" => $query,
                "login[!]" => SessionUtils::load("login",true)
            ]);
        }

        App::getSmarty()->assign("catalog_users",$catalog_users);
        App::getSmarty()->display("users-list.html");
    }

    public function action_edit_users_list(){
        $login = ParamUtils::getFromRequest("login");
        SessionUtils::store("login", $login);

        $catalog_users = App::getDB()->select("catalog_user",[
            "[><]user" => "id_user",
            "[><]catalog" => "id_role"
        ], ["login","role_name","date_of_activation", "date_of_deactivation"],[
            "login" => $login,
            "date_of_deactivation" => null
        ]);

        $i = 0;

        while(isset($catalog_users[$i])){
            $role = $catalog_users[$i]["role_name"];
            $i++;
        }

        $i--;

       
        App::getSmarty()->assign("role",$role);
        App::getSmarty()->assign("row",$catalog_users[$i]);
        App::getSmarty()->display("edit-users-list.html");
    }
    public function action_edit_user(){

        $user = App::getDB()->select("user",["id_user"],[
            "login" => SessionUtils::load("login",true)
        ]);

        $id_user = $user[0]["id_user"];

        //get previous active role
        $active_roles =  App::getDB()->select("catalog_user",["id_role"],[
            "id_user" => $id_user,
            "date_of_deactivation" => null,
            "id_role[!]" => 1
        ]);

        //get role which will be apdated or created
        $role = ParamUtils::getFromRequest("role");

        //make select to check is such row with such id_user and id_role is exist in data base
        $check = App::getDB()->select("catalog_user",["id_role"],[
            "id_user" => $id_user,
            "id_role" => $role
        ]);

        //if row doesn't exist, than it will be created, if exist, than it will be updated
        if(isset($check[0]["id_role"])){
            
            //if previous active role was user than only new role will be activated
            if(!isset($active_roles[0])){
                App::getDB()->update("catalog_user",[
                    "date_of_activation" => date("Y-m-d H:i:s"),
                    "date_of_deactivation" => null
                ],[
                    "id_user" => $id_user,
                    "id_role" => $role
                ]);
            }else{

                //if previous role was admin or worker, than new role will be activated and previous will be deactivated
                App::getDB()->update("catalog_user",[
                    "date_of_deactivation" => date("Y-m-d H:i:s")
                ],[
                    "id_user" => $id_user,
                    "id_role" => $active_roles[0]["id_role"]
                ]);

                //if someone want to change role to user from admin or worker, than user won't acivated again
                if($role != 1){
                    App::getDB()->update("catalog_user",[
                        "date_of_activation" => date("Y-m-d H:i:s"),
                        "date_of_deactivation" => null
                    ],[
                        "id_user" => $id_user,
                        "id_role" => $role
                    ]);
                }
            }
                        
        }else{

            //creating new row
            App::getDB()->insert("catalog_user",[
                "id_role" => $role,
                "id_user" => $id_user,
                "date_of_activation" => date("Y-m-d H:i:s"),
                "date_of_deactivation" => null
            ]);

            //checking and deactivating any outher active roles
            switch($role){
                case 3:
                    App::getDB()->update("catalog_user",[
                        "date_of_deactivation" => date("Y-m-d H:i:s")
                    ],[
                        "id_user" => $id_user,
                        "id_role" => 2
                    ]);
                    break;
                case 2 :
                    App::getDB()->update("catalog_user",[
                        "date_of_deactivation" => date("Y-m-d H:i:s")
                    ],[
                        "id_user" => $id_user,
                        "id_role" => 3
                    ]);
                    break;
            }


        }
       
        $this->action_users_list_display();
    }

    public function action_delete_user(){
        $login = ParamUtils::getFromRequest("login");

        $user = App::getDB()->select("user", ["id_user"],[
            "login" => $login
        ]);
        
        $id_user = $user[0]["id_user"];

        //delete in catalo_user
        App::getDB()->delete("catalog_user",[
            "id_user" => $id_user
        ]);

        $addres = App::getDB()->select("user", ["id_addres"],[
            "login" => $login
        ]);

        if(count($addres) == 1){
            //delete in user
            App::getDB()->delete("user",[
                "id_user" => $id_user
            ]);

            $id_addres = $addres[0]["id_addres"];

            //delete in addres
            App::getDB()->delete("addres",[
                "id_addres" => $id_addres
            ]);
        }

        $this->action_users_list_display();
    }
}