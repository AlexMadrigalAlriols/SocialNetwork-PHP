<!DOCTYPE html>
<html lang="en">
<?php require_once("cards/www/controllers/deck-edit.php"); ?>
<?php require_once('header.php'); ?>
<body id="body-pd" class="body-pd overflow-x-hidden">

    <?php require_once('navControlPanel.php') ?>
    <div class="form-decks position-relative">
    
      <div class="card mb-3 filterBox card-active" id="firstStep">
          <div class="card-header">
              <h6><?=($id_deck != 0 ? "Edit Deck" : "New Deck");?></h6>
          </div>
        <div class="card-body">
                <div class="row px-4">
                    <form>
                        <div class="input-group">
                            <div class="ml-3 mb-4 col-lg-12 addon-btn-filters">
                                <label for="cardNameLabel" class="form-label"><?= $user->i18n("deck_name");?></label>
                                <input type="text" class="form-control" id="cardNameLabel" placeholder="Ex. Death's Shadow" name="cardName" aria-describedby="validationServer03Feedback" value="<?=$deck["name"]?>">
                                <div id="validationServer03Feedback" class="invalid-feedback">
                                  <?= $user->i18n("deck_name_error");?>
                                </div>
                              </div>
                        </div>

                        <div class="input-group">
                            <div class="ml-3 mb-4 col-lg-12 addon-btn-filters">
                                <label for="deckFormat" class="form-label"><?= $user->i18n("format");?></label>
                                <select class="form-select" aria-label="Default select example" name="format" id="format">
                                  <?php foreach ($formats as $idx => $value) { ?>
                                    <option value="<?=$value;?>" <?= ($value == $deck["format"] ? "selected" : ""); ?>><?=$value;?></option>
                                  <?php } ?>
                                </select>
                            </div>
                        </div>

                        <div class="input-group">
                            <div class="ml-3 mb-4 col-lg-12">
                                <label for="deckOptionsLabel" class="form-label"><?= $user->i18n("options");?></label>
                                <div class="form-check">
                                  <input class="form-check-input" type="checkbox" value="" id="privateDeck" name="privateDeck" <?=($deck["private"] == 1 ? "checked" : "");?>>
                                  <label class="form-check-label" for="privateDeck">
                                    <?= $user->i18n("private_deck");?>
                                  </label>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <button type="button" class="btn btn-success pull-right m-1" id="nextAddCards"><?= $user->i18n("next");?></button>
                            <a href="/decks"><button type="button" class="btn btn-danger m-1 pull-right"><?= $user->i18n("cancel");?></button></a>
                        </div>
                    </form>
                </div>
            </div>
      </div>

      <div class="card mb-3 filterBox card2" id="secondStep">
          <div class="card-header">
              <h6><?=($id_deck != 0 ? "Edit Deck" : "New Deck");?></h6>
          </div>

          <div class="card-body">
              <div class="row">
                  <form>
                      <div class="input-group">
                            <div class="col-md-4 maindeck-edit">
                              <label for="cardMainDeck" class="form-label"><?= $user->i18n("main_deck");?></label>
                              <textarea class="form-control" placeholder="4 Fatal Push" id="textCards" rows="6" cols="5" aria-describedby="validationAddDeck"><?=$cards;?></textarea>
                              <div id="validationAddDeck" class="invalid-feedback"><?= $user->i18n("no_cards_error");?></div>

                              <div class="row text-center">
                              <h6 class="pull-left mt-3">Add Cards:</h6>
                                <div class="col-md-12">
                                  <div class="col-md-2 mb-3 d-inline-block">
                                      <input type="number" class="form-control" placeholder="Qty" id="addQty" value="1" max="4" min="1">
                                  </div>

                                  <div class="col-md-5 mr-3 d-inline-block">
                                    <input type="text" class="form-control" list="form-body" placeholder="Card Name" id="addName">
                                    <datalist id="form-body"></datalist>
                                  </div>

                                  <div class="col-md-4 d-inline-block">
                                    <button class="btn btn-outline-success m-1 addon-btn-filters" id="btnAddCards" type="button"><?= $user->i18n("add_card");?></button>
                                  </div>
                                </div>
                              </div>

                              <div class="row">
                                <div class="col-md-12">
                                <button class="btn btn-primary addon-btn-filters mt-3" id="btnPreview" type="button"><?= $user->i18n("update_preview");?></button>
                                </div>
                                  
                              </div>
                            </div>
                          <div class="mb-4 col-md-6 deckpreview">
                              <div class="card">
                                <div class="card-header"><b><?= $user->i18n("deck_preview");?> &nbsp;</b>
                                  <span class="pull-right me-2" id="cardsCount"></span>
                                </div>
                                <div class="card-body">
                                  <div class="alert alert-warning alert-dismissible d-none" role="alert" id="cardsNotLegal">
                                    <i class="fa-solid fa-circle-exclamation me-2" width="24" height="24" role="img" aria-label="Success:" ></i><?= $user->i18n("cards_not_legal");?>: <a id="whatCards"></a> <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                  </div>
                                  <div id="mainCards"></div>
                                  <div id="sideCards"></div>
                                </div>
                              </div>
                          </div>
                      </div>

                      <div class="mb-3 buttons-editDeck pull-right">
                        <a href="/decks"><button type="button" class="btn btn-danger m-1"><?= $user->i18n("cancel");?></button></a>
                          <button type="button" class="btn btn-warning m-1" id="backAddCards"><?= $user->i18n("back");?></button>
                          <button type="button" class="btn btn-success m-1" id="addNewDeck"><?= $user->i18n("save");?></button>
                      </div>
                  </form>
              </div>
          </div>
      </div>
    </div>
</body>
</html>

<script src="/cards/assets/js/headerControler.js"></script>
<script src="/cards/assets/js/decksController.js"></script>
<script>
    $('#addNewDeck').click(function() {
      var allCards = "";
      if($("#textCards").val() == "") {
        $("#textCards").addClass("is-invalid");
      } else {
        var lines = $('#textCards').val().split('\n');
        var idx = 0;

        while(lines[idx] == "Deck" || lines[idx] == "Sideboard" || lines[idx] == "") {
          idx++;
        }

        matches = lines[idx].match(/^[1-9] (.*)$/);
        $.ajax({
          url: '/procesos/decks/getFirstEdition',
          type: 'GET',
          async: false,
          data: {card_name: (matches[1] == null ? "Lightning Bolt" : matches[1]), format: "Modern"},
          success: function(data) {
              allCards = JSON.parse(data);
              $.ajax({
                url: '/procesos/decks/addDeck', 
                type: 'POST',
                async: false,
                data: {name: $("#cardNameLabel").val(), format: $("#format").val(), deck_img: allCards[0].Card.ImgArt, cards: $("#textCards").val(), private: (document.querySelector('#privateDeck').checked ? 1 : 0), id_deck: '<?= $id_deck; ?>'},
                success: function(data) {
                  if(data != 0) {
                    window.location="/decks/0?success=add";
                  } else {
                    window.location="/decks/0?error=1";
                  }
                }
              });
          }
        });
      }
    });
</script>
<?php require_once('cards/www/templates/_footer.php'); ?>