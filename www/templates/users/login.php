<?php require_once('cards/www/controllers/login.php'); ?>

<!DOCTYPE html>
<html lang="en">
<?php require_once('cards/www/templates/header.php'); ?>
<body class="">
    <section class="vh-100">
        <div class="container py-5">
            <div class="row d-flex justify-content-center align-items-center">
                <div class="col col-md-10">
                    <div class="card border-login card-login">
                        <div class="row g-0">
                            <div class="col-md-6 col-lg-5 d-none d-md-block">
                                <img src="/cards/assets/img/login_image.gif" alt="login form" class="img-fluid img-login" />
                            </div>

                            <div class="col-md-6 col-lg-7 d-flex align-items-center">
                                <div class="card-body p-4 p-lg-5 text-black">

                                    <form id="frmLogin" method="POST">
                                        <div class="d-flex align-items-center mb-3 pb-1">
                                            <img src="/cards/assets/img/Logo_Transparent.png" class="d-inline-block img-fluid">
                                        </div>

                                        <div class="text-center">
                                            <h5 class="fw-normal pb-3 mb-2 text-white" >Sign in with:</h5>
                                            <a type="button" class="btn btn-link btn-floating mx-1" href="#" id="googleLogin">
                                                <i class='bx bxl-google social_icon'></i>
                                            </a>
                                        </div>

                                        <div class="divider d-flex align-items-center my-4">
                                            <p class="text-center fw-bold mx-3 mb-0 text-white">Or</p>
                                        </div>

                                        <div class="form-floating mb-3">
                                            <input type="email" class="form-control input-login <?php if(isset($_GET["error"])){echo 'is-invalid';} ?> " placeholder="name@example.com" id="email" name="email">
                                            <label for="floatingInput" class="text-white">Email address</label>
                                            <div id="email" class="invalid-feedback">
                                                Invalid login, please try again.
                                            </div>
                                        </div>

                                        <div class="form-floating">
                                            <input type="password" class="form-control input-login" id="floatingPassword" placeholder="Password" id="password" name="password">
                                            <label for="floatingPassword" class="text-white">Password</label>
                                        </div>

                                        <div class="pt-1 mb-2 mt-3">
                                            <button class="btn btn-primary btn-lg btn-block" type="submit" name="commandLogin" id="commandLogin" value="1"><i class="fa-solid fa-arrow-right-to-bracket me-2 f-18"></i> Login</button>
                                        </div>

                                        <a class="small text-muted" href="/forgot-password">Forgot password?</a>
                                        <p class="mb-5 pb-lg-2 text-white">Don't have an account? 
                                            <a href="/register" class="text-purple-light">Register here</a>
                                        </p>

                                        <div class="links">
                                            <a href="#!" class="small text-muted" role="button" data-bs-toggle="modal" data-bs-target="#termsandcondi">Terms of use. &nbsp;</a>
                                            <a href="#!" class="small text-muted" role="button" data-bs-toggle="modal" data-bs-target="#privacy">Privacy policy</a>
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
    <div class="modal fade" id="termsandcondi" tabindex="-1" aria-labelledby="termsandcondi" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content bg-dark text-white">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Terms Of Use</h1>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                ...
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Close</button>
            </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="privacy" tabindex="-1" aria-labelledby="privacy" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content bg-dark text-white">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Privacy Policy</h1>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                ...
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Close</button>
            </div>
            </div>
        </div>
    </div>

    <div id="paswordChanged" class="toast bg-success position-fixed bottom-0 end-0 m-3" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="d-flex">
            <div class="toast-body text-white">
                Successfuly changed the password.
            </div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
    </div>
</body>
<script>
    $( document ).ready(function() {
        <?php if(isset($_GET["success"])) { ?>
            $("#paswordChanged").toast('show');
        <?php } ?>
    });

</script>
</html>