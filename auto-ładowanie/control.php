<?php
require_once 'init.php';

use app\controlers\CalcCtrl;

switch($action){
    case 'calcCompute':
        $ctrl = new CalcCtrl();
        $ctrl->process();
    break;

    default:
        $ctrl = new CalcCtrl();
        $ctrl->showView();

    break;

    case 'action2':
    break;
    

}