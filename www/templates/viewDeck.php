<!DOCTYPE html>
<html lang="en">

<?php require_once('header.php'); ?>

<body id="body-pd" class="body-pd" style="overflow-x: hidden;">
  <?php require_once("cards/www/controllers/deck-view.php"); ?>
    <?php require_once('navControlPanel.php') ?>
    
    <div class="card filterBox" id="containerLoader" style="position: absolute; top: 0; bottom: 0; left: 0; right: 0; height: 110vh; margin-top: -2rem;">
      <div id="loader"></div>
    </div>

    <div class="card mb-3 filterBox" id="myDiv" style="display:none;">
          <div class="card-header">
            <div>
              <h3 class="d-inline-block"><?=$deck["name"];?></h3>
              <form method="POST" class="d-inline-block">
                <button style="color: #7353f5; margin-left: 2%; width:100%; background-color: transparent; border-width: 0;" name="commandReport" value="<?=$deck["id_deck"];?>" type="submit"><i class='bx bxs-error-alt'></i> Report Deck Name</button>
              </form>
                
              <h3 style="display: inline-block; float: right; color: #7353f5;">Tabletop: <span style="font-size: 25px;" id="priceTotal"></span> €</h3>
            </div>
            
            <div>
              <div style="display: inline-block;">
                <p><b>Owner: </b><a href="/profile/<?=$deck["user_id"]; ?>" class="text-white decoration-none"> <?=$deck["owner_name"]; ?></a></p>
                <p><b>Format: </b> <?=$deck["format"];?></p>
                <p><b>Deck Date: </b> <?= date("d-m-Y", strtotime($deck["updatedDate"]));?></p>
                <a href="/tournaments?deck_id=<?=$id_deck;?>" style="color: #7353f5;"><i class='bx bx-trophy' ></i> View Tournaments</a>

              </div>
              <div style="display: inline-block; float:right;">
                <h4 style="display: inline-block; float: right;">MTGO: <span style="font-size: 20px;" id="priceTixTotal"></span> tix</h4>
              </div>
            </div>
            
          </div>

          <div class="card-body">
            <div class="col-md-10" style="float:left; display: inline-block;">
            <div class="card" style="width: 97%;">
              <div class="card-header">
                <h6 style="display: inline-block;">Deck List</h6>
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
                <div class="row">
                  <div class="col-md-6" id="mainCards">

                  </div>
                  <div class="col-md-5" id="sideCards"> 

                  </div>
                </div>
              </div>
            </div>

            </div>
            <div class="col-md-2 container" style="display: inline-block; aling-items: right;">
            <div class="row">
              <a class="btn btn-primary mb-3" href="/check-cards/<?php echo $id_deck; ?>"><i class='bx bx-purchase-tag' ></i> My Price</a>
              <button class="btn btn-primary mb-3" onclick="sharePublication(<?=$id_deck;?>, '<?= gc::getSetting('site.url'); ?>')"><i class='bx bx-share-alt' ></i> Share Deck</button>
              <a href="/deck/get-proxies/<?=$id_deck;?>" class="btn btn-primary mb-3"><i class='bx bx-image' ></i> Print Proxies</a>
              <a class="btn btn-primary mb-3" href="/decks/new-deck/<?php echo $id_deck; ?>"><i class='bx bx-save' ></i> Edit and Save</a>
              <button class="btn btn-primary mb-3" onclick="generateDecklistPDF();"><i class='bx bxs-file-pdf' ></i> Registration PDF</button>
              <a href="/deck-export/<?php echo $id_deck; ?>" class="btn btn-primary mb-3"><i class='bx bx-export' ></i> Export Deck</a>
            </div>
            </div>
          </div>
          <div id="copyLink" class="toast bg-primary position-fixed bottom-0 end-0 m-3" role="alert" aria-live="assertive" aria-atomic="true" style="z-index: 1000;">
        <div class="d-flex">
            <div class="toast-body">
                Copied to clipboard
            </div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
    </div>

</body>

</html>

<script src="/cards/assets/js/headerControler.js"></script>
<!-- jsPDF -->
<script type="text/javascript" src="/cards/assets/vendor/jsPDF/jspdf-1.3.4.min.js"></script>

