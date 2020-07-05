<?php
/**
 * Created by PhpStorm.
 * User: Z570
 * Date: 15.12.2019
 * Time: 23:17
 */

session_start();
$GLOBALS["SERVER_DIR"] = __DIR__;

require_once "lib/Controllers/UserController.php";
require_once "lib/Models/User.php";
require_once "lib/Models/Avatar.php";
require_once "lib/settings.php";

//include lag files
$lang = "ru";
if(isset($_REQUEST["lang"])){
    $lang = htmlentities($_REQUEST["lang"]);
}

require_once "lang/".$lang."/index.php";
$arLang = $GLOBALS["LANG_CONST"];

$link = $_SERVER["SCRIPT_NAME"];
$query = $_SERVER["QUERY_STRING"];
$arQueryParametres = explode('&',$query);
$queryResString = "";
foreach ($arQueryParametres as $parString){
    if(!empty($parString)){
        $arStringPieces = explode("=", $parString);
        if($arStringPieces[0] != "lang") $queryResString .= $arStringPieces[0]."=".$arStringPieces[1];
    }
}
if(!empty($queryResString))
    $link .= "?".$queryResString."&lang=";
else $link .= "?lang=";
?>

<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link href="assets/style.css" rel="stylesheet">

    <title><?=$arLang["title"]?></title>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item">
                <a class="nav-link" href="/">Form</a>
            </li>
        </ul>

        <ul class="navbar-nav">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <?=$arLang["lang_label"]?>
                </a>
                <div class="dropdown-menu right" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item" href="<?=$link?>ru">ru</a>
                    <a class="dropdown-item" href="<?=$link?>en">en</a>
                </div>
            </li>
        </ul>
    </div>
</nav>
