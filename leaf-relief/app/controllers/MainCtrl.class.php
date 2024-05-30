<?php
namespace app\controllers;

use core\App;
use app\controllers\MainConstructor;

class MainCtrl{

    public function __construct(){
        MainConstructor::main_construct();
     }
    public function action_main_display(){
        App::getSmarty()->display("main.html");
    }
}