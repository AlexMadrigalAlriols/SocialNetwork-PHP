<?php require_once('cards/www/controllers/login.php'); ?>

<!DOCTYPE html>
<html lang="en">
<?php require_once('cards/www/templates/header.php'); ?>

<body class="bg-dark">
    <section class="vh-100">
        <div class="container py-3 h-100">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col col-xl-10">
                    <div class="card border-login card-login">
                        <div class="row g-0">
                            <div class="col-md-6 col-lg-5 d-none d-md-block">
                                <img src="/cards/assets/img/register_image.gif" alt="login form" class="img-fluid img-login" />
                            </div>

                            <div class="col-md-6 col-lg-7 d-flex align-items-center">
                                <div class="card-body p-4 p-lg-5 text-black">

                                    <form id="frmRegistro" method="POST" class="text-white">
                                        <div class="d-flex align-items-center mb-3 pb-1 logo-register">
                                            <img src="/cards/assets/img/Logo_Transparent.png" class="d-inline-block img-fluid">
                                        </div>

                                        <div class="form-floating mb-2 mt-4">
                                            <input type="text" class="form-control input-login <?php if(isset($_GET["error"]) && $_GET["error"] == "Username"){echo 'is-invalid';} ?>" placeholder="Complete Username" id="username" name="username" value="<?=(isset($_GET["username"]) ? $_GET["username"] : "")?>" required>
                                            <label for="username">Username</label>
                                            <div id="validationAddDeck" class="invalid-feedback">
                                                Username already exists.
                                            </div>
                                        </div>

                                        <div class="form-floating mb-2">
                                            <input type="text" class="form-control input-login"  placeholder="Complete Name" id="name" name="name" value="<?=(isset($_GET["name"]) ? $_GET["name"] : "")?>" required>
                                            <label for="name">Name</label>
                                        </div>

                                        <div class="form-floating mb-2">
                                            <input type="email" class="form-control input-login <?php if(isset($_GET["error"]) && $_GET["error"] == "Email"){echo 'is-invalid';} ?>" placeholder="name@example.com" id="email" name="email" value="<?=(isset($_GET["email"]) ? $_GET["email"] : "")?>" required>
                                            <label for="email">Email address</label>
                                            <div id="email" class="invalid-feedback">
                                                Already exists an account using the email.
                                            </div>
                                        </div>

                                        <div class="form-floating mb-2">
                                            <input type="password" class="form-control input-login <?php if(isset($_GET["error"]) && $_GET["error"] == "Password"){echo 'is-invalid';} ?>" placeholder="Password" id="password" name="password" required>
                                            <label for="password">Password</label>
                                            <div id="validationpassword" class="invalid-feedback"></div>
                                        </div>

                                        <div class="form-floating mb-3">
                                            <input type="password" class="form-control input-login" id="Cpassword" placeholder="CPassword" id="Cpassword" name="Cpassword" required>
                                            <label for="Cpassword">Confirm Password</label>
                                            <div id="validationCpassword" class="invalid-feedback">
                                                Passwords must concide.
                                            </div>
                                        </div>

                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value="1" id="flexCheckDefault" required>
                                            <label class="form-check-label" for="flexCheckDefault">
                                                Accept <a href="#!" role="button" data-bs-toggle="modal" data-bs-target="#termsandcondi">Terms of use</a> & <a href="#!" role="button" data-bs-toggle="modal" data-bs-target="#privacy">Privacy Policy</a>
                                            </label>
                                        </div>

                                        <div class="pt-1 mb-2 mt-3">
                                            <button class="btn btn-primary btn-lg btn-block w-100" type="submit" name="commandRegister" id="commandRegister" value="1" disabled><i class="fa-solid fa-arrow-right-to-bracket me-2 f-18"></i> Register Account</button>
                                        </div>

                                        <p class="mb-5 pb-lg-2 text-white">Already have an account? 
                                            <a href="/login" class="text-purple-light">Login here</a>
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
</body>
<script>
    $( document ).ready(function() {
        var error = 0;

        $("#password").focusout(function() {
            password = $(this).val();

            if(password.length < <?= gc::getSetting("validators.password_length"); ?>) {
                error++;
                $(this).addClass("is-invalid");
                $("#validationpassword").html("Password must be at least 6 characters long");
                checkForm(this);
            } else {
                error--;
                $(this).removeClass("is-invalid");
                $("#validationpassword").html("");
                checkForm(this);
            }
        });

        $("#Cpassword").focusout(function() {
            password = $("#password").val();
            cpassword = $(this).val();

            if(password != cpassword) {
                error++;
                $(this).addClass("is-invalid");
                $("#validationCpassword").html("Passwords don't match");
                checkForm(this);
            } else {
                error--;
                $(this).removeClass("is-invalid");
                $("#validationCpassword").html("");
                checkForm(this);
            }
        });

        $(".input-login").keyup(function(){
            checkForm(this);
        });
        
        function checkForm(input) {
            var vacio = false;

            $(".input-login").each(function(index) {
                if($(this).val() == "") {
                    vacio = true;
                }
            });
                
            if(vacio || error >= 1) {
                $("#commandRegister").attr("disabled", true);
            } else {
                $("#commandRegister").attr("disabled", false);
            }
        }
    });
</script>
<?php require_once('cards/www/templates/_footer.php'); ?>
</html>