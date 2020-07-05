<?php
require_once "header.php";
$arUserInfo = [];
if(isset($_REQUEST['user_id']))
    $arUserInfo = \Controllers\UserController::getInfo($_REQUEST['user_id']);
?>
<div class="container">
    <div class="row">
        <div class="py-5 text-center">
            <h1><?=$arLang["personal_title"]?> #<?=isset($arUserInfo["id"])?$arUserInfo["id"]:""?></h1>
        </div>
    </div>

    <div class="row">
        <div class="col-md-3">
            <?if(isset($arUserInfo["avatar"])):?>
                <img src="<?=$arUserInfo["avatar"]["webpath"]?>" alt="<?=$arUserInfo["avatar"]["name"]?>" class="img-thumbnail" />
            <?endif;?>
        </div>

        <div class="col-md-6">
            <dl class="row">
                <dt class="col-sm-6"><?=$arLang["username"]?>:</dt>
                <dd class="col-sm-6"><?=isset($arUserInfo["name"])?$arUserInfo["name"]:""?></dd>
            </dl>
            <dl class="row">
                <dt class="col-sm-6">Email:</dt>
                <dd class="col-sm-6"><?=isset($arUserInfo["email"])?$arUserInfo["email"]:""?></dd>
            </dl>
            <dl class="row">
                <dt class="col-sm-6"><?=$arLang["phone_number"]?>:</dt>
                <dd class="col-sm-6"><?=isset($arUserInfo["phone"])?$arUserInfo["phone"]:""?></dd>
            </dl>
            <dl class="row">
                <dt class="col-sm-6"><?=$arLang["created_at"]?>:</dt>
                <dd class="col-sm-6"><?=isset($arUserInfo["created_at"])?$arUserInfo["created_at"]:""?></dd>
            </dl>
        </div>
    </div>

</div>




<?php
require_once "footer.php";
?>