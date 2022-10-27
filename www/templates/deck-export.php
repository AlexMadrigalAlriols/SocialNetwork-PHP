<!DOCTYPE html>
<html lang="en">
<?php require_once("cards/www/controllers/deck-view.php"); ?>
<?php require_once('header.php'); ?>
<body id="body-pd" class="body-pd overflow-x-hidden">
    <?php require_once('navControlPanel.php') ?>

    <div class="card mb-3 filterBox" id="secondStep">
          <div class="card-header">
            <div>
              <h4 class="d-inline-block"><?=$deck["name"];?></h4>
              <p><b><?=$user->i18n("owner");?>: </b> <?=$deck["owner_name"];?></p>
            </div>
          </div>

          <div class="card-body">
            <div class="col-md-10" class="d-inline-block">
            <div class="card view-deck-card">
              <div class="card-header">
                <h6 class="d-inline-block"><?=$user->i18n("deck_list");?></h6>
              </div>

              <div class="card-body">
                <textarea name="textCards" id="textCards" cols="50" rows="20" class="form-control"><?=$user->i18n("deck");?><?php echo "\n"; foreach (json_decode($deck["cards"], true) as $name => $qty) { echo $qty . " " . $name . "\n"; } ?><?php if(count(json_decode($deck["sideboard"], true))){ echo "Sideboard"; }?><?php echo "\n"; foreach (json_decode($deck["sideboard"], true) as $name => $qty) { echo $qty . " " . $name . "\n"; } ?></textarea>
              </div>
            </div>

            </div>
            <div class="col-md-2 container d-inline-block">
            <div class="row">
              <a class="btn btn-primary mb-3 mt-3" href="/deck/<?php echo $id_deck; ?>"><i class='bx bx-left-arrow-alt'></i> <?=$user->i18n("deck_page");?></a>
            </div>
            </div>
          </div>
    </div>
</body>

</html>

<script src="/cards/assets/js/headerControler.js"></script>