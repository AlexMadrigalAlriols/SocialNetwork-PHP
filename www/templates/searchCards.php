<?php require_once("cards/procesos/cards/autoComplet.php");?>

<!DOCTYPE html>
<html lang="en">
<?php 
if(!isset($_SESSION["iduser"])){
    header("Location: /login");
}
require_once('header.php'); ?>

<body id="body-pd" class="body-pd" style="overflow-x: hidden;">

<?php require_once('navControlPanel.php') ?>

<div class="container">
<svg xmlns="http://www.w3.org/2000/svg" style="display: none;">
        <symbol id="check-circle-fill" fill="currentColor" viewBox="0 0 16 16">
            <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"/>
        </symbol>
    </svg>

    <div class="alert alert-success alert-dismissible d-none" id="addNotification"  style="margin-top: 5rem; margin-bottom: -5rem;">
        <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Success:"><use xlink:href="#check-circle-fill"/></svg> Success Added To Collection 
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    <div class="row search-form">

        <div class="col-lg-4"></div>
            <div class="col-lg-4">
            <form onsubmit="return searchSubmit();">

                <div class="input-group mb-3">
                    <input type="text" class="form-control" placeholder="Ex. Lightning Bolt" aria-label="Recipient's username" aria-describedby="basic-addon2" id="searcher-card" name="searcher-card" required>
                    <div class="input-group-append">
                        <button class="btn btn-success" type="submit">Search</button>
                    </div>
                </div>
                </form>
                <div id="form-body" style="position:absolute;">
                    
                </div>
            </div><!-- /.col-lg-4 -->
        <div class="col-lg-4"></div>
    </div><!-- /.row -->
    <div id="contenedor_carga" class="d-none">
        <div id="carga"></div>
    </div>
    <div class="searchedCards" style="margin-bottom: 2rem;" id="searchedCards"></div>
    <div class="container text-center d-none" id="cardsNoFound" style="width: 60%; margin-top: 2rem;">
            <div class="card">
                <div class="card-body">
                    <h1>No Results Found</h1>
                </div>
            </div>
        </div>
    </div>

</div>

<!-- Modals -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="card-name" style="color: black;">Undefined </h5><span id="card-set"><b>&nbsp; </b></span>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <h6>Select Qty:</h6>
        <form>
            <input type="number" name="card_qty" class="form-control" min="1" id="qty_cards" value="1">
            <h6>Additonal Info:</h6>
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

<script>
    var allCards = "";
    var autocompleto = "";
    var cardId = "";
    var cardEdition = "";
    var cardName = "";
    var cardSet = "";
    var collection = [];
    $( document ).ready(function() {
        $("#search").addClass('active');
    });


    $('#searcher-card').keyup(function() {
        var autocomplet = $("#searcher-card").val();
        $.ajax({
            url: '/autoComplet',
            type: 'POST',
            data: {autocomplet:autocomplet},
            success: function(data) {
                console.log(data);
                autocompleto = data;
            }
        });

        var autocompletNew = autocompleto.split(";");
        $(".elementos-cartas").remove();

        autocompletNew.forEach(element => {
            if(element != ""){
                var txt1 = "<a href='#' onclick='getCompletedNameCard(this)'><div class='form-control elementos-cartas'><h4>"+element+"</h4></div></a>";
                $("#form-body").append(txt1);
            }
            
        });
    });

    function getCompletedNameCard(valueClicked){
        $("#searcher-card").val(valueClicked.text);
        $(".elementos-cartas").remove();
    }

    function searchSubmit() {
        $("#contenedor_carga").toggleClass("d-none");
        $("#addNotification").addClass("d-none");
        $("#cardsNoFound").addClass("d-none");

        var searchercard = $("#searcher-card").val();
        $.ajax({
            url: '/searchCards',
            type: 'GET',
            async: false,
            data: {searchercard:searchercard},
            success: function(data) {
                allCards = JSON.parse(data);
            }
        });
        $(".elementos-cartas").remove();
        $("#searchedCards").empty();
        if(allCards.length <= 0){
            $("#cardsNoFound").removeClass("d-none");
        } else {
            allCards.forEach(card => {
                var query = "<div style='display:inline-block;' class='text-center'><img src="+card.Card.Img+" style='width:250px; margin: 15px;'></br><button class='btn btn-success openQtyModal' type='button'data-bs-toggle='modal' data-bs-target='#exampleModal' data-id="+card.Card.Id+" data-edition='"+card.Card.Set_name+"' data-set='"+card.Card.Set+"' data-name='"+card.Card.Name+"'>Add Collection</button></div>";
                $("#searchedCards").append(query);
            });
        }


        $("#contenedor_carga").toggleClass("d-none");
        return false;
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

            data: {cardId:cardId, cardName: cardName,cardQty: $("#qty_cards").val(), userId: <?php echo $_SESSION["iduser"]; ?>, cardDesc: $("#card_desc").val()},
            success: function(data) {
                $("#addNotification").removeClass("d-none");
                $('#exampleModal').modal('toggle');
            }
        });
    });

</script>
<script src="/cards/assets/js/headerControler.js"></script>

</body>
</html>