<script>
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

    var data = JSON.parse(<?= json_encode($deck["cards"]); ?>);

    var firstLines = data;
    var keys = Object.keys(firstLines);
    var values = Object.values(firstLines);
            
    keys.forEach((element,index) => {
      lines.push(values[index] + " " + element);
    });

    var sideLines = JSON.parse(<?= json_encode($deck["sideboard"]); ?>);
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

      $("#rarityCount").append(mythic+" Mythic, "+rare+" Rare, "+uncommon+" Uncommon, " + common + " Common");
      $("#priceTotal").append(priceTotal.toFixed(2));
      $("#priceTixTotal").append(priceTixTotal.toFixed(2));
  });

  var myVar;

  function myFunction() {
    myVar = setTimeout(showPage, 0);
  }

  function showPage() {
    document.getElementById("loader").style.display = "none";
    document.getElementById("myDiv").style.display = "flex";
    $("#containerLoader").addClass("d-none");
  }

  function colocarTexto(name, qty){
      var returnsType = "";

      $.ajax({
        url: '/procesos/decks/getFirstEdition',
        type: 'GET',
        async: false,
        data: {card_name:name, format: "<?= $deck["format"]; ?>"},
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

    function sharePublication($id_deck, $url){
        var sampleTextarea = document.createElement("textarea");
        document.body.appendChild(sampleTextarea);
        sampleTextarea.value = $url+"/deck/"+$id_deck; //save main text in it
        sampleTextarea.select(); //select textarea contenrs
        document.execCommand("copy");
        document.body.removeChild(sampleTextarea);
        $('#copyLink').toast('show');
    }
</script>
<script>

  // Generates a WotC-style decklist
  // see: https://wpn.wizards.com/sites/wpn/files/attachements/mtg_constructed_deck_registration_sheet_pdf11.pdf
  function generateStandardDecklist() {
    // Create a new dl
    let dl = new jsPDF('portrait', 'pt', 'letter');

    // Create all the rectangles
    // Start with the top box, for deck designer, name, etc.
    dl.setLineWidth(1);
    dl.rect(135, 54, 441, 24);  // date + event
    dl.rect(135, 78, 441, 24);  // location + deck name
    dl.rect(355, 54, 221, 72);  // event + deck name + deck designer
    dl.rect(552, 30, 24, 24);   // first letter
    dl.rect(445, 30, 55, 24);   // table number

    dl.rect(27, 140, 24, 628);  // last name + first name + dci
    dl.rect(27, 140, 24, 270);  // dci
    dl.rect(27, 140, 24, 449);  // first name + dci

    dl.rect(250, 748, 56, 22); // total number main deck
    dl.rect(524, 694, 56, 22); // total number side deck
    dl.rect(320, 722, 260, 48); // judge box

    dl.setLineWidth(.5);
    dl.rect(135, 54, 54, 48);   // date + location
    dl.rect(355, 54, 54, 72);   // event + deck name + deck designer
    dl.rect(320, 722, 130, 48); // official use + dc round + status + judge
    dl.rect(320, 722, 260, 12); // official use + main/sb
    dl.rect(320, 734, 260, 12); // dc round + dc round
    dl.rect(320, 746, 260, 12); // status + status

    let y = 140;
    while (y < 380) {
      dl.rect(27, y, 24, 24);  // dci digits
      y += 24;
    }

    // Now let's create a bunch of lines for putting cards on
    y = 186;
    while(y < 750)                  // first column of lines
    {
      dl.line(62, y, 106, y);
      dl.line(116, y, 306, y);
      y += 18;
    }

    y = 186;
    while(y < 386)                  // second column of lines (main deck)
    {
      dl.line(336, y, 380, y);
      dl.line(390, y, 580, y);
      y += 18;
    }

    y = 438;
    while(y < 696)                  // second column of lines (main deck)
    {
      dl.line(336, y, 380, y);
      dl.line(390, y, 580, y);
      y += 18;
    }

    // Get all the various notes down on the page
    // Interleave user input for better copy+paste behavior
    // There are a ton of them, so this will be exciting
    dl.setFontSize(15);
    dl.setFontStyle('bold');
    dl.setFont('times'); // it's no Helvetica, that's for sure
    dl.text('DECK REGISTRATION SHEET', 135, 45);

    dl.setFontSize(7);
    dl.setFontStyle('normal');
    dl.text('Table', 421, 40);
    dl.text('Number', 417, 48);
    dl.text('First Letter of', 508, 40);
    dl.text('Last Name', 516, 48);

    // put the event name, deck designer, and deck name into the PDF
    dl.setFont('times');
    dl.setFontSize(7);
    dl.setFontStyle('normal');
    dl.text('Date:', 169, 68);
    dl.setFont('helvetica');
    dl.setFontSize(11);

    dl.setFont('times');
    dl.setFontSize(7);
    dl.text('Event:', 387, 68);
    dl.setFont('helvetica');
    dl.setFontSize(11);

    dl.setFont('times');
    dl.setFontSize(7);
    dl.text('Location:', 158, 92);
    dl.setFont('helvetica');
    dl.setFontSize(11);

    dl.setFont('times');
    dl.setFontSize(7);
    dl.text('Deck Name:', 370, 92);
    dl.setFont('helvetica');
    dl.setFontSize(11);
    dl.text("<?=$deck['name']; ?>", 412, 93.5);

    dl.setFont('times');
    dl.setFontSize(7);
    dl.text('Deck Designer:', 362, 116);
    dl.setFont('helvetica');
    dl.setFontSize(11);
    dl.text("<?=$deck['owner_name']; ?>", 412, 117.5);

    dl.setFont('times');
    dl.setFontSize(13);
    dl.setFontStyle('bold');
    dl.text('PRINT CLEARLY USING ENGLISH CARD NAMES', 36, 121);

    // put the last name into the PDF
    dl.setFont('times');
    dl.setFontSize(7);
    dl.setFontStyle('normal');
    dl.text('Last Name:', 41, 760, 90);
    dl.setFont('helvetica');
    dl.setFontSize(11);
    dl.setFontStyle('bold');

    // put the first name into the PDF
    dl.setFont('times');
    dl.setFontSize(7);
    dl.setFontStyle('normal');
    dl.text('First Name:', 41, 581, 90);  // rotate
    dl.setFont('helvetica');
    dl.setFontSize(11);
    dl.setFontStyle('bold');

    // put the DCI number into the PDF
    dl.setFont('times');
    dl.setFontSize(7);
    dl.setFontStyle('italic');
    dl.text('DCI #:', 41, 404, 90);    // dci # is rotated and italic

    dl.setFont('helvetica');
    dl.setFontSize(12);
    dl.setFontStyle('bold');
    
    // Add the deck to the decklist
    for (let column = 0, x = 82, y = 182; column < 2; column++) {
      dl.setFont('times');
      dl.setFontStyle('bold');
      if (column === 0) {
        dl.setFontSize(13);
        dl.text('Main Deck:', 62, 149);
        dl.setFontSize(11);
        dl.text('# in deck:', 62, 166);  // first row, main deck
        dl.text('Card Name:', 122, 166);
        dl.setFont('helvetica');
        dl.setFontSize(12);
        dl.setFontStyle('normal');
        i = 0;
        <?php foreach (json_decode($deck["cards"], true) as $name => $qty) { ?>
          if(i < 31) {
            y += 18;
            dl.text("<?=$qty;?>", x, y);
            dl.text("<?=$name;?>", x + 38, y);
          }
          i++;
        <?php } ?>
      } else {
        dl.setFont('times');
        dl.setFontStyle('bold');
        dl.setFontSize(13);
        dl.text('Main Deck Continued:', 336, 149);
        dl.setFontSize(11);
        dl.text('# in deck:', 336, 166); // second row, main deck
        dl.text('Card Name:', 396, 166);
        dl.setFont('helvetica');
        dl.setFontSize(12);
        dl.setFontStyle('normal');
        i = 0;
        <?php $totalMain = 0; ?>
        <?php foreach (json_decode($deck["cards"], true) as $name => $qty) { ?>
          if(i > 31 && i <= 42) {
            y += 18;
            dl.text("<?=$qty;?>", x, y);
            dl.text("<?=$name;?>", x + 38, y);
          }
          <?php $totalMain += $qty; ?>
          i++;
        <?php } ?>
      }

      x = 356, y = 182;
    }


    dl.setFont('times');
    dl.setFontSize(13);
    dl.setFontStyle('bold');
    dl.text('Sideboard:', 336, 404);
    dl.setFontSize(11);
    dl.text('# in deck:', 336, 420); // second row, sideboard
    dl.text('Card Name:', 396, 420);

    // Add the sideboard to the decklist
    dl.setFont('helvetica');
    dl.setFontSize(12);
    dl.setFontStyle('normal');
    x = 356;
    y = 434;
    i = 0;
    <?php $totalSide = 0; ?>
    <?php foreach (json_decode($deck["sideboard"], true) as $name => $qty) { ?>
      if(i <= 15) {
        y += 18;
        dl.text("<?=$qty;?>", x, y);
        dl.text("<?=$name;?>", x + 38, y);
      }
      i++;
      <?php $totalSide += $qty; ?>
    <?php } ?>
    // Add the maindeck count
    dl.setFont('times');
    dl.setFontSize(11);
    dl.setFontStyle('bold');
    dl.text('Total Number of Cards in Main Deck:', 62, 768);
    dl.setFont('helvetica');
    dl.setFontSize(20);
    dl.setFontStyle('normal');
    dl.text("<?= $totalMain; ?>", 273, 766);

    // Add the sideboard count
    dl.setFont('times');
    dl.setFontSize(11);
    dl.setFontStyle('bold');
    dl.text('Total Number of Cards in Sideboard:', 336, 714);
    dl.setFont('helvetica');
    dl.setFontSize(20);
    dl.setFontStyle('normal');
    dl.text("<?=$totalSide; ?>", 545, 712);

    dl.setFont('times');
    dl.setFontSize(5);
    dl.setFontStyle('bold');
    dl.text('FOR OFFICAL USE ONLY', 324, 730);

    dl.setFontSize(6);
    dl.setFontStyle('normal');
    dl.text('Deck Check Rd #:', 324, 742); // first row
    dl.text('Status:', 324, 754);
    dl.text('Judge:', 324, 766);

    dl.text('Main/SB:', 454, 730);        // second row
    dl.text('/', 520, 730);
    dl.text('Deck Check Rd #:', 454, 742);
    dl.text('Status:', 454, 754);
    dl.text('Judge:', 454, 766);

    return dl;
  }

  // Performs validation on user input and updates PDF
  function generateDecklistPDF() {
    // get complete PDF
    const dl = generateStandardDecklist();

    dl.save('decklist.pdf');
  }

</script>