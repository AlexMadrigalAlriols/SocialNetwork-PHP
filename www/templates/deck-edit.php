<!DOCTYPE html>
<html lang="en">
<?php 
if(!isset($_SESSION["iduser"])){
  header("Location: /login");
}
  require_once('header.php'); 
  require_once "cards/clases/Conexion.php";
  $c=new conectar();
  $conexion=$c->conexion();

  if(isset($id_deck)) {
    $sql="select user_id from decks WHERE id_deck =".$id_deck."";
    if ($resultado = mysqli_query($conexion, $sql)) {

      while ($fila = mysqli_fetch_row($resultado)) {
        $userDeck = $fila[0];
      }
    }
  }


?>
<body id="body-pd" class="body-pd" style="overflow-x: hidden;">

    <?php require_once('navControlPanel.php') ?>
    <div class="form-decks" style="position: relative;">
    
      <div class="card mb-3 filterBox card-active" id="firstStep">
          <div class="card-header">
              <h6><span class="fa fa-calendar mr-3"></span>New Deck</h6>
          </div>
        <div class="card-body">
                <div class="row px-4">
                    <form>
                        <div class="input-group">
                            <div class="ml-3 mb-4 col-lg-12">
                                <label for="cardNameLabel" class="form-label">Deck Name</label>
                                <input type="text" class="form-control" id="cardNameLabel" placeholder="Ex. Death's Shadow" name="cardName" aria-describedby="validationServer03Feedback">
                                <div id="validationServer03Feedback" class="invalid-feedback">
                                Please put a valid deck name.
                                </div>
                              </div>
                        </div>

                        <div class="input-group">
                            <div class="ml-3 mb-4 col-lg-12">
                                <label for="deckFormat" class="form-label">Format</label>
                                <select class="form-select" aria-label="Default select example" name="format" id="format">
                                  <option value="Standard">Standard</option>
                                  <option value="Modern">Modern</option>
                                  <option value="Pioneer">Pioneer</option>
                                  <option value="Historic">Historic</option>
                                  <option value="Alchemy">Alchemy</option>
                                  <option value="Pauper">Pauper</option>
                                </select>
                            </div>
                        </div>

                        <div class="input-group">
                            <div class="ml-3 mb-4 col-lg-12">
                                <label for="deckOptionsLabel" class="form-label">Options</label>
                                <div class="form-check">
                                  <input class="form-check-input" type="checkbox" value="" id="privateDeck" name="privateDeck">
                                  <label class="form-check-label" for="privateDeck">
                                    Private Deck
                                  </label>
                                </div>

                                <div class="form-check">
                                  <input class="form-check-input" type="checkbox" value="" id="privateDeck" name="privateDeck">
                                  <label class="form-check-label" for="privateDeck">
                                    Check cards not on collection
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
              <h6><span class="fa fa-calendar mr-3"></span>New Deck</h6>
          </div>

          <div class="card-body">
              <div class="row">
                  <form>
                      <div class="input-group">
                            <div class="mb-4 col-md-5 maindeck-edit">
                              <label for="cardMainDeck" class="form-label">Maindeck</label>
                              <textarea class="form-control" placeholder="4 Fatal Push" id="textCards" rows="6" cols="5" aria-describedby="validationAddDeck"></textarea>
                              <div id="validationAddDeck" class="invalid-feedback">
                                Can't create a deck without cards.
                              </div>
                              <div class="row">
                                <div class="col-md-4">
                                  <button class="btn btn-primary mt-5" id="btnPreview" type="button">Update Preview</button>
                                  
                                </div>
                                <div class="col-md-8 mt-5 mb-3" style="text-align:left;">
                                  <div class="col-md-2 mb-3" style="display: inline-block;">
                                      <input type="number" class="form-control" placeholder="Qty" id="addQty" value="1" max="4" min="1">
                                  </div>
                                  <div class="col-md-5 mb-3 mr-3" style="display: inline-block;">
                                    <input type="text" class="form-control" placeholder="Card Name" style="width: 100%;" id="addName">
                                  </div>
                                  <div id="form-body" style="position:absolute; z-index: 999;"></div>

                                  <div class="col-md-4" style="display: inline-block;">
                                    <button class="btn btn-outline-success" id="btnAddCards" type="button" style="margin-bottom: 5px;">Add Card</button>
                                  </div>
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

<script>
    var dark = true;
    var totalCards = 0;
    var realTotal = 0;
    var priceTotal = 0;
    var tixTotal = 0;

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

