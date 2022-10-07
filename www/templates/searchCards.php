<!DOCTYPE html>
<html lang="en">
<?php require_once("cards/www/controllers/cards-search.php");?>
<?php require_once('header.php'); ?>

<body id="body-pd" class="body-pd overflow-x-hidden">
<?php require_once('navControlPanel.php') ?>

<div class="container" style="height: 79vh;">
    <?php if(isset($searched_cards[0]) && $searched_cards[0] == "none") { ?>
    <img src="/cards/assets/img/liliana_player.png" class="align-bottom position-absolute bottom-0 end-0" alt="Liliana Image" id="decoration_img">
    <?php } ?>
    
    <div class="row search-form">
        <div class="col-lg-4"></div>
            <div class="col-lg-4">
            <form method="post">
                <h2 class="text-center">Card Search</h2> <br>
                <div class="input-group">
                    <input type="text" class="form-control" list="form-body" placeholder="Ex. Lightning Bolt" id="searcher-card" name="searcher-card" required>
                    <datalist id="form-body"></datalist>

                    <div class="input-group-append">
                        <button class="btn btn-success" type="submit" name="commandSearch" value="1">Search</button>
                    </div>
                </div>
            </form>
        </div>
        <div class="col-lg-4"></div>
    </div>
    <div class="searchedCards mb-5 mt-2" id="searchedCards">
    <?php if(isset($searched_cards[0]) && $searched_cards[0] != "none") { ?>
        <?php foreach ($searched_cards as $idx => $card) { ?>
            <div class="text-center d-inline-block">
                <img src="<?= $card["img"]; ?>" width="250px" class="m-4"></br>
                <button class='btn btn-success openQtyModal' type='button' data-bs-toggle='modal' data-bs-target='#addModal' data-id="<?= $card["id"]; ?>" data-edition='<?= $card["set_name"]; ?>' data-set='<?= $card["set"]; ?>' data-name='<?= $card["name"]; ?>'>Add Collection</button>
            </div>
        <?php } ?>
    <?php } ?>
    </div>
    <?php if(!count($searched_cards)) { ?>
        <div class="container text-center mt-3" id="cardsNoFound">
            <div class="bg-none">
                <div class="">
                    <img src="/cards/assets/img/jace_player.png" class="mt-3 opacity-75" width="35%">
                    <h2>No Cards Found</h2>
                </div>
            </div>
        </div>
    <?php } ?>
    </div>

</div>

<!-- Modals -->
<div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title text-black" id="card-name">Undefined </h5><span id="card-set" class="text-black"><b>&nbsp; </b></span>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body text-black">
        <h6>Select Qty:</h6>
        <form>
            <input type="number" name="card_qty" class="form-control" min="1" id="add_qty" value="1">
            <h6 class="mt-3">Additonal Info:</h6>
            <input type="text" name="card_desc" class="form-control" id="card_desc" placeholder="Card Descriptions">
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-primary" id="add-collection">Add to Collection</button>
      </div>
    </div>
  </div>
</div>
<div id="added" class="toast bg-success position-fixed bottom-0 m-3" role="alert" aria-live="assertive" aria-atomic="true">
    <div class="d-flex">
        <div class="toast-body">
            Success added to collection.
        </div>
        <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
    </div>
</div>

<div id="error" class="toast bg-danger position-fixed bottom-0 m-3" role="alert" aria-live="assertive" aria-atomic="true">
    <div class="d-flex">
        <div class="toast-body">
            Error adding card to collection.
        </div>
        <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
    </div>
</div>

</body>

<script>
    var cardId = "";
    var cardName = "";

    $( document ).ready(function() {
        $("#search").addClass('active');

        $('#searcher-card').keyup(function() {
            $.ajax({
                url: '/autoComplet',
                type: 'POST',
                data: {autocomplet: $("#searcher-card").val()},
                success: function(data) {
                    resultNames = data.split(";");
                    $(".elementos-cartas").remove();

                    resultNames.forEach(name => {
                        if(name != ""){
                            html = "<option value="+name+"></option>";
                            $("#form-body").append(html);
                        }
                    });
                }
            });
        });
    });

    function getCompletedNameCard(cardClicked){
        $("#searcher-card").val(cardClicked.text);
        $(".elementos-cartas").remove();
    }

    $(document).on("click", ".openQtyModal", function () {
        cardId = $(this).data('id');
        cardName = $(this).data('name');
        cardEdition = $(this).data('edition');
        cardSet = $(this).data('set');

        $('#card-name').text(cardName);
        $('#card-set').html("<b> &nbsp; (" + cardSet + ") </b>");
    });

    $(document).on("click", "#add-collection", function () {
        $.ajax({
            url: '/addCardsCollection',
            type: 'POST',
            async: false,
            data: {id_card: cardId, card_name: cardName, card_info: $("#card_desc").val(), qty: $("#add_qty").val()},
            success: function(data) {
                if(data == 0) {
                    $('#error').toast('show');
                    $('#addModal').modal('toggle');
                } else {
                    $('#added').toast('show');
                    $('#addModal').modal('toggle');
                }
            }
        });
    });
</script>
<script src="/cards/assets/js/headerControler.js"></script>

</html>
