<!DOCTYPE html>
<html lang="en">

<?php require_once('header.php'); 
  if(!isset($deck)) {
    header("Location: /decks");
  }
?>
<body id="body-pd" class="body-pd" style="overflow-x: hidden;">

    <?php require_once('navControlPanel.php') ?>
    <div id="contenedor_carga" class="d-none">
        <div id="carga"></div>
    </div>
    <div class="card mb-3 filterBox" id="secondStep">
          <div class="card-header">
            <div>
              <h3 style="display: inline-block;" id="deckName"></h3>
                <a style="color: #4723D9; margin-left: 2%;" href="#"><i class='bx bxs-error-alt'></i> Report Deck Name</a>
              <h3 style="display: inline-block; float: right; color: #4723D9;">Tabletop: <span style="font-size: 25px;" id="priceDeck"></span> €</h3>
            </div>
            
            <div>
              <div style="display: inline-block;">
                <p><b>Owner: </b> <span id="userNameDeck"></span></p>
                <p><b>Format: </b> <span id="formatDeck"></span></p>
                <p><b>Deck Date: </b> <span id="dateDeck"></span></p>
                <a href="/tournaments?deck_id=<?=$deck;?>"><i class='bx bx-trophy' ></i> View Tournaments</a>

              </div>
              <div style="display: inline-block; float:right;">
                <h4 style="display: inline-block; float: right;">MTGO: <span style="font-size: 20px;" id="priceTixDeck"></span> tix</h4>
              </div>
            </div>
            
          </div>

          <div class="card-body">
            <div class="col-md-10" style="float:left; display: inline-block;">
            <div class="card" style="width: 97%;">
              <div class="card-header">
                <h6 style="display: inline-block;"><span class="fa fa-calendar mr-3"></span>Deck List</h6>
                <span style="display: inline-block; float:right;" id="rarityCount"></span>
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
                <div id="mainCards">

                </div>
                <div id="sideCards"> 
                
                </div>
              </div>
            </div>

            </div>
            <div class="col-md-2 container" style="display: inline-block; aling-items: right;">
            <div class="row">
              <a class="btn btn-primary mb-3" href="/check-cards/<?php echo $deck; ?>"><i class='bx bx-purchase-tag' ></i> My Price</a>
              <button class="btn btn-primary mb-3"><i class='bx bx-share-alt' ></i> Share Deck</button>
              <button class="btn btn-primary mb-3"><i class='bx bx-image' ></i> Visual View</button>
              <a class="btn btn-primary mb-3" href="/decks/new-deck/<?php echo $deck; ?>"><i class='bx bx-save' ></i> Edit and Save</a>
              <button class="btn btn-primary mb-3"><i class='bx bxs-file-pdf' ></i> Registration PDF</button>
              <a href="/deck-export/<?php echo $deck; ?>" class="btn btn-primary mb-3"><i class='bx bx-export' ></i> Export Deck</a>
            </div>
            </div>
          </div>
    </div>
</body>

</html>

<script src="/cards/assets/js/headerControler.js"></script>

