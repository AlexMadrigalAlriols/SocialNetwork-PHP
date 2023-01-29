<!DOCTYPE html>
<html lang="en">

<?php require_once('header.php'); ?>

<body id="body-pd" class="body-pd overflow-x-hidden">
  <?php require_once("cards/www/controllers/deck-view.php"); ?>
    <?php require_once('navControlPanel.php') ?>
    
    <div class="card filterBox loader-container" id="containerLoader">
      <div id="loader"></div>
    </div>

    <div class="card mb-3 filterBox" id="deck-container" style="display: none;">
          <div class="card-header p-3">
            <div>
              <img src="<?=$deck["deck_img"];?>" alt="" width="200" class="d-inline-block pull-left me-4 rounded">
              <div class="d-inline-block mt-2">
                <h3 class="d-inline-block"><?=$deck["name"];?></h3>
                <form method="POST" class="d-inline-block">
                  <button class="text-purple-light w-100 ms-2 btn-report-deck" name="commandReport" value="<?=$deck["id_deck"];?>" type="submit"><i class='bx bxs-error-alt'></i> <?=$user->i18n("report_deck_name");?></button>
                </form>
              </div>

                
              <h3 class="d-inline-block pull-right text-purple-light tabletop-text">Tabletop: <span class="f-25" id="priceTotal"></span> $</h3>
            </div>
            
            <div>
              <div class="d-inline-block">
                <p><b><?=$user->i18n("owner");?>: </b><a href="/profile/<?=$deck["user_id"]; ?>" class="text-white decoration-none"> <?=$deck["owner_name"]; ?></a></p>
                <p><b><?=$user->i18n("format");?>: </b> <?=$deck["format"];?></p>
                <p><b><?=$user->i18n("deck_date");?>: </b> <?= date("d-m-Y", strtotime($deck["updatedDate"]));?></p>
              </div>
              <div class="d-inline-block pull-right">
                <h4 class="d-inline-block pull-right tabletop-text">MTGO: <span class="f-20" id="priceTixTotal"></span> tix</h4>
              </div>
            </div>
            
          </div>

          <div class="card-body">
            <div class="row">
              <div class="col-md-9" class="d-inline-block">
                <div class="card view-deck-card">
                  <div class="card-header">
                    <h6 class="d-inline-block"><?=$user->i18n("deck_list");?></h6>
                    <span class="d-inline-block pull-right" id="rarityCount"></span>
                  </div>

                  <div class="card-body">
                      <div class="alert alert-warning alert-dismissible d-none" role="alert" id="cardsNotLegal">
                      <i class="fa-solid fa-circle-exclamation me-2" width="24" height="24" role="img" aria-label="Success:" ></i><?=$user->i18n("cards_not_legal");?>: <a id="whatCards"></a> <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
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
              <div class="col-md-2 container d-inline-block mt-4">
                <div class="row">
                  <a class="btn btn-primary mb-3" href="/check-cards/<?php echo $id_deck; ?>"><i class='bx bx-purchase-tag' ></i> <?=$user->i18n("my_price");?></a>
                  <button class="btn btn-primary mb-3" onclick="sharePublication(<?=$id_deck;?>, '<?= gc::getSetting('site.url'); ?>')"><i class='bx bx-share-alt' ></i> <?=$user->i18n("share_deck");?></button>
                  <a href="/deck/get-proxies/<?=$id_deck;?>" class="btn btn-primary mb-3"><i class='bx bx-image' ></i> <?=$user->i18n("print_proxies");?></a>
                  <a class="btn btn-primary mb-3" href="/decks/new-deck/<?php echo $id_deck; ?>"><i class='bx bx-save' ></i> <?=$user->i18n("edit_and_save");?></a>
                  <button class="btn btn-primary mb-3" onclick="generateDecklistPDF();"><i class='bx bxs-file-pdf' ></i> <?=$user->i18n("registration_pdf");?></button>
                  <a href="/deck-export/<?php echo $id_deck; ?>" class="btn btn-primary mb-3"><i class='bx bx-export' ></i> <?=$user->i18n("export_deck");?></a>
                </div>
              </div>
            </div>
          </div>
          <?php require_once('_toast.php') ?>
</body>

</html>

<script src="/cards/assets/js/headerControler.js"></script>
<script type="text/javascript" src="/cards/assets/vendor/jsPDF/jspdf-1.3.4.min.js"></script>
<script>
    var sideLines = JSON.parse(<?= json_encode($deck["sideboard"]); ?>);
    var data = JSON.parse(<?= json_encode($deck["cards"]); ?>);
    var formatDeck = "<?=$deck["format"];?>";
</script>
<script src="/cards/assets/js/deckViewController.js">
</script>

<script>
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

<?php require_once('cards/www/templates/_footer.php'); ?>