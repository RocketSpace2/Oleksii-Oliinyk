<?php
require_once 'init.php';

getRouter()->setDefaultRoute('showView');
getRouter()->setLoginRoute('login'); 

getRouter()->addRoute('showView',    'CalcCtrl',  ['user','admin']);
getRouter()->addRoute('calcCompute', 'CalcCtrl',  ['user','admin']);
getRouter()->addRoute('login',       'LoginCtrl');
getRouter()->addRoute('logout',      'LoginCtrl', ['user','admin']);

getRouter()->go(); 