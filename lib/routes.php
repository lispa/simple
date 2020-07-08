<?php
/**
 * Created by PhpStorm.
 * User: Z570
 * Date: 15.12.2019
 * Time: 21:48
 */

session_start();
include "header_admin.php";

switch ($_REQUEST["action"]){
    case "registration":
        $arErrors = \Controllers\UserController::registration();
        if(!empty($arErrors)){
            $query = http_build_query($_POST);
            $_SESSION["ERRORS"] = $arErrors;
            header("Location: http://localhost:8080/index.php?".$query);
        }
        break;
    case "personal":
        $arUserInfo = \Controllers\UserController::getInfo($_REQUEST['user_id']);
        break;
    default:
        //redirect to index.php
}