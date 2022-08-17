<!DOCTYPE html>
<html lang="en">
<?php require_once("cards/www/controllers/cards.php");?>
<?php require_once('header.php'); ?>

<body id="body-pd" class="body-pd" style="overflow-x: hidden;">

<?php require_once('navControlPanel.php') ?>

<div style="position:relative;">

<div class="card mb-3 filterBox">
        <div class="card-header">
            <h6 class="d-inline-block"><i class="fa-solid fa-filter"></i> Cards Filter</h6>
            <button class="btn btn-primary d-inline-block" style="float:right;">Calculate Price Of Collection</button>
        </div>

        <div class="card-body">
            <div class="row px-4">
                <form>
                    <div class="input-group">
                        <div class="ml-3 col-lg-3" style="margin-right:1rem;">
                            <label for="name" class="form-label">Card Name</label>
                            <input type="text" class="form-control" id="name" placeholder="Ex. Lighting Bolt" name="name" value="<?php if(isset($_GET["name"])){ echo $_GET["name"]; } ?>">
                        </div>

                        <div class="col-lg-3" style="margin-right:1rem;">
                            <label for="info" class="form-label">Card Info</label>
                            <input type="text" class="form-control" id="info" name="info" placeholder="Ex. Foil" value="<?php if(isset($_GET["info"])){ echo $_GET["info"]; } ?>">
                        </div>

                        <div class="col-lg-3" style="margin-right:1rem;">
                            <label for="colors" class="form-label">Card Colors</label>
                            <select name="colors" id="colors" class="form-select">
                                <option value=""></option>
                                <option value="R">Red</option>
                                <option value="W">White</option>
                                <option value="U">Blue</option>
                                <option value="B">Black</option>
                                <option value="G">Green</option>
                                <option value=" ">Colorless</option>    
                            </select>
                        </div>
                    </div>

                    <div class="mb-3 mt-3">
                        <button class="btn btn-primary" type="button" data-bs-toggle="modal" data-bs-target="#modalImport">Import Cards</button>
                        <button type="submit" class="btn btn-success" style="float:right;" id="searchFilter">Search</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="searchedCollection" style="position: relative;" id="searchedCards">
        <?php foreach ($cards as $key => $card) { ?>
            <div class="card text-center deck-card" style="width: 18rem; display:inline-block;">
            <h5 class="card-header"><b><?= $card["card_name"]; ?></b></h5>
            <img src='<?= $card["card_img"]; ?>' class="card-img-top container" style="margin: 10px; width: 225px;">
            <hr style="margin-bottom: -5px;">
            <div class="card-body" style="float:left; text-align: left;">
                <p class="card-text"><b>Qty: </b><?= $card["qty"]; ?></p>
                <p class="card-text"><b>Aditional Info: </b><?= ($card["card_info"] ? $card["card_info"] : "-"); ?></p>
                <p class="card-text"><b>Price: </b> <?= $card["card_price_eur"] ?> €</p>
                <p class="card-text"><b>Tix Price: </b> <?= $card["card_price_tix"] ?>  tix</p>
                <div class="text-center">
                    <button class="btn btn-success openAddModal d-inline-block" style="margin-right: 5px;" type="button" data-bs-toggle="modal" data-bs-target="#modalAdd" data-id="<?= $card["id_card"]; ?>" data-qty="<?= $card["qty"]; ?>" data-set="<?= $card["card_set"]; ?>" data-name="<?= $card["card_name"]; ?>">Add More</button>
                    <button class="btn btn-danger openDelModal d-inline-block" type="button" data-bs-toggle="modal" data-bs-target="#exampleModal" data-id="<?= $card["id_card"]; ?>" data-qty="<?= $card["qty"]; ?>" data-set="<?= $card["card_set"]; ?>" data-name="<?= $card["card_name"]; ?>">Remove Cards</button>
                </div>
            </div>
        </div>
        <?php } ?>
    </div>
</div>
<?php if(!count($cards)) { ?>
    <div class="container text-center" id="cardsNoFound">
        <div class="card">
            <div class="card-body">
                <h2>No Cards Found</h2>
                <img src="/cards/assets/img/jace_player.png" class="mt-3" width="35%" style="opacity: 70%;">
            </div>
        </div>
    </div>
<?php } ?>
    <div class="container text-center mb-3" id="pager">
        <?php for ($i=0; $i < $pages; $i++) { ?>
            <a href='/cards/<?=$i?>?name=<?=(isset($_GET["name"]) ? $_GET["name"] : ""); ?>&info=<?=(isset($_GET["info"]) ? $_GET["info"] : ""); ?>&colors=<?=(isset($_GET["colors"]) ? $_GET["colors"] : ""); ?>'><button class='btn <?= ($i == $id_page ? "btn-primary" : "btn-success") ?>' style='margin: 5px;'><?=$i + 1;?></button></a>
        <?php } ?>
    </div>
