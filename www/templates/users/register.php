<?php require_once('cards/www/controllers/login.php'); ?>

<!DOCTYPE html>
<html lang="en">
<?php require_once('cards/www/templates/header.php'); ?>

<section class="vh-100">
  <div class="container py-5 h-100">
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
                                <div class="d-flex align-items-center mb-3 pb-1">
                                    <img src="/cards/assets/img/Logo_Transparent.png" class="d-inline-block img-fluid">
                                </div>

                                <div class="form-floating mb-2">
                                    <input type="text" class="form-control input-login <?php if(isset($_GET["error"]) && $_GET["error"] == "Username"){echo 'is-invalid';} ?>" placeholder="Complete Username" id="username" name="username" required>
                                    <label for="username">Username</label>
                                    <div id="validationAddDeck" class="invalid-feedback">
                                        Username already exists.
                                    </div>
                                </div>

                                <div class="form-floating mb-2">
                                    <input type="text" class="form-control input-login"  placeholder="Complete Name" id="name" name="name" required>
                                    <label for="name">Name</label>
                                </div>

                                <div class="form-floating mb-2">
                                    <input type="email" class="form-control input-login <?php if(isset($_GET["error"]) && $_GET["error"] == "Email"){echo 'is-invalid';} ?>" placeholder="name@example.com" id="email" name="email" required>
                                    <label for="email">Email address</label>
                                    <div id="email" class="invalid-feedback">
                                        Already exists an account using the email.
                                    </div>
                                </div>

                                <div class="form-floating mb-2">
                                    <input type="password" class="form-control input-login <?php if(isset($_GET["error"]) && $_GET["error"] == "Password"){echo 'is-invalid';} ?>" placeholder="Password" id="password" name="password" required>
                                    <label for="password">Password</label>
                                </div>

                                <div class="form-floating mb-3">
                                    <input type="password" class="form-control input-login" id="Cpassword" placeholder="CPassword" id="Cpassword" name="Cpassword" required>
                                    <label for="Cpassword">Confirm Password</label>
                                    <div id="validationAddDeck" class="invalid-feedback">
                                        Passwords must concide.
                                    </div>
                                </div>

                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault" required>
                                    <label class="form-check-label" for="flexCheckDefault">
                                        Accept Terms of use & Privacy Policy
                                    </label>
                                </div>

                                <div class="pt-1 mb-2 mt-3">
                                    <button class="btn btn-primary btn-lg btn-block" type="submit" name="commandRegister" id="registro" value="1"><i class="fa-solid fa-arrow-right-to-bracket me-2 f-18"></i> Register</button>
                                </div>

                                <p class="mb-5 pb-lg-2 text-white">Already have an account? 
                                    <a href="/login" class="text-purple-light">Login here</a>
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
</html>