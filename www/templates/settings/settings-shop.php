<?php require_once('cards/www/controllers/settings-shop.php'); ?>
<!DOCTYPE html>
<html lang="en">
<?php require_once('cards/www/templates/header.php'); ?>
<body id="body-pd" class="body-pd overflow-x-hidden">

<?php 
  require_once('cards/www/templates/navControlPanel.php');
  $shop_config = json_decode($user_details["shop_config"], true);
?>
  <body>
    <div class="row gutters-sm settings-header margin-top">
    <?php require_once('settings-header.php'); ?>
        <div class="col-md-8">
          <div class="card">
            <?php require_once('settings-header-movile.php'); ?>
            <div class="card-body tab-content">
              <div class="tab-pane active" id="profile">
                <h6><?= strtoupper($user->i18n("shop_settings")); ?></h6>
                <hr>
                <form id="frm" method="POST" enctype="multipart/form-data">
                    <div class="form-group mb-3">
                        <label for="shop"><?= $user->i18n("shop_enabled"); ?></label><br>
                        <small id="shopHelp" class="form-text text-muted"><?=$user->i18n("shop_enabled_help");?></small>
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="shop" name="shop_config[shop]" <?=(isset($shop_config["shop"]) && $shop_config["shop"] ? "checked" : "")?>>
                        </div>
                    </div>
                        <?php if($shop_config["shop"]) { ?>
                          <label for="currency" class="mt-2"><?= $user->i18n("currency"); ?></label>
                          <select class="form-select" id="shop_currency" name="shop_config[shop_currency]">
                              <?php foreach ($currencies as $idx => $value) { ?>
                                  <option value="<?= $idx; ?>" <?=($shop_config["shop_currency"] == $idx ? "selected" : "")?>><?= $value; ?></option>
                              <?php } ?>
                          </select>

                          <div class="form-group">
                            <label for="cardmarket_link" class="mt-3">Cardmarket</label><br>
                            <input type="text" class="mt-2 form-control" placeholder="CardMarket Link" id="cardmarket_link" name="shop_config[cardmarket_link]" value="<?=(isset($shop_config["cardmarket_link"]) ? $shop_config["cardmarket_link"] : "");?>">
                          </div>

                          <div class="form-group mt-3">
                            <label for="shop_img"><?= $user->i18n("shop_logo"); ?></label><br>
                            <small class="text-muted"><?= $user->i18n("png_recommend"); ?></small>
                            <input type="file" class="form-control mt-2" id="shop_img" name="shop_img[shop_img]" value="<?=(isset($shop_config["shop_img"]) ? $shop_config["shop_img"] : "")?>">

                            <?php if(isset($shop_config["shop_img"]) && $shop_config["shop_img"] != "") { ?>
                              <label class="mt-3"><?=$user->i18n("actual_shop_logo");?>:</label><br>
                              <img src="/<?=$shop_config["shop_img"]; ?>" width="75" class="img-fluid mt-3">
                            <?php } ?>
                          </div>
                      
                          <div class="form-group">
                            <label for="first_color" class="mt-3"><?= $user->i18n("principal_color"); ?></label><br>
                            <small class="text-muted"><?= $user->i18n("first_color_help"); ?></small><br>
                            <input type="color" class="mt-2" name="shop_config[principal_color]" value="<?=(isset($shop_config["principal_color"]) ? $shop_config["principal_color"] : "");?>">
                          </div>

                          <div class="form-group">
                            <label for="secondary_color" class="mt-3"><?= $user->i18n("secondary_color"); ?></label><br>
                            <small class="text-muted mb-2"><?= $user->i18n("second_color_help"); ?></small><br>
                            <input type="color" class="mt-2" name="shop_config[secondary_color]" value="<?=(isset($shop_config["secondary_color"]) ? $shop_config["secondary_color"] : "");?>">
                          </div>
                        <?php } ?>
                    </div>
                    <button type="submit" class="btn btn-primary pull-right" name="commandUpdateShop" value="1"><?= $user->i18n("update"); ?> <?= $user->i18n("settings"); ?> <i class="fa-regular fa-floppy-disk ms-1"></i></button>
                </form>
              </div>

            </div>
          </div>
        </div>
      </div>
    </div>
    <?php require_once('cards/www/templates/_footer.php'); ?>
    <script>
        $( document ).ready(function() {
            $("#settings").addClass('active');
            $("#settingsShop").addClass('active');
            $("#settings-shop-movile").addClass('active');
        });
    </script>
    <script src="/cards/assets/js/headerControler.js"></script>
  </body>
</html>
