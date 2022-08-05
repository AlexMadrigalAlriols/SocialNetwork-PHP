<?php require_once('cards/www/controllers/login.php'); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>

    <?php require_once('cards/www/templates/header.php'); ?>
</head>

<section class="vh-100">
  <div class="container py-5 h-100">
    <div class="row d-flex justify-content-center align-items-center h-100">
    <?php if(isset($_GET["error"])){?>
      <div class="alert alert-danger d-flex align-items-center alert-dismissible fade show" role="alert" style="width: 80%">
        <div>
            <?php if($_GET["error"] == "Password") { ?>
                Passwords must match.
            <?php } else { ?>
                Error on register email/username isn't valid.
            <?php } ?>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
    <?php } ?>
        <div class="col col-xl-10">
            <div class="card" style="border-radius: 1rem;">
                <div class="row g-0">
                    <div class="col-md-6 col-lg-5 d-none d-md-block">
                        <img src="/cards/assets/img/registerImage.jpg" alt="login form" class="img-fluid" style="border-radius: 1rem 0 0 1rem; width: 100%; height: 100%;" />
                    </div>

                    <div class="col-md-6 col-lg-7 d-flex align-items-center">
                        <div class="card-body p-4 p-lg-5 text-black">

                            <form id="frmRegistro" method="POST">
                                <div class="d-flex align-items-center mb-3 pb-1">
                                    <span class="h1 fw-bold mb-0"><i class='bx bx-layer'></i> Collection Saver</span>
                                </div>
                                <h5 class="fw-normal mb-3 pb-3" style="letter-spacing: 1px;">Register your account</h5>

                                <div class="form-floating mb-2">
                                    <input type="text" class="form-control" placeholder="Complete Username" id="username" name="username" required>
                                    <label for="username">Username</label>
                                    <div id="validationAddDeck" class="invalid-feedback">
                                        Username already exists.
                                    </div>
                                </div>

                                <div class="form-floating mb-2">
                                    <input type="text" class="form-control"  placeholder="Complete Name" id="name" name="name" required>
                                    <label for="name">Name</label>
                                </div>

                                <div class="form-floating mb-2">
                                    <input type="email" class="form-control" placeholder="name@example.com" id="email" name="email" required>
                                    <label for="email">Email address</label>
                                    <div id="email" class="invalid-feedback">
                                        Already exists an account using the email.
                                    </div>
                                </div>

                                <div class="form-floating mb-2">
                                    <input type="password" class="form-control" placeholder="Password" id="password" name="password" required>
                                    <label for="password">Password</label>
                                </div>

                                <div class="form-floating mb-3">
                                    <input type="password" class="form-control" id="Cpassword" placeholder="CPassword" id="Cpassword" name="Cpassword" required>
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
                                    <button class="btn btn-primary btn-lg btn-block" type="submit" name="commandRegister" id="registro" value="1">Register</button>
                                </div>

                                <p class="mb-5 pb-lg-2" style="color: #393f81;">Already have an account? 
                                    <a href="/login">Sign up</a>
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