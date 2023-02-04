
<?php
    require_once("cards/www/controllers/reports.php");
?>
<!DOCTYPE html>
<html lang="en">
<?php  require_once('header.php'); ?>
<body id="body-pd" class="body-pd overflow-hidden">

<?php require_once('navControlPanel.php') ?>

<div style="position:relative; margin-top: 6rem; height: 100%;">
<img src="/cards/assets/img/liliana_player.png" class="align-top position-absolute top-0 start-0" style="margin-top: -4rem;" alt="Liliana Image" id="decoration_img">
<div class="container">
    <div class="row">
        
        <div id="header mb-2">
            <h1 class="d-inline-block">Reports</h1>
            <a href="/reports<?=(isset($_GET["all"]) ? "" : "?all")?>" class="d-inline-block btn btn-primary" style="float:right;">Go to <?= (isset($_GET["all"]) ? "not resolved" : "all")?> reports</a>
        </div>
        
        
        <div class="bg-dark mt-2" style="overflow-y: auto; width: 100%; height: 60vh; z-index: 999;">
        <?php foreach ($reports as $idx => $report) { ?>
            <div class="card mt-3">
                <div class="card-body">
                    <img src="<?=$report["profile_image"]; ?>" alt="" width="45px" height="45px" style="border-radius: 25%;">
                    <div class="d-inline-block ms-3">
                        <span><?=($report["name"] ? $report["name"] : "DELETED USER");?></span>
                        <span class="text-muted">@<?=($report["username"] ? $report["username"] : "-");?></span>
                    </div>
                    <form method="post" class="d-inline-block" style="float:right;">
                        <button class="btn btn-success ms-2" type="submit" name="command_accept" value="<?=$report["id_report"];?>">Aceptar</button>
                        <button class="btn btn-danger ms-2" type="submit" name="command_deny" value="<?=$report["id_report"];?>">Denegar</button>
                    </form>

                    <a href="<?php if($report["report_type"] == REPORT_PUBLICATION){ echo '/publication/'. $report["reported_publication"]; } else if($report["report_type"] == REPORT_DECK) { echo '/deck/'.$report["reported_deck"]; } else { echo '/profile/'.$report["reported_user_id"]; } ?>" class="btn btn-secondary" style="float:right;">Ver <?php if($report["report_type"] == REPORT_PUBLICATION){ echo 'Publication'; } else if($report["report_type"] == REPORT_DECK) { echo 'Deck'; } else { echo 'Perfil'; } ?></a>

                </div>
            </div>
        <?php } ?>
        </div>
    </div>
</div>
</div>
<script src="/cards/assets/js/headerControler.js"></script>

</html>

<script>
    $( document ).ready(function() {
        <?php if(isset($id_verification) && $id_verification != ""){ ?>
            $.ajax({
                url: '/procesos/users/mail_verification',
                type: 'POST',
                async: false,
                data: {id_verification: "<?= $id_verification; ?>"},
                success: function(data) {
                    if(data == 1){
                        window.location="/settings?success=1";
                    } else {
                        window.location="/settings?error=1";
                    }
                    
                }
            });
        <?php } ?>
        $("#reports").addClass('active');
    });
</script>
<?php require_once('cards/www/templates/_footer.php'); ?>