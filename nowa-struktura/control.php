<?php
require_once 'init.php';

switch($action){
    case 'calcCompute':
        include_once 'app/controler/CalcCtrl.class.php';

        $ctrl = new CalcCtrl();
        $ctrl->process();
    break;

    default:
    include_once 'app/controler/CalcCtrl.class.php';

        $ctrl = new CalcCtrl();
        $ctrl->showView();

    break;

    case 'action2':
    break;
    

}
?>