<!DOCTYPE html>
<html lang="en">
<?php require_once("cards/www/controllers/deck-edit.php"); ?>
<?php require_once('header.php'); ?>
<body id="body-pd" class="body-pd" style="overflow-x: hidden;">

    <?php require_once('navControlPanel.php') ?>
    <div class="form-decks" style="position: relative;">
    
      <div class="card mb-3 filterBox card-active" id="firstStep">
          <div class="card-header">
              <h6><?=($id_deck != 0 ? "Edit Deck" : "New Deck");?></h6>
          </div>
        <div class="card-body">
                <div class="row px-4">
                    <form>
                        <div class="input-group">
                            <div class="ml-3 mb-4 col-lg-12">
                                <label for="cardNameLabel" class="form-label">Deck Name</label>
                                <input type="text" class="form-control" id="cardNameLabel" placeholder="Ex. Death's Shadow" name="cardName" aria-describedby="validationServer03Feedback" value="<?=$deck["name"]?>">
                                <div id="validationServer03Feedback" class="invalid-feedback">
                                Invalid deck name.
                                </div>
                              </div>
                        </div>

                        <div class="input-group">
                            <div class="ml-3 mb-4 col-lg-12">
                                <label for="deckFormat" class="form-label">Format</label>
                                <select class="form-select" aria-label="Default select example" name="format" id="format">
                                  <?php foreach ($formats as $idx => $value) { ?>
                                    <option value="<?=$value;?>" <?= ($value == $deck["format"] ? "selected" : ""); ?>><?=$value;?></option>
                                  <?php } ?>
                                </select>
                            </div>
                        </div>

                        <div class="input-group">
                            <div class="ml-3 mb-4 col-lg-12">
                                <label for="deckOptionsLabel" class="form-label">Options</label>
                                <div class="form-check">
                                  <input class="form-check-input" type="checkbox" value="" id="privateDeck" name="privateDeck" <?=($deck["private"] == 1 ? "checked" : "");?>>
                                  <label class="form-check-label" for="privateDeck">
                                    Private Deck
                                  </label>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <button type="button" class="btn btn-success" style="float:right; margin: 5px;" id="nextAddCards">Next</button>
                            <a href="/decks"><button type="button" class="btn btn-danger" style="float:right; margin: 5px;">Cancel</button></a>
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
                              <label for="cardMainDeck" class="form-label">Maindeck</label>
                              <textarea class="form-control" placeholder="4 Fatal Push" id="textCards" rows="6" cols="5" aria-describedby="validationAddDeck"><?=$cards;?></textarea>
                              <div id="validationAddDeck" class="invalid-feedback">Can't create a deck without cards.</div>

                              <div class="row text-center">
                                <div class="col-md-12 mt-3">
                                  <div class="col-md-2 mb-3 d-inline-block">
                                      <input type="number" class="form-control" placeholder="Qty" id="addQty" value="1" max="4" min="1">
                                  </div>

                                  <div class="col-md-5 mr-3 d-inline-block">
                                    <input type="text" class="form-control" list="form-body" placeholder="Card Name" id="addName">
                                    <datalist id="form-body"></datalist>
                                  </div>

                                  

                                  <div class="col-md-4 d-inline-block">
                                    <button class="btn btn-outline-success" id="btnAddCards" type="button" style="margin-bottom: 5px;">Add Card</button>
                                  </div>
                                </div>
                              </div>

                              <div class="row">
                                <div class="col-md-12">
                                <button class="btn btn-primary" id="btnPreview" type="button">Update Preview</button>
                                </div>
                                  
                              </div>
                            </div>
                          <div class="mb-4 col-md-6 deckpreview">
                              <div class="card">
                                <div class="card-header"><b>Deck Preview &nbsp;</b>
                                  <span style="float:right; margin-right: 10px;" id="cardsCount"></span>
                                </div>
                                <div class="card-body">
                                    <svg xmlns="http://www.w3.org/2000/svg" style="display: none;">
                                      <symbol id="check-circle-fill" fill="currentColor" viewBox="0 0 16 16">
                                        <path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/>
                                      </symbol>
                                    </svg>
                                  <div class="alert alert-warning alert-dismissible d-none" role="alert" id="cardsNotLegal">
                                    <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Success:"><use xlink:href="#check-circle-fill"/></svg>Cards not legals: <a id="whatCards"></a> <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                  </div>
                                  <div id="mainCards"></div>
                                  <div id="sideCards"></div>
                                </div>
                              </div>
                          </div>
                      </div>

                      <div class="mb-3 buttons-editDeck" style="float: right;">
                        <a href="/decks"><button type="button" class="btn btn-danger" style="margin: 5px;">Cancel</button></a>
                          <button type="button" class="btn btn-warning" style="margin: 5px;" id="backAddCards">Back</button>
                          <button type="button" class="btn btn-success" style="margin: 5px;" id="addNewDeck">Save</button>
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