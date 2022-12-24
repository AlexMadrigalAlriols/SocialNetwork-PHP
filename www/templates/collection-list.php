<!DOCTYPE html>
<html lang="en">
<?php require_once("cards/www/controllers/cards.php");?>
<?php require_once('header.php'); ?>

<body id="body-pd" class="body-pd overflow-x-hidden">

<?php require_once('navControlPanel.php') ?>

<div class="position-relative">

    <div class="card mb-3 filterBox">
        <div class="card-header">
            <h6 class="d-inline-block"><i class="fa-solid fa-filter me-2"></i> <?=$user->i18n("filters");?></h6>
            <a href="/get-collection-price" class="btn btn-primary d-inline-block pull-right"><?=$user->i18n("calculate_collection");?></a>
        </div>

        <div class="card-body">
            <div class="row px-4">
                <form>
                    <div class="input-group">
                        <div class="ml-3 col-lg-3 me-4 addon-btn-filters">
                            <label for="name" class="form-label"><?=$user->i18n("card_name");?></label>
                            <input type="text" class="form-control" id="name" placeholder="Ex. Lighting Bolt" name="name" value="<?php if(isset($_GET["name"])){ echo $_GET["name"]; } ?>">
                        </div>

                        <div class="col-lg-3 me-4 addon-btn-filters">
                            <label for="info" class="form-label"><?=$user->i18n("card_info");?></label>
                            <input type="text" class="form-control" id="info" name="info" placeholder="Ex. Foil" value="<?php if(isset($_GET["info"])){ echo $_GET["info"]; } ?>">
                        </div>

                        <div class="col-lg-3 me-4 addon-btn-filters">
                            <label for="colors" class="form-label"><?=$user->i18n("card_colors");?></label>
                            <select name="colors" id="colors" class="form-select">
                                <option value=""></option>
                                <?php foreach (gc::getSetting("cards.colors") as $idx => $color) { ?>
                                    <option value="<?=$color;?>"><?=$user->i18n("color.".$color);?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>

                    <div class="mb-3 mt-3">
                        <button type="submit" class="btn btn-success pull-right" id="searchFilter"><i class="fa-solid fa-magnifying-glass me-2"></i> <?=$user->i18n("search");?></button>
                        <button class="btn btn-primary addon-btn-filters" type="button" data-bs-toggle="modal" data-bs-target="#modalImport"><i class="fa-solid fa-file-import me-2"></i> <?=$user->i18n("import_cards");?></button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="searchedCollection position-relative" id="searchedCards">
        <?php foreach ($cards as $key => $card) { ?>
        <div class="card text-center deck-card d-inline-block card-tournaments highlighted-hover">
            <h5 class="card-header"><b><?= $card["card_name"]; ?> (<?=$card["card_set"]?>)</b></h5>
            <a href="/card/<?=$card["id_card"];?>"><img src='<?= $card["card_img"]; ?>' class="card-img-top container card-images align-bottom"></a>
            <hr>
            <div class="card-body pull-left align-middle">
                <p class="card-text"><b><?=$user->i18n("qty");?>: </b><?= $card["qty"]; ?></p>
                <p class="card-text"><b><?=$user->i18n("additional_info");?>: </b><?= ($card["card_info"] ? $card["card_info"] : "-"); ?></p>
                <p class="card-text"><b><?=$user->i18n("actual_price");?>: </b> <?= $card["card_price_eur"] ?> €</p>
                <p class="card-text"><b><?=$user->i18n("tix_price");?>: </b> <?= $card["card_price_tix"] ?>  tix</p>
                <div class="text-center">
                    <button class="btn btn-success openAddModal d-inline-block me-1 addon-btn-filters" type="button" data-bs-toggle="modal" data-bs-target="#modalAdd" data-id="<?= $card["id_card"]; ?>" data-qty="<?= $card["qty"]; ?>" data-set="<?= $card["card_set"]; ?>" data-name="<?= $card["card_name"]; ?>"><i class="fa-solid fa-plus"></i> <?=$user->i18n("add");?></button>
                    <button class="btn btn-danger openDelModal d-inline-block addon-btn-filters" type="button" data-bs-toggle="modal" data-bs-target="#exampleModal" data-id="<?= $card["id_card"]; ?>" data-qty="<?= $card["qty"]; ?>" data-set="<?= $card["card_set"]; ?>" data-name="<?= $card["card_name"]; ?>"><i class="fa-solid fa-xmark"></i> <?=$user->i18n("remove");?></button>
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
                <h2><?=$user->i18n("no_cards");?></h2>
                <img src="/cards/assets/img/jace_player.png" class="mt-3 opacity-75" width="35%"><br>
                <a class="btn btn-primary mt-4" href="/search"><i class="fa-solid fa-magnifying-glass me-2"></i> <?=$user->i18n("search_for_cards");?></a>
            </div>
        </div>
    </div>
<?php } ?>
    <div class="container text-center mb-3" id="pager">
        <?php for ($i=0; $i < $pages; $i++) { ?>
            <a href='/cards/<?=$i?>?name=<?=(isset($_GET["name"]) ? $_GET["name"] : ""); ?>&info=<?=(isset($_GET["info"]) ? $_GET["info"] : ""); ?>&colors=<?=(isset($_GET["colors"]) ? $_GET["colors"] : ""); ?>'><button class='m-1 btn <?= ($i == $id_page ? "btn-primary" : "btn-success") ?>'><?=$i + 1;?></button></a>
        <?php } ?>
    </div>
</body>

<!-- Modals -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title text-dark" id="card-name">Undefined </h5><span id="card-set" class="text-dark"><b>&nbsp; </b></span>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <h6 class="text-dark"><?=$user->i18n("remove_qty");?>:</h6>
            <form>
                <input type="number" name="card_qty" class="form-control" min="1" id="del_qty" value="1">
            </form>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-bs-dismiss="modal"><?=$user->i18n("cancel");?></button>
            <button type="button" class="btn btn-primary" id="deleteCard"><i class="fa-solid fa-xmark"></i> <?=$user->i18n("remove_of_collec");?></button>
        </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalAdd" tabindex="-1" aria-labelledby="modalAddLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-dark" id="card-name-add">Undefined </h5><span id="card-set-add" class="text-dark"><b>&nbsp; </b></span>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <h6 class="text-dark"><?=$user->i18n("select_qty");?>:</h6>
                <form>
                    <input type="number" name="card_qty" class="form-control" min="1" id="add_qty" value="1">
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal"><?=$user->i18n("cancel");?></button>
                <button type="button" class="btn btn-primary" id="addMoreCards"><i class="fa-solid fa-plus"></i> <?=$user->i18n("add_to_collec");?></button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="modalImport" tabindex="-1" aria-labelledby="modalImportLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-dark" id="card-name-add"><?=$user->i18n("import_cards_to");?></h5></span>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="post">
                <div class="modal-body">
                    <h6 class="text-dark"><?=$user->i18n("card_list");?></h6>
                    <textarea name="import_cards" class="form-control" placeholder="4 Black Lotus (Lea)&#10;4 Lightning Bolt&#10;..." rows=4" required></textarea>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal"><?=$user->i18n("cancel");?></button>
                    <button type="submit" class="btn btn-primary" name="command_import" value="1"><?=$user->i18n("import_cards");?></button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php require_once('_toast.php') ?>
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
                $('#added_collection').toast('show');
            <?php } ?>
            <?php if($_GET["success"] == "remove") { ?>
                $('#removed_collect').toast('show');
            <?php } ?>
            <?php if($_GET["success"] == "import") { ?>
                $('#imported').toast('show');
            <?php } ?>
        <?php } ?>

        $(document).on("click", "#deleteCard", function () {
            if (confirm("<?=$user->i18n("you_want_delete");?> "+$("#del_qty").val()+" "+cardName+"?")) {
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