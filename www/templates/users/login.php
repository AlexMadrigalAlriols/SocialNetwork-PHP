<?php require_once('cards/www/controllers/login.php'); ?>

<!DOCTYPE html>
<html lang="en">
<?php require_once('cards/www/templates/header.php'); ?>
<body class="bg-dark">
    <section>
        <div class="container py-4">
            <div class="row justify-content-center align-items-center">
                <div class="col-md-10">
                    <div class="card border-login card-login">
                        <div class="row g-0">
                            <div class="col-md-6 col-lg-5 d-none d-md-block">
                                <img src="/cards/assets/img/login_image.gif" alt="login form" class="img-fluid img-login" />
                            </div>

                            <div class="col-md-6 col-lg-7 d-flex align-items-center">
                                <div class="card-body p-4 p-lg-5 text-black">

                                    <form id="frmLogin" method="POST">
                                        <div class="d-flex align-items-center mb-3 pb-1 logo-login">
                                            <img src="/cards/assets/img/Logo_Transparent.png" alt="MTGCollectioner logo" class="d-inline-block img-fluid">
                                        </div>

                                        <div class="text-center mt-5">
                                            <h5 class="fw-normal pb-3 mb-2 text-white" >Sign in with:</h5>
                                            <a type="button" class="btn btn-link btn-floating mx-1" href="<?=$client->createAuthUrl();?>" id="googleLogin">
                                                <i class='fa-brands fa-google social_icon'></i>
                                            </a>
                                            <a type="button" class="btn btn-link btn-floating mx-1" href="<?=$discord->url();?>" id="discordLogin">
                                                <i class='fa-brands fa-discord social_icon'></i>
                                            </a>

                                            <a type="button" class="btn btn-link btn-floating mx-1" href="<?= $twitter->getUrl(); ?>" id="twitterLogin">
                                                <i class='fa-brands fa-twitter social_icon'></i>
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
                                            <button class="btn btn-primary btn-lg btn-block w-100" type="submit" name="commandLogin" id="commandLogin" value="1" disabled><i class="fa-solid fa-arrow-right-to-bracket me-2 f-18"></i> Login Account</button>
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
                You’ll need to create an account with MTGCollectioner to use some of our Services. Here are a few rules about accounts on MTGCollectioner.

                <ol>
                    <li>You must be 16 years or older to use our Services. Minors under 18 and at least 13 years of age are only permitted to use our Services through an account owned by a parent or legal guardian.</li>
                    <li>Be honest with us. Provide accurate information about yourself. It’s prohibited to use false information or impersonate another person or company through your account.</li>
                    <li>We also may suspend or terminate your account. If we determine, in our sole discretion.</li>
                    <li>
                        It is totally prohibited to carry out any of these actions in MTG Collectioner:
                        <ul>
                            <li>Obscene, crude, or violent posts</li>
                            <li>False or misleading content</li>
                            <li>Breaking the law</li>
                            <li>Spamming or scamming the service or other users</li>
                            <li>Hacking or tampering with your website or app</li>
                            <li>Violating copyright laws</li>
                            <li>Harassing other users</li>
                            <li>Stalking other users</li>
                        </ul>
                    </li>
                </ol>

                <h5>Your Privacy</h5>
                    <ul>
                        <li>We know your personal information is important to you, so it’s important to us. Revise our Privacy Policy to read all the details about it.</li>
                    </ul>

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
                We’ll give you details about why we need your personal information and how we’ll use it before you begin, unless it’s obvious.
                <ol>
                    <li>We might ask for your name, email and phone number, depending one hat you’re doing. This information will only be used on our website (MTGCollectioner) for nonprofit actions.</li>
                    <li>We also collect your last IP address, device & login times. Just for security proposals.</li>
                    <li>We can collect your location to determine your town or city, depending on what you’re doing.</li>
                    <li>Depending if you are logged with Google, Discord or Twitter we collect this data to create your account.</li>
                </ol>
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

        $(".input-login").keyup(function(){
            var vacio = false;
            if($(this).val() != "") {
                $("#commandLogin").attr("disabled", false);
            }

            $(".input-login").each(function() {
                if($(this).val() == "") {
                    vacio = true;
                }
            });
            
            if(vacio) {
                $("#commandLogin").attr("disabled", true);
            }
        });
    });

</script>
<?php require_once('cards/www/templates/_footer.php'); ?>
</html>