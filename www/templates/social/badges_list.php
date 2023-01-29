<?php require_once('cards/www/controllers/badges.php'); ?>
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
                <div class="card-header">
                    <h3 class="d-inline-block">
                        <a href="/profile/@<?=$user_profile_details["username"];?>" class="text-purple"><i class="fa-solid fa-chevron-left me-3"></i></a> 
                        <?=$user_profile_details["name"];?> <?=$user->i18n("badges");?>
                        (<?=count($user_badges);?> / <?=count($badges);?>)
                    </h3>
                </div>   
                <div class="card-body">
                    <div class="container text-center">
                        <?php foreach ($badges as $name => $badge) { ?>
                            <a href="/badge/<?=$name;?>" class="text-decoration-none">
                            <div class="d-inline-block m-3 badge <?=(isset($user_badges[$name]) ? "earned" : "")?>" 
                                    data-bs-toggle="tooltip" 
                                    data-bs-html="true" 
                                    data-bs-placement="bottom" 
                                    data-bs-title="<b><?=$user->i18n("badge.".$name);?></b></br> 
                                    <span><i>Rarity: <?=$user->i18n("badge.rarity.".$badge["rarity"]);;?></span></i></br>
                                    <span><?=$badge["description"];?>!</span>">
                                <img src="<?=(file_exists('cards/assets/img/badges/'.$name.'.png') ? '/cards/assets/img/badges/'.$name.'.png' : '/cards/assets/img/badges/webbed.svg')?>" alt="" width="100">
                            </div>
                            </a>
                        <?php } ?>
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

        const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]')
        const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl))

        <?php if(isset($_GET["error"])) { ?>
            $('#errorOnAccess').toast('show');
        <?php } ?>
    }); 
</script>
</body>
<?php require_once('cards/www/templates/_footer.php'); ?>
</html>
