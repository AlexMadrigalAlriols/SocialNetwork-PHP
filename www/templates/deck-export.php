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
                <h6 style="display: inline-block;"><span class="fa fa-calendar mr-3"></span>Deck List</h6>
              </div>

              <div class="card-body">
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

    $('#mode').click(function() {
      if(dark){
        dark = false;
        $('#modeCheck').prop("checked", true);

      } else {
        dark = true;
        $('#modeCheck').prop("checked", false);

      }

      $('#body-pd').toggleClass("dark-mode");
    });

    $("#decks").addClass('active');

    $.ajax({
        url: '/procesos/decks/getDecks',
        type: 'POST',
        async: false,
        data: {deckId: <?php echo $id_deck; ?>},
        success: function(data) {
            var data = JSON.parse(data);
            var firstLines = data[0].Deck.Cards;
            var keys = Object.keys(firstLines);
            var values = Object.values(firstLines);
            
            keys.forEach((element,index) => {
              lines.push(values[index] + " " + element);
            });

            var sideLines = (data[0].Deck.Sideboard == null ? "" : data[0].Deck.Sideboard);
            var keys = Object.keys(sideLines);
            var values = Object.values(sideLines);
            $("#sideCards").append("<p><b>SideBoard</b></p>");

            keys.forEach((element,index) => {
              sideboardLines.push(values[index] + " " + element);
            });
            
            deckFormat = data[0].Deck.Format;
            $("#deckName").append(data[0].Deck.Name);

        }
    });

    <?php if(isset($id_deck)) { ?>
    if(<?php echo isset($id_deck); ?>){
        $.ajax({
          url: '/procesos/decks/getDecks',
          type: 'POST',
          async: false,
          data: {deckId: <?php echo $id_deck; ?>},
          success: function(data) {
              deckInfo = JSON.parse(data);

              var firstLines = deckInfo[0].Deck.Cards;
              var keys = Object.keys(firstLines);
              var values = Object.values(firstLines);

              $("#textCards").val("Deck");

              keys.forEach((element,index) => {
                var text = (values[index] + " " + element);
                $("#textCards").val($("#textCards").val() + "\n" + text);
              });

              var firstLines = (deckInfo[0].Deck.Sideboard == null ? "" : deckInfo[0].Deck.Sideboard);
              var keys = Object.keys(firstLines);
              var values = Object.values(firstLines);

              $("#textCards").val($("#textCards").val() + "\n" + "Sideboard");

              keys.forEach((element,index) => {
                var text = (values[index] + " " + element);
                $("#textCards").val($("#textCards").val() + "\n" + text);
              });
            }
        });
    }
    <?php } ?>

});

  function showImg(x) {
    $(x).find('.showImgCard').toggleClass("d-none");
  }
</script>