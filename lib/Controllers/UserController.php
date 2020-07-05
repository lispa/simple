<?php
/**
 * Created by PhpStorm.
 * User: Z570
 * Date: 15.12.2019
 * Time: 21:03
 */

namespace Controllers;

use \Models\User;
use \Models\Avatar;

class UserController
{
    public static function registration(){
        //validation
        $arFields = [];
        $arErrors = [];

        if(isset($_REQUEST["email"])) {
            $email = htmlspecialchars($_REQUEST["email"]);
            if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
                $arErrors["email"] = "Неверный формат email";
            }
        } else {
            $arErrors["email"] = "Укажите email";
        }

        if(isset($_REQUEST["password"])) {
            $password = htmlspecialchars($_REQUEST["password"]);
            if(strlen($password) < 6){
                $arErrors["password"] = "Неверный формат пароля (менее 6 символов)";
            }
        } else {
            $arErrors["password"] = "Укажите пароль";
        }

        if(isset($_REQUEST["name"])) {
            $name = htmlspecialchars($_REQUEST["name"]);
            if(strlen($name) < 2){
                $arErrors["name"] = "Неверный формат имени (менее 2 символов) ";
            }
        }

        if(isset($_REQUEST["phone"])) {
            $phone = intval(htmlspecialchars($_REQUEST["phone"]));
            if(strlen($phone) < 10){
                $arErrors["phone"] = "Неверный формат номера телефона (10 цифр без кода страны, пробелов и других символов) ";
            }
        }

        //check avatar
        if(isset($_FILES["avatar"]) && $_FILES["avatar"]["name"] != '') {
            //проверка размера
            $maxBytes = $GLOBALS["max_upload_file_size"] * 1024 * 1000;
            if ($_FILES["avatar"]["size"] > $maxBytes)
                $arErrors["avatar"][] = "Превышен макс размер файла";
            $fileType = $_FILES["avatar"]["type"];
            if (!in_array($fileType, $GLOBALS["allowed_file_types"]))
                $arErrors["avatar"][] = "Педопустимый тип файла";
        }

        if(empty($arErrors)) {
            $arFields["name"] = isset($name)?$name:"";
            $arFields["email"] = $email;
            $arFields["password"] = $password;
            $arFields["phone"] = isset($phone)?$phone:"";
            $User = new User($arFields);
            $res = $User->save();

            if($res["result"] === true){
                //todo save session
                /*session_start();
                $_SESSION['user_id'] = $User->getId();*/

                $userId = $User->getId();
                //save avatar
                if(isset($_FILES["avatar"])){
                    $dir = $GLOBALS["upload_dir"] . basename($_FILES['avatar']['name']);
                    if(move_uploaded_file($_FILES['avatar']['tmp_name'], $dir)){
                        $Avatar = new Avatar([
                            "user_id" => $userId,
                            "file_name" => $_FILES['avatar']['name'],
                            "web_path" => $GLOBALS["web_dir"] . basename($_FILES['avatar']['name']),
                            "file_path" => $dir
                        ]);
                        $Avatar->save();
                        $fileId = $Avatar->getId();

                        $User->setAvatar($fileId);
                        $User->save();
                    }
                }

                unset($_SESSION["ERRORS"]);
                //redirect to personal
                header("Location: http://localhost:8080/personal.php?user_id=".$userId);
                exit();
            } else {
                return [$res["error_message"]];
            }
        } else {
            return $arErrors;
        }
    }

    public static function getInfo($user_id){
        $user_id = intval(htmlspecialchars($user_id));
        if(is_integer($user_id)) {
            $arResult = User::getByID($user_id);
            return $arResult;
        } else {
            return false;
        }
    }



}