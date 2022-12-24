    var dark = true;
    var lines = [];
    var sideboardLines =[];

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
    var priceTotal = 0;
    var priceTixTotal = 0;

  $( document ).ready(function() {
    myFunction();

    $("#decks").addClass('active');

    $("#mainCards").append('<div id="mainDeckTitle"></div>');
    $("#mainCards").append('<div id="creatureTitle"></div><div id="creatureCards"></div></div>');
    $("#mainCards").append('<div id="planeswalkerTitle"></div><div id="planeswalkerCards"></div></div>');
    $("#mainCards").append('<div id="instantTitle"></div><div id="instantCards"></div></div>');
    $("#mainCards").append('<div id="sorceryTitle"></div><div id="sorceryCards"></div></div>');
    $("#mainCards").append('<div id="enchantTitle"></div><div id="enchantCards"></div></div>');
    $("#mainCards").append('<div id="artifactTitle"></div><div id="artifactCards"></div></div>');
    $("#sideCards").append('<div id="landTitle"></div><div id="landCards"></div></div>');

    var firstLines = data;
    var keys = Object.keys(firstLines);
    var values = Object.values(firstLines);
            
    keys.forEach((element,index) => {
      lines.push(values[index] + " " + element);
    });

    
    var keys = Object.keys(sideLines);
    var values = Object.values(sideLines);

    if(keys.length) {
      $("#sideCards").append("<p><b>SideBoard</b></p>");

      keys.forEach((element,index) => {
        sideboardLines.push(values[index] + " " + element);
      });
    }

    $("#mainDeckTitle").append("<b><u>Main Deck</u></b>");
      for (let i = 0; i < lines.length; i++) {
        if(lines[i] != "0 Deck" && lines[i] != "0 Sideboard"){
          if(matches = lines[i].match(/^[1-9] (.*)$/)) {
            if(qty = matches[0].match(/^[1-9]/)){
              var putCard = colocarTexto(matches[1], qty, formatDeck);

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
              colocarTexto(matches[1], 1, formatDeck);
            }
          }
        }
      } 
      pushCards = "Sideboard";
      for (let idx = 0; idx < sideboardLines.length; idx++) {
        if(matches = sideboardLines[idx].match(/^[1-9] (.*)$/)) {
            if(qty = matches[0].match(/^[1-9]/)){
              var putCard = colocarTexto(matches[1], qty, formatDeck);
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

      $("#rarityCount").append(mythic+" Mythic, "+rare+" Rare, "+uncommon+" Uncommon, " + common + " Common");
      $("#priceTotal").append(priceTotal.toFixed(2));
      $("#priceTixTotal").append(priceTixTotal.toFixed(2));
  });

  var myVar;

  function myFunction() {
    myVar = setTimeout(showPage, 0);
  }

  function showPage() {
    $("#loader").addClass("d-none");
    $("#deck-container").removeClass("d-none");
    $("#deck-container").addClass("d-flex");
    $("#containerLoader").addClass("d-none");
  }

  function colocarTexto(name, qty, format){
      var returnsType = "";

      $.ajax({
        url: '/procesos/decks/getFirstEdition',
        type: 'GET',
        async: false,
        data: {card_name:name, format: format},
        success: function(data) {
          allCards = JSON.parse(data);

            deckImg = allCards[0].Card.ImgArt;
            priceTotal = parseFloat(priceTotal) + parseFloat((allCards[0].Card.Price * qty));
            priceTixTotal = parseFloat(priceTixTotal) + parseFloat((allCards[0].Card.PriceTix * qty));

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

              var pushcardsto = $("#sideCards");
            }

            pushcardsto.append("<a onmouseenter='showImg(this)' href='/card/"+allCards[0].Card.Id+"' onmouseleave='showImg(this)' data-id="+allCards[0].Card.Id+" class='text-white'><p class='cardList'>"+ qty +" - "+ allCards[0].Card.Name +"&nbsp;&nbsp;"+ allCards[0].Card.Cost +"</p><div class='showImgCard d-none "+allCards[0].Card.Id+"'><img src="+allCards[0].Card.Img+" width='175'></div></a>");
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

    function sharePublication($id_deck, $url){
        var sampleTextarea = document.createElement("textarea");
        document.body.appendChild(sampleTextarea);
        sampleTextarea.value = $url+"/deck/"+$id_deck; //save main text in it
        sampleTextarea.select(); //select textarea contenrs
        document.execCommand("copy");
        document.body.removeChild(sampleTextarea);
        $('#copyLink').toast('show');
    }