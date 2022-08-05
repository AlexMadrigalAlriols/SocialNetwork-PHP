<?php require_once('cards/www/controllers/login.php'); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login de Usuario</title>

    <?php require_once('cards/www/templates/header.php'); ?>
</head>
<section class="vh-100" style="max-height: 200px;">
  <div class="container py-5 h-100">
    <div class="row d-flex justify-content-center align-items-center h-100" style="max-height: 200px;">
        <div class="col col-md-10">
            <div class="card" style="border-radius: 1rem;">
                <div class="row g-0">
                    <div class="col-md-6 col-lg-5 d-none d-md-block">
                        <img src="/cards/assets/img/loginImage.jpg" alt="login form" class="img-fluid" style="border-radius: 1rem 0 0 1rem; width: 100%; height: 100%;" />
                    </div>

                    <div class="col-md-6 col-lg-7 d-flex align-items-center">
                        <div class="card-body p-4 p-lg-5 text-black">

                            <form id="frmLogin" method="POST">
                                <div class="d-flex align-items-center mb-3 pb-1">
                                    <span class="h1 fw-bold mb-0"><i class='bx bx-layer'></i> Collection Saver</span>
                                </div>

                                <div class="text-center">
                                    <h5 class="fw-normal pb-3 mb-2" style="letter-spacing: 1px;">Sign in with:</h5>
                                    <a type="button" class="btn btn-link btn-floating mx-1" href="#" id="googleLogin">
                                        <i class='bx bxl-google social_icon'></i>
                                    </a>

                                    <button type="button" class="btn btn-link btn-floating mx-1">
                                        <i class='bx bxl-twitter social_icon'></i>
                                    </button>

                                    <button type="button" class="btn btn-link btn-floating mx-1">
                                        <i class='bx bxl-twitch social_icon' ></i>
                                    </button>
                                </div>

                                <div class="divider d-flex align-items-center my-4">
                                    <p class="text-center fw-bold mx-3 mb-0">Or</p>
                                </div>

                                <div class="form-floating mb-3">
                                    <input type="email" class="form-control <?php if(isset($_GET["error"])){echo 'is-invalid';} ?> " placeholder="name@example.com" id="email" name="email">
                                    <label for="floatingInput">Email address</label>
                                    <div id="email" class="invalid-feedback">
                                        Invalid login, please try again.
                                    </div>
                                </div>

                                <div class="form-floating">
                                    <input type="password" class="form-control" id="floatingPassword" placeholder="Password" id="password" name="password">
                                    <label for="floatingPassword">Password</label>
                                </div>

                                <div class="pt-1 mb-2 mt-3">
                                    <button class="btn btn-primary btn-lg btn-block" type="submit" name="commandLogin" id="commandLogin" value="1">Login</button>
                                </div>

                                <a class="small text-muted" href="#!">Forgot password?</a>
                                <p class="mb-5 pb-lg-2" style="color: #393f81;">Don't have an account? 
                                    <a href="/register">Register here</a>
                                </p>

                                <div class="links"style="bottom: 15px; position:absolute; right: 20px;">
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
</html>