<script>
    var realTotal = 0;
    var dark = true;
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
    
    var mythic = 0;
    var rare = 0;
    var uncommon = 0;
    var common = 0;

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

    $("#mainCards").append('<div id="mainDeckTitle"></div>');
    $("#mainCards").append('<div id="creatureTitle"></div><div id="creatureCards"></div></div>');
    $("#mainCards").append('<div id="planeswalkerTitle"></div><div id="planeswalkerCards"></div></div>');
    $("#mainCards").append('<div id="instantTitle"></div><div id="instantCards"></div></div>');
    $("#mainCards").append('<div id="sorceryTitle"></div><div id="sorceryCards"></div></div>');
    $("#mainCards").append('<div id="enchantTitle"></div><div id="enchantCards"></div></div>');
    $("#mainCards").append('<div id="artifactTitle"></div><div id="artifactCards"></div></div>');
    $("#mainCards").append('<div id="landTitle"></div><div id="landCards"></div></div>');

    $.ajax({
        url: '/procesos/decks/getDecks',
        type: 'POST',
        async: false,
        data: {deckId: <?php echo $deck; ?>},
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
            $("#formatDeck").append(data[0].Deck.Format);
            $("#userNameDeck").append(data[0].Deck.UserName);
            $("#dateDeck").append(data[0].Deck.Date);
            $("#priceDeck").append(data[0].Deck.Price);
            $("#deckName").append(data[0].Deck.Name);
            $("#priceTixDeck").append(data[0].Deck.PriceTix)

        }
    });

    $("#mainDeckTitle").append("<b><u>Main Deck</u></b>");

      for (let i = 0; i < lines.length; i++) {
        if(lines[i] != "0 Deck" && lines[i] != "0 Sideboard"){
          if(matches = lines[i].match(/^[1-9] (.*)$/)) {
            if(qty = matches[0].match(/^[1-9]/)){
              var putCard = colocarTexto(matches[1], qty);

              if(putCard.match("Sorcery") ){
                sorcery = parseInt(sorcery) + parseInt(qty);

              } else if(putCard.match("Planeswalker")) {
                planeswalker = parseInt(planeswalker) + parseInt(qty);

              } else if(putCard == "Instant") {
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
        }
      } 
      pushCards = "Sideboard";
      for (let idx = 0; idx < sideboardLines.length; idx++) {
        if(matches = sideboardLines[idx].match(/^[1-9] (.*)$/)) {
            if(qty = matches[0].match(/^[1-9]/)){
              var putCard = colocarTexto(matches[1], qty);
            }
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
      $("#rarityCount").append(mythic+" Mythic, "+rare+" Rare, "+uncommon+" Uncommon " + common + " Common");
});

function colocarTexto(name, qty){
    var returnsType = "";

    $.ajax({
      url: '/procesos/decks/getFirstEdition',
      type: 'GET',
      async: false,
      data: {searchercard:name, format: "modern"},
      success: function(data) {
        allCards = JSON.parse(data);
        realTotal = parseInt(realTotal) + parseInt(qty);

          deckImg = allCards[0].Card.ImgArt;
          priceTotal = parseFloat(priceTotal) + parseFloat((allCards[0].Card.Price * qty));

          if(allCards[0].Card.Legal == "not_legal") {
            $("#whatCards").append(allCards[0].Card.Name + ", ");
            $("#cardsNotLegal").removeClass("d-none");
          }

          if(pushCards != "Sideboard") {
            returnsType = allCards[0].Card.Type;
            var rarity = allCards[0].Card.Rarity;

            if(rarity == "mythic"){
              mythic = parseInt(mythic) + parseInt(qty);
            } else if(rarity == "rare") {
              rare = parseInt(rare) + parseInt(qty);

            } else if(rarity == "uncommon") {
              uncommon = parseInt(uncommon) + parseInt(qty);

            } else if(rarity == "common") {
              common = parseInt(common) + parseInt(qty);
            }

            if(allCards[0].Card.Type.match("Sorcery")) {
              var pushcardsto = $("#sorceryCards");

            } else if(allCards[0].Card.Type == "Instant") {
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

          pushcardsto.append("<a onmouseenter='showImg(this)' onmouseleave='showImg(this)' data-id="+allCards[0].Card.Id+"><p class='cardList'>"+ qty +" - "+ allCards[0].Card.Name +"&nbsp;&nbsp;"+ allCards[0].Card.Cost +"</p><div class='showImgCard d-none "+allCards[0].Card.Id+"' style='position: absolute; margin-left: 8rem; margin-top: -10rem;'><img src="+allCards[0].Card.Img+"></div></a>");
          if(pushCards == "Sideboard") {
            returnsType = "Sideboard";
          }

      }
    });
    return returnsType;
  }

  function showImg(x) {
    $(x).find('.showImgCard').toggleClass("d-none");
  }
</script>