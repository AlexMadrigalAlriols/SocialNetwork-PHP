<!DOCTYPE html>
<html lang="en">

<?php require_once('header.php'); ?>
<body id="body-pd" class="body-pd" style="overflow-x: hidden;">

    <?php require_once('navControlPanel.php') ?>
    <div id="contenedor_carga" class="d-none">
        <div id="carga"></div>
    </div>
    <div class="card mb-3 filterBox" id="secondStep">
          <div class="card-header">
            <div>
              <h4 style="display: inline-block;" id="deckName"></h4>
              <p><b>Owner: </b> Alex Madrigal</p>
            </div>
          </div>

          <div class="card-body">
            <div class="col-md-10" style="float:left; display: inline-block;">
            <div class="card" style="width: 97%;">
              <div class="card-header">
                <h6 style="display: inline-block;"><span class="fa fa-calendar mr-3"></span>Cards not found on collection:</h6>
              </div>

              <div class="card-body">
                <p><b>Missing Cards: </b> <span id="totalCards"></span></p>
                <p><b>Total Price: </b> <span id="deckPrice"></span> €</p>
                <p><b>Total Price (MTGO): </b> <span id="tixPrice"></span> tix</p>
                <textarea name="textCards" id="textCards" cols="50" rows="20" class="form-control"></textarea>
              </div>
            </div>

            </div>
            <div class="col-md-2 container" style="display: inline-block; aling-items: right;">
            <div class="row">
              <a class="btn btn-primary mb-3" href="/deck/<?php echo $id_deck; ?>"><i class='bx bx-left-arrow-alt'></i> Deck Page</a>
            </div>
            </div>
          </div>
    </div>
</body>

</html>

<script src="/cards/assets/js/headerControler.js"></script>

<script>
    var realTotal = 0;
    var lines = [];
    var sideboardLines =[];
    var totalCards = 0;
    var priceTotal = 0;
    var tixPrice = 0;

    // Card Types
    var creature = 0;
    var instant = 0;
    var enchant = 0;
    var sorcery = 0;
    var land = 0;
    var artifact = 0;
    var planeswalker = 0;
    
    var pushCards = "MainBoard";
    var deckImg = "";
    var deckFormat = "";
    window.onload = function(){
        var contenedor = document.getElementById('contenedor_carga');
        setTimeout(() => {contenedor.style.visibility = 'hidden';
        contenedor.style.opacity = '0';
        document.body.style.overflowY= "visible"; contenedor.style.position = "absolute"}, 0);
    }

$( document ).ready(function() {


    $("#decks").addClass('active');

    <?php if(isset($id_deck)) { ?>
    if(<?php echo isset($id_deck); ?>){
        $.ajax({
          url: '/procesos/decks/checkPrice',
          type: 'POST',
          async: false,
          data: {deckId: <?php echo $id_deck; ?>, userId: <?php echo $_SESSION["iduser"]; ?>},
          success: function(data) {
              deckInfo = JSON.parse(data);

              var firstLines = deckInfo[0].Deck.Cards;
              var keys = Object.keys(firstLines);
              var values = Object.values(firstLines);

              $("#textCards").val("Deck");

              keys.forEach((element,index) => {
                var text = (values[index] + " " + element);
                $("#textCards").val($("#textCards").val() + "\n" + text);
                totalCards = parseInt(totalCards) + parseInt(values[index]);
                
                $.ajax({
                  url: '/getCards',
                  type: 'POST',
                  async: false,
                  data: {cardName: element},
                  success: function(data) {
                      cards = JSON.parse(data);
                      priceTotal = parseFloat(priceTotal) + parseFloat((cards[0].Card.Price == null ? "" : cards[0].Card.Price) * values[index]);
                      tixPrice = parseFloat(tixPrice) + parseFloat((cards[0].Card.PriceTix == null ? "" : cards[0].Card.PriceTix) * values[index]);
                  }
                });
              });

              var firstLines = (deckInfo[0].Deck.Sideboard == null ? "" : deckInfo[0].Deck.Sideboard);
              var keys = Object.keys(firstLines);
              var values = Object.values(firstLines);

              $("#textCards").val($("#textCards").val() + "\n" + "Sideboard");

              keys.forEach((element,index) => {
                var text = (values[index] + " " + element);
                $("#textCards").val($("#textCards").val() + "\n" + text);
                totalCards = parseInt(totalCards) + parseInt(values[index]);
              });

              $("#totalCards").append(totalCards);
              $("#deckName").append(deckInfo[0].Deck.Name);
              $("#deckPrice").append(priceTotal);
              $("#tixPrice").append(tixPrice);
            }
        });


    }
    <?php } ?>

});

  function showImg(x) {
    $(x).find('.showImgCard').toggleClass("d-none");
  }
</script>