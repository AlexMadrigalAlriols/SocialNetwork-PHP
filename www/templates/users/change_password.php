<?php 
require_once("cards/framework/globalController.php");

if(!isset($verify_code) || $verify_code == "") {
    header("Location: /forgot-password");
}

if(!userService::checkForVerifyCode($verify_code)) {
    header("Location: /forgot-password");
}

if(isset($_POST["commandSave"])) {
    unset($_POST["commandSave"]);

    if(userService::changePassword($_POST, $verify_code)) {
        header("Location: /login?success");
    } else {
        header("Location: /forgot-password/".$verify_code."?error");
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <?php require_once('cards/www/templates/header.php'); ?>
</head>
<body class="">
    <section class="vh-100">
        <div class="container py-5">
            <div class="row d-flex justify-content-center align-items-center">
                <div class="col col-md-10">
                    <div class="card border-login" style="background-color: #242424;">
                        <div class="row g-0">
                            <div class="col-md-6 col-lg-5 d-none d-md-block">
                                <img src="/cards/assets/img/forgot_image.gif" alt="login form" class="img-fluid img-login" />
                            </div>

                            <div class="col-md-6 col-lg-7 d-flex align-items-center">
                                <div class="card-body p-4 p-lg-5 text-black">

                                    <form id="frmLogin" method="POST">
                                        <div class="d-flex align-items-center mb-3 pb-1">
                                            <img src="/cards/assets/img/Logo_Transparent.png" class="d-inline-block img-fluid">
                                        </div>

                                        <div class="form-floating mb-3">
                                            <input type="password" class="form-control input-login <?php if(isset($_GET["error"])){echo 'is-invalid';} ?> " placeholder="example" id="password" name="password">
                                            <label for="floatingInput" class="text-white">New Password</label>
                                            <div id="email" class="invalid-feedback">
                                                Invalid password, please try again.
                                            </div>
                                        </div>

                                        <div class="form-floating mb-3">
                                            <input type="password" class="form-control input-login" placeholder="example" id="cpassword" name="cpassword">
                                            <label for="floatingInput" class="text-white">Confirm Password</label>
                                        </div>

                                        <div class="pt-1 mb-2 mt-3">
                                            <button class="btn btn-primary btn-lg btn-block" type="submit" name="commandSave" id="commandSave" value="1"><i class="fa-regular fa-circle-check f-18 me-2"></i> Change Password</button>
                                        </div>

                                        <p class="mb-5 pb-lg-2 text-white">Don't have an account? 
                                            <a href="/register" class="text-purple">Register here</a>
                                        </p>

                                        <div class="links">
                                            <a href="#!" class="small text-muted">Terms of use. &nbsp;</a>
                                            <a href="#!" class="small text-muted">Privacy policy</a>
                                        </div>

                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</body>
<?php require_once('cards/www/templates/_footer.php'); ?>
</html>