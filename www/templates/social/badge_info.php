<?php require_once('cards/www/controllers/badge-info.php'); ?>
<!DOCTYPE html>
<html lang="en">
<?php require_once('cards/www/templates/social/header.php'); ?>
<body>
<?php require_once('cards/www/templates/social/home_navbar.php'); ?>

<div class="container mt-3 mb-4">
<?php require_once('cards/www/templates/_toast.php') ?>

    <div class="row">
        <div class="col-md-8">
            <div class="mt-3 p-4 bg-dark text-white rounded container">
                <div class="card-body">
                    <div class="text-center">
                        <a href="/badges/@<?=$user_details["username"];?>" class="text-purple d-inline-block h3"><i class="fa-solid fa-chevron-left me-3"></i></a>
                        <span class="mb-4 h4 d-inline-block text-center">
                            <?=$user->i18n("badge.".$badge_name)?> (<?=$user->i18n("badge.rarity.". $badge["rarity"]);?>)
                        </span>
                    </div>
                    
                    <div class="container text-center">
                        <img src="<?=(file_exists('cards/assets/img/badges/'.$badge_name.'.png') ? '/cards/assets/img/badges/'.$badge_name.'.png' : '/cards/assets/img/badges/webbed.svg')?>" alt="" width="225">
                        <p class="text-muted f-18 mt-4"><?=$badge["description"];?></p>
                    </div>
                </div>

                <div class="card-footer p-3">
                    <div class="pull-right">
                        <p class="text-muted"><i class="fa-regular fa-copyright"></i> Ilustred by. <?=$badge["artist"];?></p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <?php require_once('_suggested_users.php') ?>
        </div>
    </div>
</div>

<script src="/cards/assets/js/globalController.js"></script>
<script>
    $( document ).ready(function() {
        $("#Messages").addClass('active');

        <?php if(isset($_GET["error"])) { ?>
            $('#errorOnAccess').toast('show');
        <?php } ?>
    }); 
</script>
</body>
<?php require_once('cards/www/templates/_footer.php'); ?>
</html>