$( document ).ready(function() {
    $("#decks").addClass('active');

    $('#nextAddCards').click(function() {
      
      if($("#cardNameLabel").val() == "") {
        $("#cardNameLabel").addClass("is-invalid");
      } else {
        $.ajax({
          url: '/procesos/decks/getDecks',
          type: 'POST',
          data: {deckName: $("#cardNameLabel").val(), userId: <?php echo $_SESSION["iduser"]; ?>},
          success: function(data) {
              if(data){
                <?php if(!isset($id_deck)){ ?>
                $("#cardNameLabel").addClass("is-invalid");
                $("#validationServer03Feedback").empty();
                $("#validationServer03Feedback").append("There is a deck with this name yet.")
                <?php } else if(isset($id_deck) && $userDeck == $_SESSION["iduser"]) { ?>
                  $("#cardNameLabel").removeClass("is-invalid");
                  $("#cardNameLabel").toggleClass("is-valid");
                  $('#secondStep').toggleClass("card2");
                  $('#secondStep').toggleClass("card-active");
                  $('#firstStep').toggleClass("card1");
                <?php } ?>
              } else {
                $("#cardNameLabel").removeClass("is-invalid");
                $("#cardNameLabel").toggleClass("is-valid");
                $('#secondStep').toggleClass("card2");
                $('#secondStep').toggleClass("card-active");
                $('#firstStep').toggleClass("card1");
              }
            }
        });
      }
    });

    $('#backAddCards').click(function() {
      $('#firstStep').toggleClass("card1");
      $('#firstStep').toggleClass("card-active");
      $('#secondStep').toggleClass("card2");
      
    });

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
          data: {searchercard: (matches[1] == null ? "Lightning Bolt" : matches[1])},
          success: function(data) {
              allCards = JSON.parse(data);
              $.ajax({
                url: '/procesos/decks/addDeck', 
                type: 'POST',
                async: false,
                data: {userId: <?php echo $_SESSION["iduser"]; ?>, nameDeck: $("#cardNameLabel").val(), format: $("#format").val(), deck_img: allCards[0].Card.ImgArt, cards: $("#textCards").val(), private: (document.querySelector('#privateDeck').checked ? 1 : 0), totalPrice: parseFloat(priceTotal), tixTotal: parseFloat(tixTotal), deckId: '<?php if(isset($id_deck) && $_SESSION["iduser"] == $userDeck){echo $id_deck;} else {echo -1;}?>'},
                success: function(data) {

                    console.log(data);
                    window.location="/decks?success=add";
                }
              });
          }
        });
      }
    });

    $('#btnPreview').click(function() {
      totalCards = 0;
      realTotal = 0;
      sorcery = 0;
      creature = 0;
      instant = 0;
      enchant = 0;
      land = 0;
      artifact = 0;
      planeswalker = 0;
      deckImg = "";
      priceTotal = 0;
      tixTotal = 0;

      $("#cardsCount").empty();
      $("#sorceryCards").empty();
      $("#instantCards").empty();
      $("#creatureCards").empty();
      $("#mainCards").empty();
      $("#whatCards").empty();
      $("#cardsNotLegal").addClass("d-none");

      $("#mainCards").append('<div id="mainDeckTitle"></div>');
      $("#mainCards").append('<div id="creatureTitle"></div><div id="creatureCards"></div></div>');
      $("#mainCards").append('<div id="planeswalkerTitle"></div><div id="planeswalkerCards"></div></div>');
      $("#mainCards").append('<div id="instantTitle"></div><div id="instantCards"></div></div>');
      $("#mainCards").append('<div id="sorceryTitle"></div><div id="sorceryCards"></div></div>');
      $("#mainCards").append('<div id="enchantTitle"></div><div id="enchantCards"></div></div>');
      $("#mainCards").append('<div id="artifactTitle"></div><div id="artifactCards"></div></div>');
      $("#mainCards").append('<div id="landTitle"></div><div id="landCards"></div></div>');

      var lines = $('#textCards').val().split('\n');
      for (let i = 0; i < lines.length; i++) {
        if(lines[i] != "Deck" && lines[i] != "Sideboard"){
          if(matches = lines[i].match(/^[1-9] (.*)$/)) {
            if(qty = matches[0].match(/^[1-9]/)){
              var putCard = colocarTexto(matches[1], qty);

              if(putCard.match("Sorcery") ){
                sorcery = parseInt(sorcery) + parseInt(qty);

              } else if(putCard.match("Planeswalker")) {
                planeswalker = parseInt(planeswalker) + parseInt(qty);

              } else if(putCard.match("Instant")) {
                instant = parseInt(instant) + parseInt(qty);

              } else if(putCard.match("Creature")) {
                creature = parseInt(creature) + parseInt(qty);

              } else if(putCard.match("Land")) {
                land = parseInt(land) + parseInt(qty);

              } else if(putCard.match("Artifact")) {
                artifact = parseInt(artifact) + parseInt(qty);

              } else if(putCard.match("Enchantment")) {
                enchant = parseInt(enchant) + parseInt(qty);
              }
            } else {
              colocarTexto(matches[1], 1);
            }
          }
        } else if(lines[i] == "Deck") {
          $("#mainDeckTitle").append("<b><u>Main Deck</u></b>");

        } else if(lines[i] == "Sideboard") {
          $("#sideCards").append("<p><b>SideBoard</b></p>");
          pushCards = "Sideboard";
        }

      } 
      if(sorcery > 0) {
        $("#sorceryTitle").append("<b class='sorceryName'>Sorcery ("+sorcery+")</b>");
      }
      if(creature > 0) {
        $("#creatureTitle").append("<b class='creatureName'>Creatures ("+creature+")</b>");
      }
      if(instant > 0) {
        $("#instantTitle").append("<b class='instantName'>Instants ("+instant+")</b>");
      }
      if(land > 0) {
        $("#landTitle").append("<b class='landName'>Lands ("+land+")</b>");
      }
      if(enchant > 0) {
        $("#enchantTitle").append("<b class='enchantCards'>Enchantments ("+enchant+")</b>");
      }
      if(artifact > 0) {
        $("#artifactTitle").append("<b class='artifactCards'>Artifacts ("+artifact+")</b>");
      }
      if(planeswalker > 0) {
        $("#planeswalkerTitle").append("<b class='planeswalkerCards'>Planeswalkers ("+planeswalker+")</b>");
      }

      $("#cardsCount").append("Total Cards: " + realTotal);

    });

    $('#addName').keyup(function() {
        var autocomplet = $("#addName").val();
        var autocompleto = "";
        $.ajax({
            url: '/autoComplet',
            type: 'POST',
            data: {autocomplet:autocomplet},
            success: function(data) {
                console.log(data);
                autocompleto = data;
                var autocompletNew = autocompleto.split(";");
                $(".elementos-cartas").remove();

                autocompletNew.forEach(element => {
                    if(element != ""){
                        var query = "<a href='#' onclick='getCompletedNameCard(this)'><div class='form-control elementos-cartas'><h6>"+element+"</h6></div></a>";
                        $("#form-body").append(query);
                    }
                    
                });
            }
        });


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
              if(deckInfo[0].Deck.User_id != "<?php echo $_SESSION["iduser"]; ?>" && deckInfo[0].Deck.Private == 1) {
                window.location="/decks";

              } else {

                if(deckInfo[0].Deck.Private == 1) {
                  $('#privateDeck').prop("checked", true);
                }
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

                $("#cardNameLabel").val(deckInfo[0].Deck.Name);
                $('#format option[value="'+deckInfo[0].Deck.Format+'"]').prop("selected", true);
              }
          }
        });
    }
    <?php } ?>

    $('#btnAddCards').click(function() { 
      if($("#textCards").val() == ""){
        $("#textCards").val("Deck");
      }

      if($("#addName").val() != ""){
        $("#addName").removeClass("is-invalid");
        text = ($("#addQty").val() + " " + $("#addName").val());
        $("#textCards").val($("#textCards").val() + "\n" + text);
      } else {
        $("#addName").addClass("is-invalid");
      }


    });

  function colocarTexto(name, qty){
    var returnsType = "";
    $.ajax({
      url: '/procesos/decks/getFirstEdition',
      type: 'GET',
      async: false,
      data: {searchercard:name, format: $("#format").val()},
      success: function(data) { 
        allCards = JSON.parse(data);
        realTotal = parseInt(realTotal) + parseInt(qty);

          deckImg = allCards[0].Card.ImgArt;

          priceTotal = parseFloat(priceTotal) + parseFloat((allCards[0].Card.Price == null ? 0 : allCards[0].Card.Price) * qty);
          tixTotal = parseFloat(tixTotal) + parseFloat((allCards[0].Card.PriceTix == null ? 0 : allCards[0].Card.PriceTix) * qty);

          if(allCards[0].Card.Legal == "not_legal") {
            $("#whatCards").append(allCards[0].Card.Name + ", ");
            $("#cardsNotLegal").removeClass("d-none");
          }

          if(pushCards != "Sideboard") {
            returnsType = allCards[0].Card.Type;
            if(allCards[0].Card.Type.match("Sorcery")) {
              var pushcardsto = $("#sorceryCards");

            } else if(allCards[0].Card.Type.match("Instant")) {
              var pushcardsto = $("#instantCards");

            } else if(allCards[0].Card.Type.match("Creature")) {
              var pushcardsto = $("#creatureCards");

            } else if(allCards[0].Card.Type.match("Land")) {
              var pushcardsto = $("#landCards");

            } else if(allCards[0].Card.Type.match("Enchantment")) {
              var pushcardsto = $("#enchantCards");

            } else if(allCards[0].Card.Type.match("Planeswalker")) {
              var pushcardsto = $("#planeswalkerCards");

            } else if(allCards[0].Card.Type.match("Artifact")) {
              var pushcardsto = $("#artifactCards");

            }
          } else {
            var pushcardsto = $("#sideCards");
          }

          alert(allCards[0].Card.Type);
          pushcardsto.append("<a onmouseenter='showImg(this)' onmouseleave='showImg(this)' data-id="+allCards[0].Card.Id+"><p class='cardList'>"+ qty +" - "+ allCards[0].Card.Name +"&nbsp;&nbsp;"+ allCards[0].Card.Cost +"</p><div class='showImgCard d-none "+allCards[0].Card.Id+"' style='position: absolute; margin-top: -10rem;'><img src="+allCards[0].Card.Img+"></div></a>");
          if(pushCards == "Sideboard") {
            returnsType = "Sideboard";
          }

      }
    });

    return returnsType;
  }
});

  function showImg(x) {
    $(x).find('.showImgCard').toggleClass("d-none");
  }
  function getCompletedNameCard(valueClicked){
        $("#addName").val(valueClicked.text);
        $(".elementos-cartas").remove();
    }
</script>