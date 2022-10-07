<!DOCTYPE html>
<html lang="en">
<?php require_once("cards/www/controllers/decks.php"); ?>
<?php require_once('header.php'); ?>
<body id="body-pd" class="body-pd overflow-x-hidden">

    <?php require_once('navControlPanel.php') ?>
<div class="position-relative">

<div class="card mb-3 filterBox">
        <div class="card-header">
            <h6><i class="fa-solid fa-filter"></i> Decks Filter</h6>
        </div>

        <div class="card-body">
            <div class="row px-4">
                <form>
                    <div class="input-group">
                        <div class="col-lg-4 mt-2 me-3">
                            <label for="name" class="form-label">Deck Name</label>
                            <input type="text" class="form-control" id="name" placeholder="Ex. Death's Shadow" name="name" value="<?php if(isset($_GET["name"])){ echo $_GET["name"]; } ?>">
                        </div>
                        <div class="ms-1 col-lg-3 mt-2">
                            <label for="format" class="form-label">Colors</label>
                            <select class="form-select" id="color" name="color">
                                <option value=""></option>
                                <option value="B">Black</option>
                                <option value="R">Red</option>
                                <option value="W">White</option>
                                <option value="G">Green</option>
                                <option value="U">Blue</option>
                            </select>
                        </div>
                        <div class="ms-3 col-lg-4 mt-2">
                            <label for="format" class="form-label">Format</label>
                            <select class="form-select" id="format" name="format">
                                <?php foreach ($formats as $idx => $value) { ?>
                                    <option value="<?=$value;?>"><?=$value;?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    

                    <div class="mb-3 mt-3">
                        <button type="submit" class="btn btn-success pull-right m-2"id="searchFilter">Search</button>
                        <a href="/decks/edit_deck/0"><button type="button" class="btn btn-secondary pull-right m-2" id="searchFilter">New Deck</button></a>
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
                    <p class="card-text"><b>Format:</b> <?=$deck["format"]; ?></p>
                    
                    <p class="card-text"><b>Colors:</b>
                    <?php if($deck["colors"]) { ?>
                        <?php foreach (json_decode($deck["colors"], true) as $idx => $color) { ?>
                            <img src="https://c2.scryfall.com/file/scryfall-symbols/card-symbols/<?=$color;?>.svg" alt="" class="d-inline-block" width="20px">
                        <?php } ?>
                    <?php } ?>
                    </p>
                    <p class="card-text"><b>Actual Price:</b> <?=$deck["totalPrice"]; ?> €</p>
                    <div class="text-center">
                        <a href="/deck/<?=$deck["id_deck"];?>"><button class="btn btn-primary me-1">View Deck</button></a>
                        <a href="/decks/edit_deck/<?=$deck["id_deck"];?>"><button class="btn btn-success me-1">Edit Deck</button></a>
                        <button class="btn btn-danger btnDeleteDeck" data-id="<?=$deck["id_deck"];?>"><i class="bx bxs-trash"></i></button>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>
</div>
    <?php if(!count($decks)) { ?>
        <div class="container text-center d-none" id="deckNoFound">
            <div class="card">
                <div class="card-body">
                    <h1>No Decks Found</h1>
                </div>
            </div>
        </div>
    <?php } ?>

    <div class="container text-center mb-3" id="pager">
        <?php for ($i=0; $i < $pages; $i++) { ?>
            <a href='/decks/<?=$i?>?name=<?=(isset($_GET["name"]) ? $_GET["name"] : ""); ?>&format=<?=(isset($_GET["format"]) ? $_GET["format"] : ""); ?>'><button class='btn <?= ($i == $id_page ? "btn-primary" : "btn-success") ?>'><?=$i + 1;?></button></a>
        <?php } ?>
    </div>
</div>
<div id="error" class="toast bg-danger position-fixed bottom-0 m-3" role="alert" aria-live="assertive" aria-atomic="true">
    <div class="d-flex">
        <div class="toast-body">
            Error on add/edit/delete deck.
        </div>
        <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
    </div>
</div>
<div id="add" class="toast bg-success position-fixed bottom-0 m-3" role="alert" aria-live="assertive" aria-atomic="true">
    <div class="d-flex">
        <div class="toast-body">
            Success on add deck on collection.
        </div>
        <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
    </div>
</div>

<div id="remove" class="toast bg-success position-fixed bottom-0 m-3" role="alert" aria-live="assertive" aria-atomic="true">
    <div class="d-flex">
        <div class="toast-body">
            Success on remove deck of collection.
        </div>
        <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
    </div>
</div>
</body>

</html>

<script src="cards/assets/js/headerControler.js"></script>

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