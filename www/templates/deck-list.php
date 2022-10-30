<!DOCTYPE html>
<html lang="en">
<?php require_once("cards/www/controllers/decks.php"); ?>
<?php require_once('header.php'); ?>
<body id="body-pd" class="body-pd overflow-x-hidden">

    <?php require_once('navControlPanel.php') ?>
<div class="position-relative">

<div class="card mb-3 filterBox">
        <div class="card-header">
            <h6><i class="fa-solid fa-filter"></i> <?= $user->i18n("deck_filter"); ?></h6>
        </div>

        <div class="card-body">
            <div class="row px-4">
                <form>
                    <div class="input-group">
                        <div class="ms-1 col-lg-4 mt-2 me-3 addon-btn-filters">
                            <label for="name" class="form-label"><?=$user->i18n("deck_name");?></label>
                            <input type="text" class="form-control" id="name" placeholder="Ex. Death's Shadow" name="name" value="<?php if(isset($_GET["name"])){ echo $_GET["name"]; } ?>">
                        </div>
                        <div class="ms-1 col-lg-3 mt-2 me-3 addon-btn-filters">
                            <label for="format" class="form-label"><?=$user->i18n("colors");?></label>
                            <select class="form-select" id="color" name="color">
                                <option value=""></option>
                                <?php foreach (gc::getSetting("cards.colors") as $idx => $color) { ?>
                                    <option value="<?=$color;?>"><?=$user->i18n("color.".$color);?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="ms-1 col-lg-4 mt-2 addon-btn-filters">
                            <label for="format" class="form-label"><?=$user->i18n("format");?></label>
                            <select class="form-select" id="format" name="format">
                                <?php foreach ($formats as $idx => $value) { ?>
                                    <option value="<?=$value;?>"><?=$value;?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    

                    <div class="mb-3 mt-3">
                        <button type="submit" class="btn btn-success pull-right" id="searchFilter"><i class="fa-solid fa-magnifying-glass me-2"></i> <?=$user->i18n("search");?></button>
                        <a href="/decks/edit_deck/0"><button type="button" class="btn btn-primary addon-btn-filters"><i class="fa-solid fa-plus me-2"></i> <?=$user->i18n("new_deck");?></button></a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="searchedDecks">
        <?php foreach ($decks as $idx => $deck) { ?>
            <div class="card text-center deck-card d-inline-block card-tournaments">
                <h5 class="card-header"><b><?=$deck["name"]; ?></b></h5>
                <img src="<?=$deck["deck_img"]; ?>" class="card-img-top w-100 m-0 tournament-img">
                <div class="card-body pull-left">
                    <p class="card-text"><b><?=$user->i18n("format");?>:</b> <?=$deck["format"]; ?></p>
                    
                    <p class="card-text"><b><?=$user->i18n("colors");?>:</b>
                    <?php if($deck["colors"]) { ?>
                        <?php foreach (json_decode($deck["colors"], true) as $idx => $color) { ?>
                            <img src="https://c2.scryfall.com/file/scryfall-symbols/card-symbols/<?=$color;?>.svg" alt="" class="d-inline-block" width="20px">
                        <?php } ?>
                    <?php } ?>
                    </p>
                    <p class="card-text"><b><?=$user->i18n("actual_price");?>:</b> <?=$deck["totalPrice"]; ?> €</p>
                    <div class="text-center">
                        <a href="/deck/<?=$deck["id_deck"];?>"><button class="btn btn-primary me-1 addon-btn-filters"><i class="fa-regular fa-eye me-2"></i> <?=$user->i18n("view_deck");?></button></a>
                        <a href="/decks/edit_deck/<?=$deck["id_deck"];?>"><button class="btn btn-success me-1 addon-btn-filters"><i class="fa-regular fa-pen-to-square me-2"></i> <?=$user->i18n("edit_deck");?></button></a>
                        <button class="btn btn-danger btnDeleteDeck" data-id="<?=$deck["id_deck"];?>"><i class="bx bxs-trash"></i></button>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>
</div>
    <?php if(!count($decks)) { ?>
        <div class="container text-center mb-3">
            <div class="card">
                <div class="card-body">
                    <h2><?=$user->i18n("no_decks");?></h2>
                    <img src="/cards/assets/img/thraben_decks.png" class="mt-3 opacity-75" width="35%"><br>
                    <a class="btn btn-primary mt-4" href="/decks/edit_deck/0"><i class="fa-solid fa-plus me-2"></i> <?=$user->i18n("create_first_deck");?></a>
                </div>
            </div>
        </div>
    <?php } ?>

    <div class="container text-center mb-3 mt-3" id="pager">
        <?php for ($i=0; $i < $pages; $i++) { ?>
            <a href='/decks/<?=$i?>?name=<?=(isset($_GET["name"]) ? $_GET["name"] : ""); ?>&format=<?=(isset($_GET["format"]) ? $_GET["format"] : ""); ?>'><button class='btn <?= ($i == $id_page ? "btn-primary" : "btn-success") ?>'><?=$i + 1;?></button></a>
        <?php } ?>
    </div>
</div>
<?php require_once('_toast.php') ?>
</body>

</html>

<script src="/cards/assets/js/headerControler.js"></script>

<script>    

$( document ).ready(function() {
    <?php if(isset($_GET["format"])){ ?>
            $('#format option[value="<?php echo $_GET["format"]; ?>"]').prop("selected", true);
    <?php } ?>

    <?php if(isset($_GET["error"])){ ?>
        $('#error').toast('show');
    <?php } ?>

    <?php if(isset($_GET["success"]) && $_GET["success"] == "add") { ?>
        $('#add').toast('show');
    <?php } ?>
    
    <?php if(isset($_GET["success"]) && $_GET["success"] == "remove") { ?>
        $('#remove').toast('show');
    <?php } ?>

    $('.btnDeleteDeck').click(function() {
      $.ajax({
        url: '/procesos/decks/deleteDeck',
        type: 'POST',
        data: {deckId: $(this).data("id")},
        success: function(data) {
          window.location="/decks/0?success=remove";
        }
      });
    });

    $("#decks").addClass('active');
});
</script>