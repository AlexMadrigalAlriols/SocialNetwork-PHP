var dark = true;
var totalCards = 0;
var realTotal = 0;

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
        $('#secondStep').toggleClass("card2");
        $('#secondStep').toggleClass("card-active");
        $('#firstStep').toggleClass("card1");
    });

    $('#backAddCards').click(function() {
      $('#firstStep').toggleClass("card1");
      $('#firstStep').toggleClass("card-active");
      $('#secondStep').toggleClass("card2");
      
    });

    $('#addName').keyup(function() {
        var autocomplet = $("#addName").val();
        var autocompleto = "";
        $.ajax({
              url: '/autoComplet',
              type: 'POST',
              data: {autocomplet: autocomplet},
              success: function(data) {
                cardResults = data.split(";");

                $(".elementos-cartas").remove();

                cardResults.forEach(card => {
                    if(card != ""){
                        var html = "<option class='elementos-cartas' value='"+card+"'></option>";
                        $("#form-body").append(html);
                    }
                    
                });
            }
        });
    });
    
    $('#btnAddCards').click(function() { 
      if ($("#textCards").val() == "") {
        $("#textCards").val("Deck");
      }

      if ($("#addName").val() != "") {
        $("#addName").removeClass("is-invalid");
        text = ($("#addQty").val() + " " + $("#addName").val());
        $("#textCards").val($("#textCards").val() + "\n" + text);
      } else {
        $("#addName").addClass("is-invalid");
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

    function colocarTexto(name, qty){
      var returnsType = "";
      $.ajax({
        url: '/procesos/decks/getFirstEdition',
        type: 'GET',
        async: false,
        data: {card_name: name, format: $("#format").val()},
        success: function(data) { 
            allCards = JSON.parse(data);
            realTotal = parseInt(realTotal) + parseInt(qty);

            deckImg = allCards[0].Card.ImgArt;

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