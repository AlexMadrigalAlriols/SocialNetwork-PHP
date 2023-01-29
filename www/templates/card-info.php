<!DOCTYPE html>
<html lang="en">

<?php require_once('header.php'); ?>

<body id="body-pd" class="body-pd overflow-x-hidden">
    <?php require_once("cards/www/controllers/card-info.php");?>
    <?php require_once('navControlPanel.php') ?>

    <div class="card filterBox loader-container" id="containerLoader">
        <div id="loader"></div>
    </div>

    
    <div class="card mb-3 filterBox" id="deck-container" style="display: none;">
        <div class="p-3">
          <div class="d-inline-block me-3">
            <img src="<?=$card["set_info"]["icon_svg_uri"];?>" class="d-inline-block me-2 align-top" width="35">
            <h5 class="d-inline-block align-middle"><?=$card["set_info"]["name"];?></h5>
          </div>
          <div class="dropdown d-inline-block align-baseline">
            <button class="btn btn-outline-primary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
              Other Versions
            </button>
            <ul class="dropdown-menu">
              <?php foreach ($card["other_versions"]["data"] as $idx => $set) { ?>
                <li><a class="dropdown-item" href="/card/<?=$set["id"];?>"><?=$set["set_name"];?></a></li>
              <?php } ?>
            </ul>
          </div>
          <div class="pull-right mt-3">
              <h3 class="d-inline-block text-purple-light tabletop-text">Tabletop: <span class="f-25" id="priceTotal"><?=($card["prices"]["usd"] ? $card["prices"]["usd"] : "-")?></span> $</h3>
              <h4 class="d-inline-block tabletop-text text-purple-light">FOIL: <span class="f-25" id="priceFoilTotal"><?=($card["prices"]["usd_foil"] ? $card["prices"]["usd_foil"] : "-")?></span> $</h4>
              <h5 class="d-inline-block tabletop-text">MTGO: <span class="f-20" id="priceTixTotal"><?=($card["prices"]["tix"] ? $card["prices"]["tix"] : "-")?></span> tix</h5>
          </div>
        </div>

        <div class="row">
          <div class="col-md-3">
            <div class="container text-center">
              <div class="">
                <img src="<?=$card["image_uris"]["large"];?>" alt="" width="250" class="rounded">
                <div class="buttons mt-4">
                  <form method="POST">
                    <button class="btn btn-primary w-100" name="commandPutOnCollection" value="1" type="submit"><i class="fa-solid fa-plus me-2"></i> <?=$user->i18n("add_to_collec");?></button>
                  </form>
                </div>
              </div>
            </div>

          </div>
          <div class="col-md-9 p-3">
            <h3 class="d-inline-block"><?=$card["name"];?> <?=apiService::getManaCostImg($card["mana_cost"]);?></h3>
            <p><?=$card["type_line"];?></p>
            <hr>
            <h5><?=ucfirst($card["rarity"]);?></h5>
            <p><?=$card["oracle_text"];?></p>
            <?php if(isset($card["power"])) {?><h5><?=$card["power"];?>/<?=$card["toughness"];?></h5><?php } ?>
            <hr>
            <p class="text-muted">#<?=$card["collector_number"];?> <?=$user->i18n("ilustred_by");?> <?=$card["artist"];?></p>

            <div class="row">
              <div class="col-md-9 p-3">
                <div class="card view-deck-card">
                  <div class="card-header">
                    <h6 class="d-inline-block"><?=$user->i18n("legalities");?></h6>
                    <span class="d-inline-block pull-right" id="rarityCount"></span>
                  </div>
                  <div class="card-body">
                    <div class="row">
                      <table class="table table-legalities text-white">
                        <tbody>
                          <?php foreach ($card["legalities"] as $format => $legality) { ?>
                            <tr>
                              <td class="p-2"><?= ucfirst($format); ?></td>
                              <td class="p-2"><span class="label label-<?=$legality;?>"><?= $user->i18n($legality); ?></span></td>
                            </tr>
                          <?php } ?>
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-md-3 p-4">
                <h4><?=$user->i18n("buy_card");?>:</h4>
                <?php foreach ($card["purchase_uris"] as $idx => $url) { ?>
                  <a class="btn btn-primary w-100 mt-3" href="<?=$url;?>" target="_blank"><i class="fa-solid fa-cart-shopping me-3"></i> <?=ucfirst($idx);?></a>
                <?php } ?>
              </div>
            </div>
          </div>
        </div>
  </div>
  <?php require_once('_toast.php') ?>
</body>

<script src="/cards/assets/js/headerControler.js"></script>
<script>
    var timeout;

    $( document ).ready(function() {
        setTimeOut();

        <?php if(isset($_GET["success"])) { ?>
          $('#added_collection').toast('show');
        <?php } ?>
    });

    function setTimeOut() {
        timeout = setTimeout(showPage, 0);
    }

    function showPage() {
        $("#loader").addClass("d-none");
        $("#deck-container").removeClass("d-none");
        $("#deck-container").addClass("d-flex");
        $("#containerLoader").addClass("d-none");
    }

</script>
<?php require_once('cards/www/templates/_footer.php'); ?>
</html>