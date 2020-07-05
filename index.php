<?php
require_once "header.php";
//unset($_SESSION["ERRORS"]);
if(isset($_SESSION["ERRORS"])) $arErrors = $_SESSION["ERRORS"];
?>
<div class="container">
    <div class="py-5 text-center">
        <img class="d-block mx-auto mb-4" src="/docs/4.4/assets/brand/bootstrap-solid.svg" alt="" width="72" height="72">
        <h2><?=$arLang["form_h2"]?></h2>
    </div>

    <div class="col-md-8 order-md-1">

        <?if(isset($arErrors)):?>
            <?foreach ($arErrors as $error):?>
                <div class="alert alert-danger" role="alert">
                    <?if(is_array($error)):?>
                        <?var_dump($error)?>
                    <?else:?>
                        <?echo($error)?>
                    <?endif;?>
                </div>
            <?endforeach;?>
        <?endif;?>

        <form class="needs-validation"
              enctype="multipart/form-data"
              method="POST"
              action="lib/routes.php"
              novalidate
        >
            <input type="hidden" name="action" value="registration">

            <div class="mb-6 form-group">
                <label for="username"><?=$arLang["username"]?> <span class="text-muted">(<?=$arLang["optional"]?>)</span></label>
                <div class="input-group">
                    <input
                            type="text"
                            class="form-control"
                            id="name"
                            placeholder="<?=$arLang["username_placeholder"]?>"
                            name="name"
                            value="<?=isset($_REQUEST["name"])?$_REQUEST["name"]:""?>"
                    >
                </div>
            </div>

            <div class="mb-6 form-group">
                <label for="email">Email </label>
                <input
                        type="email"
                        class="form-control"
                        id="email"
                        placeholder="you@example.com"
                        name="email"
                        value="<?=isset($_REQUEST["email"])?$_REQUEST["email"]:""?>"
                        required
                >
                <div class="invalid-feedback">
                    <?=$arLang["email_error"]?>
                </div>
            </div>

            <div class="mb-6 form-group">
                <label for="phone"><?=$arLang["phone_number"]?> <span class="text-muted">(<?=$arLang["optional"]?>)</span></label>
                <input
                        type="tel"
                        pattern=".{11}"
                        class="form-control"
                        id="phone"
                        placeholder="(999) 123-45-67"
                        name="phone"
                        value="<?=isset($_REQUEST["phone"])?$_REQUEST["phone"]:""?>"
                >
            </div>

            <div class="mb-6 form-group">
                <label for="password"><?=$arLang["password"]?></label>
                <input
                        type="password"
                        pattern=".{6}"
                        class="form-control"
                        id="password"
                        name="password"
                        value="<?=isset($_REQUEST["password"])?$_REQUEST["password"]:""?>"
                        required
                >
                <div class="invalid-feedback">
                    <?=$arLang["password_error"]?>
                </div>
            </div>

            <div class="mb-6 form-group">
                <label for="avatar"><?=$arLang["user_file"]?> <span class="text-muted">(<?=$arLang["optional"]?>)</span></label>
                <input
                        type="file"
                        class="form-control-file"
                        id="avatar"
                        name="avatar"
                >
            </div>

            <hr class="mb-4">
            <input class="btn btn-primary btn-lg btn-block" type="submit" value="<?=$arLang["registration_btn"]?>"/>
            <!--<button class="btn btn-primary btn-lg btn-block" type="submit"><?/*=$arLang["registration_btn"]*/?></button>-->
        </form>
    </div>


    <footer class="my-5 pt-5 text-muted text-center text-small">
        <p class="mb-1">&copy; 2017-2019 Company Name</p>
    </footer>
</div>

<?php
require_once "footer.php";
?>