</body>

<!-- Modals -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="card-name" style="color: black;">Undefined </h5><span id="card-set" style="color: black;"><b>&nbsp; </b></span>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <h6 style="color: black;">Remove Qty:</h6>
            <form>
                <input type="number" name="card_qty" class="form-control" min="1" id="del_qty" value="1">
            </form>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Cancel</button>
            <button type="button" class="btn btn-danger" id="deleteCard">Remove of Collection</button>
        </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalAdd" tabindex="-1" aria-labelledby="modalAddLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="card-name-add" style="color: black;">Undefined </h5><span id="card-set-add" style="color: black;"><b>&nbsp; </b></span>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <h6 style="color: black;">Select Qty:</h6>
                <form>
                    <input type="number" name="card_qty" class="form-control" min="1" id="add_qty" value="1">
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" id="addMoreCards">Add to Collection</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="modalImport" tabindex="-1" aria-labelledby="modalImportLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="card-name-add" style="color: black;">Import Cards To Collection </h5></span>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="post">
                <div class="modal-body">
                    <h6 style="color: black;">Card List</h6>
                        <textarea name="import_cards" class="form-control" placeholder="4 Black Lotus (Lea)&#10;4 Lightning Bolt&#10;..." rows=4" required></textarea>
                    
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary" name="command_import" value="1">Import Cards</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div id="added" class="toast bg-success position-fixed bottom-0 m-3" role="alert" aria-live="assertive" aria-atomic="true" style="z-index: 1000;">
    <div class="d-flex">
        <div class="toast-body">
            Success added to collection.
        </div>
        <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
    </div>
</div>
<div id="imported" class="toast bg-success position-fixed bottom-0 m-3" role="alert" aria-live="assertive" aria-atomic="true" style="z-index: 1000;">
    <div class="d-flex">
        <div class="toast-body">
            Success imported cards to collection.
        </div>
        <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
    </div>
</div>
</html>

<script>
    var cardId = "";
    var cardName = "";

    $( document ).ready(function() {
        $("#collection").addClass('active');

        <?php if(isset($_GET["colors"])){ ?>
            $('#colors option[value="<?php echo $_GET["colors"]; ?>"]').prop("selected", true);
        <?php } ?>

        <?php if(isset($_GET["success"])) { ?>
            <?php if($_GET["success"] == "add") { ?>
                $('#added').toast('show');
            <?php } ?>
            <?php if($_GET["success"] == "remove") { ?>
                $('#removed').toast('show');
            <?php } ?>
            <?php if($_GET["success"] == "import") { ?>
                $('#imported').toast('show');
            <?php } ?>
        <?php } ?>

        $(document).on("click", "#deleteCard", function () {
            if (confirm("You want to delete "+$("#del_qty").val()+" "+cardName+"?")) {
                $.ajax({
                    url: '/removeCard',
                    type: 'POST',
                    async: false,
                    data: {id_card:cardId, qty: $("#del_qty").val()},
                    success: function(data) {
                        window.location="/cards/<?=$id_page;?>?success=remove";
                    }
                });
            }
        });

        $(document).on("click", "#addMoreCards", function () {
            $.ajax({
                url: '/addCardsCollection',
                type: 'POST',
                async: false,
                data: {id_card: cardId, card_name: cardName, qty: $("#add_qty").val()},
                success: function(data) {
                    window.location="/cards/<?=$id_page; ?>?success=add";
                }
            });
        });

        //-------------------------- MODALS ----------------------------\\
        $(document).on("click", ".openDelModal", function () {
            cardId = $(this).data('id');
            cardName = $(this).data('name');
            qty = $(this).data('qty');
            cardSet = $(this).data('set');

            $('#qty_cards').attr("max", qty)
            $('#card-name').text(cardName);
            $('#card-set').html("<b> &nbsp; (" + cardSet + ") </b>");
        });

        $(document).on("click", ".openAddModal", function () {
            cardId = $(this).data('id');
            cardName = $(this).data('name');
            qty = $(this).data('qty');
            cardSet = $(this).data('set');

            $('#card-name-add').text(cardName);
            $('#card-set-add').html("<b> &nbsp; (" + cardSet + ") </b>");
        });
    });

</script>

<script src="/cards/assets/js/headerControler.js"></script>