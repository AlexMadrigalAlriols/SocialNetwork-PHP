<!DOCTYPE html>
<html lang="en">
<?php 
require_once('cards/www/controllers/tournaments-edit.php');
require_once('header.php'); 
?>
<body id="body-pd" class="body-pd overflow-x-hidden">
    <?php require_once('navControlPanel.php') ?>
    <div class="form-decks row position-relative">
      <div class="col-lg-9">
        <div class="card ml-3 filterBox">
          <div class="card-header">
            <h6><?= ($id_tournament ? "Edit Tournament" : "New Tournament") ?></h6>
          </div>
          <div class="card-body">
            <div class="row">
              <form method="post" enctype="multipart/form-data">
                <div class="input-group">
                  <div class="ml-3 mb-3 col-lg-12 addon-btn-filters">
                    <label for="tournamentName" class="form-label"><?= $user->i18n("tournament_name");?></label>
                    <input type="text" class="form-control" required id="tournamentName" placeholder="Ex. Friday Night" name="tournament[name]" aria-describedby="validationServer03Feedback" value="<?=(isset($tournament["name"]) ? $tournament["name"] : "")?>">
                    <div id="validationServer03Feedback" class="invalid-feedback">
                      <?= $user->i18n("invalid_tour_name");?>
                    </div>
                  </div>
                </div>
                <div class="input-group">
                  <div class="ml-3 mb-3 col-lg-12 addon-btn-filters">
                    <label for="tournamentLoc" class="form-label"><?= $user->i18n("ubication");?></label><br>
                    <small class="text-muted">Ex. Street, Number, Postal Code. State, Country</small>
                    <input type="text" class="form-control" required id="tournamentLoc" placeholder="Shop/Ubication" name="tournament[ubication]" value="<?=(isset($tournament["ubication"]) ? $tournament["ubication"] : "")?>">
                  </div>
                </div>

                <div class="row mb-3">
                  <div class="ml-3 col-lg-5">
                    <label for="tournamentFormat" class="form-label"><?= $user->i18n("format");?></label>
                    <div class="input-group">
                      <select class="form-select" aria-label="Default select example" name="tournament[format]" id="tournamentFormat">
                        <option value="----" selected>----</option>
                          <?php foreach ($formats as $idx => $value) { ?>
                            <option value="<?=$value;?>" <?= ($value == (isset($tournament["format"]) ? $tournament["format"] : "---") ? "selected" : ""); ?>><?=$value;?></option>
                          <?php } ?>
                      </select>
                    </div>
                  </div>
                  <div class="col-lg-3">
                    <label for="tournamentPrice" class="form-label"><?= $user->i18n("price");?></label>
                    <div class="input-group">
                      <input type="number" class="form-control" required placeholder="Ex. 30" id="tournamentPrice" name="tournament[tournament_price]" aria-describedby="eur-addon" value="<?=(isset($tournament["tournament_price"]) ? $tournament["tournament_price"] : "0")?>">
                      <span class="input-group-text" id="eur-addon"><?=gc::getSetting("currencies")[$user_details["shop_currency"]];?></span>
                    </div>
                  </div>
                  <div class="col-lg-4">
                    <label for="tournamentPrice" class="form-label"><?= $user->i18n("max_players");?></label>
                    <div class="input-group">
                      <input type="number" class="form-control" required placeholder="Ex. 25" id="tournamentMaxPlayers" name="tournament[max_players]" aria-describedby="player-addon" value="<?=(isset($tournament["max_players"]) ? $tournament["max_players"] : "0")?>">
                      <span class="input-group-text" id=""><?= $user->i18n("players");?></span>
                    </div>
                  </div>
                </div>

                <div class="row mb-4">
                <div class="col-lg-4">
                    <label for="tournamentDate" class="form-label"><?= $user->i18n("tournament_date");?></label>
                    <div class="input-group">
                      <input type="datetime-local" class="form-control" required placeholder="Ex. 25" id="tournamentDate" name="tournament[start_date]" value="<?=(isset($tournament["start_date"]) ? $tournament["start_date"] : "")?>">
                    </div>
                  </div>
                  <div class="col-lg-8 mb-4">
                    <label for="tournamentImage" class="form-label"><?= $user->i18n("tournament_img");?></label>
                    <div class="input-group">
                      <input type="file" onchange="loadFile(event)" class="form-control" id="tournamentImage" name="tournament[image]">
                    </div>
                  </div>

                  <div class="col-lg-12">
                    <label for="tournamentImage" class="form-label"><?= $user->i18n("tournament_description");?></label>
                    <div class="input-group">
                      <textarea name="tournament[description]" placeholder="Ex. Just an another modern tournament." cols="1" rows="2" class="form-control"><?=(isset($tournament["description"]) ? $tournament["description"] : "")?></textarea>
                    </div>
                  </div>
                </div>

                <h3><?= $user->i18n("prices");?></h3>
                <hr>
                <div class="row ms-4">
                  <table>
                    <tr>
                      <th>Nº</th>
                      <th><?= $user->i18n("card_name");?></th>
                      <th><?= $user->i18n("qty");?></th>
                      <th>Foil?</th>
                      <th><?= $user->i18n("actions");?></th>
                    </tr>
                    <tbody id="table-prices">
                      <?php if(!isset($prices) || !count($prices)) { ?>
                        <tr class="text-center" id="line-1-position---1">
                          <th class="py-3">1. <input type="hidden" name="prices[1][1][id]" id="input-search-card-id-1-1" value=""><input type="hidden" name="prices[1][1][type]" id="input-search-card-type-1-1" value="card"></th>
                          <th class="py-3">
                            <div class="input-group w-75">
                              <input type="text" name="prices[1][1][name]" id="input-search-card-1-1" class="form-control" role="button" data-id="1" data-line="1" onclick="openCardsModal(this)" readonly placeholder="Ex. Black Lotus (LEA)" value="">
                              <div class="input-group-append">
                                <button class="btn btn-primary" onclick="openCardsModal(this)" type="button" data-id="1" data-line="1"><i class="fa-solid fa-magnifying-glass"></i></button>
                              </div>
                            </div>
                          </th>
                          <th class="py-3"><input type="number" name="prices[1][1][qty]" class="form-control w-75" value="0"></th>
                          <th class="py-3"><input type="checkbox" name="prices[1][1][foil]" class="align-middle"></th>
                          <th><button class="btn btn-success" type="button" onclick="addLine(this)" data-position="1" data-line="1"><i class="fa-solid fa-plus"></i></button></th>
                        </tr>
                      <?php } else { ?>
                        <?php foreach ($prices as $position => $line) { ?>
                          <?php foreach ($line as $id_line => $price) { ?>
                          <tr class="text-center" id="line-<?=$id_line;?>-position---<?=$position;?>">
                            <th class="py-3">
                              <?=($id_line == 1 ? $position . "." : "")?> 
                              <input type="hidden" name="prices[<?=$position;?>][<?=$id_line;?>][id]" id="input-search-card-id-<?=$position;?>-<?=$id_line;?>" value="<?=(isset($price["id"]) ? $price["id"] : "")?>">
                              <input type="hidden" name="prices[<?=$position;?>][<?=$id_line;?>][type]" id="input-search-card-type-<?=$position;?>-<?=$id_line;?>" value="<?=(isset($price["type"]) ? $price["type"] : "card")?>">
                            </th>
                            <th class="py-3">
                              <div class="input-group w-75">
                                <input type="text" name="prices[<?=$position;?>][<?=$id_line;?>][name]" id="input-search-card-<?=$position;?>-<?=$id_line;?>" role="button" data-id="<?=$position;?>" data-line="<?=$id_line;?>" onclick="openCardsModal(this)" class="form-control" readonly placeholder="Ex. Black Lotus (LEA)" value="<?=(isset($price["name"]) ? $price["name"] : "");?>">
                                <div class="input-group-append">
                                  <button class="btn btn-primary" onclick="openCardsModal(this)" type="button" data-id="<?=$position;?>" data-line="<?=$id_line;?>"><i class="fa-solid fa-magnifying-glass"></i></button>
                                </div>
                              </div>
                            </th>
                            <th class="py-3"><input type="number" name="prices[<?=$position;?>][<?=$id_line;?>][qty]" class="form-control w-75" value="<?=(isset($price["qty"]) ? $price["qty"] : "0")?>"></th>
                            <th class="py-3"><input type="checkbox" name="prices[<?=$position;?>][<?=$id_line;?>][foil]" class="align-middle" <?=(isset($price["foil"]) && $price["foil"] == "on" ? "checked" : "")?>></th>
                            <th><?php if($position != 1 && $id_line == 1) { ?>
                                <button class="btn btn-success" type="button" onclick="addLine(this)" data-position="<?=$position;?>" data-line="<?=count($line);?>"><i class="fa-solid fa-plus"></i></button>
                                <button class="btn btn-danger" type="button" onclick="removePosition(<?=$position;?>)"><i class="fa-solid fa-trash"></i></button>
                              <?php } else if($id_line != 1) { ?> 
                                <button class="btn btn-danger" type="button" onclick="removeLine('<?=$position;?>', '<?=count($line);?>')"><i class="fa-solid fa-trash"></i></button> 
                              <?php } else if($id_line == 1 && $position == 1) { ?>
                                <button class="btn btn-success" type="button" onclick="addLine(this)" data-position="1" data-line="1"><i class="fa-solid fa-plus"></i></button>
                              <?php } ?></th>
                          </tr>
                          <?php } ?>
                        <?php }
                        } ?>
                    </tbody>
                    <tfoot>
                      <tr>
                        <td></td>
                        <td><button class="btn btn-primary" id="addMorePrices" type="button"><?= $user->i18n("add_position");?></button></td>
                      </tr>
                    </tfoot>
                  </table>
                </div>
                
                <div class="mb-3">
                  <button type="submit" class="btn btn-success pull-right m-2" name="commandSave" value="1"><?= $user->i18n("save");?></button>
                  <a href="/tournaments"><button type="button" class="btn btn-danger pull-right m-2"><?= $user->i18n("cancel");?></button></a>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
      <div class="col-lg-3 tournament-preview">
        <div class="card filterBox">
          <div class="card-header">
            <h6><?= $user->i18n("preview");?></h6>
          </div>
          <div class="card-body">
            <img src="<?=(isset($tournament["image"]) && $tournament["image"] ? "/cards/uploads/".$tournament["image"] : "/cards/assets/img/placeholder.png")?>" class="card-img-top mt-3 rounded tournament-img" id="imgContainer">
            <div class="card-body">
              <h6 id="nameTxt">Open Modern 2022</h6>
              <span class="text-muted f-14"><i class="fa-solid fa-cubes me-1"></i> <span id="formatTxt"><?=(isset($tournament["format"]) ? $tournament["format"] : "---")?></span></span><br>
              <span class="text-muted f-14"><i class="fa-solid fa-clock me-2"></i> <span id="dateTxt"><?=(isset($tournament["start_date"]) ? $tournament["start_date"] : date("d-m-y h:m"))?></span></span><br>
              <span class="text-muted f-14"><i class="fa-solid fa-users me-1"></i> <span id="playersTxt"><?=(isset($tournament["max_players"]) ? $tournament["max_players"] . "/" . $tournament["max_players"] : "30/30")?> <?= $user->i18n("players");?></span></span><br>
              <span class="text-muted"><b class="f-20 text-purple" id="priceTxt"><?=(isset($tournament["tournament_price"]) ? $tournament["tournament_price"] : "5")?></b><b class="f-20 text-purple"><?=gc::getSetting("currencies")[$user_details["shop_currency"]];?></b>/<?= $user->i18n("player");?></span>
              <hr class="w-100">
              <center><button class="btn btn-primary d-md-block w-100" disabled><?= $user->i18n("view_details");?></button></center>
            </div>
          </div>
        </div>
      </div>
    </div>

  <div class="modal text-white" id="cardsModal" tabindex="-1" aria-labelledby="cardsModalLabel" aria-hidden="true">
    <div class="modal-dialog bg-dark modal-lg">
        <div class="modal-content bg-dark">
            <div class="modal-header">
                <h5 class="modal-title"><?=$user->i18n("search_cards");?></h5>
                <button type="button" class="btn-close text-white" data-bs-dismiss="modal" aria-label="Close"><i class="fa-solid fa-xmark"></i></button>
            </div>
            <div class="modal-body">

              <div class="container mb-5 mt-1">
                <ul class="nav-pills nav-fill w-100">
                  <li class="nav-item d-inline-block">
                    <a class="nav-link active" aria-current="page"><?=$user->i18n("cards");?></a>
                  </li>
                  <li class="nav-item d-inline-block">
                    <button class="nav-link" onclick="openTextModal()"><?=$user->i18n("other");?></button>
                  </li>
                </ul>

                <div class="input-group w-75 m-auto">
                  <input type="text" class="form-control" id="input-search-card" placeholder="Ex. Black Lotus">
                  <div class="input-group-append">
                    <button class="btn btn-success" type="button" id="searchButton"><?=$user->i18n("search");?></button>
                  </div>
                </div>
                <div id="form-body" class="position-absolute"></div>
                <div class="container text-center">
                  <div id="cardsSearched" class="m-auto"></div>
                </div>
                
              </div>
              
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal"><?=$user->i18n("close");?></button>
            </div>
        </div>
    </div>
</div>

<div class="modal text-white" id="textModal" tabindex="-1" aria-labelledby="cardsModalLabel" aria-hidden="true">
    <div class="modal-dialog bg-dark modal-lg">
        <div class="modal-content bg-dark">
            <div class="modal-header">
                <h5 class="modal-title"><?=$user->i18n("text_input");?></h5>
                <button type="button" class="btn-close text-white" data-bs-dismiss="modal" aria-label="Close"><i class="fa-solid fa-xmark"></i></button>
            </div>
            <div class="modal-body">

              <div class="container mb-5 mt-1">
                <ul class="nav-pills nav-fill w-100">
                  <li class="nav-item d-inline-block">
                    <button class="nav-link" onclick="openCardsModalMenu()"><?=$user->i18n("cards");?></button>
                  </li>
                  <li class="nav-item d-inline-block">
                    <a class="nav-link active"><?=$user->i18n("other");?></a>
                  </li>
                </ul>

                <div class="input-group w-75 m-auto">
                  <input type="text" class="form-control" id="input-text-prices" placeholder="Ex. Booster New Capenna">
                  <div class="input-group-append">
                    <button class="btn btn-success" type="button" id="putTextButton"><?=$user->i18n("save");?></button>
                  </div>
                </div>
              </div>
              
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal"><?=$user->i18n("close");?></button>
            </div>
        </div>
    </div>
</div>
<?php require_once('_toast.php') ?>
</body>

</html>

<script src="/cards/assets/js/headerControler.js"></script>

<script>
    var id_position = 0;
    var positions = <?=(isset($prices) && count($prices) ? count($prices) : 1) ?>;

    $("#tournaments").addClass('active');
    $("#tournamentName").keyup(function(){
      $("#nameTxt").text($("#tournamentName").val());
    });      
    
    $("#tournamentFormat").change(function(){
      $("#formatTxt").text($("#tournamentFormat").val());
    });

    $("#tournamentDate").change(function(){
      $("#dateTxt").text($("#tournamentDate").val());
    });

    // Max Players
    $("#tournamentMaxPlayers").change(function(){
      $("#playersTxt").text($("#tournamentMaxPlayers").val() + "/" + $("#tournamentMaxPlayers").val() + " players");
    });
    $("#tournamentMaxPlayers").keyup(function(){
      $("#playersTxt").text($("#tournamentMaxPlayers").val() + "/" + $("#tournamentMaxPlayers").val() + " players");
    });
    ///

    $("#tournamentPrice").change(function(){
      $("#priceTxt").text($("#tournamentPrice").val());
    });
    $("#tournamentPrice").keyup(function(){
      $("#priceTxt").text($("#tournamentPrice").val());
    });

    var loadFile = function(event) {
        var output = document.getElementById('imgContainer');
        output.src = URL.createObjectURL(event.target.files[0]);
        output.onload = function() {
            URL.revokeObjectURL(output.src);
        }
    };

    $('#input-search-card').keyup(function() {
      var id = $(this).data("id");
      $.ajax({
        url: '/autoComplet',
        type: 'POST',
        data: {autocomplet: $(this).val()},
        success: function(data) {
          resultNames = data.split(";");
          $(".elementos-cartas").remove();

          resultNames.forEach(name => {
            if(name != "" && $(".elementos-cartas").size() < 5){
              html = "<a role='button' onclick='getCompletedNameCard(this, "+id+")'><div class='form-control elementos-cartas'><h6>"+name+"</h6></div></a>";
                $("#form-body").append(html);
            }
          });
        }
      });
    });

    $("#searchButton").click(function() {
      $.ajax({
        url: '/getCards',
        type: 'POST',
        async: false,
        data: {card_name: $("#input-search-card").val()},
        success: function(data) {
          cards = JSON.parse(data);

          $("#cardsSearched").empty();
          $(".elementos-cartas").remove();
          cards.forEach(card => {
            html = "<div class='text-center d-inline-block'>"+
                "<img src='"+card.img+"' class='m-2' width='175px'></br>"+
                "<button class='btn btn-success addPrice' type='button' data-position='"+id_position+"' data-line='"+id_line+"' data-id='"+card.id+"' data-edition='"+card.set_name+"' data-set='"+card.set+"' data-name='"+card.name+"' onclick='putCardPrice(this)'>Add Price</button>"+
            "</div>";

            $("#cardsSearched").append(html);
          });
        }
      });
    });

    $("#addMorePrices").click(function() {
      positions++;
      html = '<tr class="text-center" id="line-1-position---'+positions+'">'+
        '<th class="py-3">'+positions+'. '+
        '<input type="hidden" name="prices['+positions+'][1][id]" id="input-search-card-id-'+positions+'-1" value="">'+
        '<input type="hidden" name="prices['+positions+'][1][type]" id="input-search-card-type-'+positions+'-1" value="card">'+
        '</th>'+
          '<th class="py-3">'+
            '<div class="input-group w-75">'+
              '<input type="text" name="prices['+positions+'][1][name]" id="input-search-card-'+positions+'-1" role="button" data-id="'+positions+'" data-line="1" onclick="openCardsModal(this)" class="form-control" readonly placeholder="Ex. Black Lotus (LEA)" value="">'+
              '<div class="input-group-append">'+
                '<button class="btn btn-primary" onclick="openCardsModal(this)" type="button" data-id="'+positions+'" data-line="1"><i class="fa-solid fa-magnifying-glass"></i></button>'+
              '</div>'+
            '</div>'+
          '</th>'+
          '<th class="py-3"><input type="number" name="prices['+positions+'][1][qty]" class="form-control w-75" value="0"></th>'+
          '<th class="py-3"><input type="checkbox" name="prices['+positions+'][1][foil]" class="align-middle"></th>'+
          '<th><button class="btn btn-success me-3" id="btn-position-'+positions+'" onclick="addLine(this)" data-position="'+positions+'" data-line="1" type="button"><i class="fa-solid fa-plus"></i></button>'+
          '<button class="btn btn-danger" onclick="removePosition('+positions+')" type="button"><i class="fa-solid fa-trash"></i></button></th>'+
        '</tr>';
      $("#table-prices").append(html);
    });

    $("#putTextButton").click(function(){
      $("#input-search-card-"+id_position+"-"+id_line).val($("#input-text-prices").val());
      $("#input-search-card-id-"+id_position+"-"+id_line).val("");
      $("#input-search-card-type-"+id_position+"-"+id_line).val("text");
      $('#textModal').modal('toggle');
      $("#cardsSearched").empty();
      $(".elementos-cartas").remove();
      $("#input-text-prices").val("");
      $('#added').toast('show');
    });

    function putCardPrice(cardClicked) {
      $("#input-search-card-"+$(cardClicked).data("position") + "-" + $(cardClicked).data("line")).val($(cardClicked).data("name") + " (" + $(cardClicked).data("set") + ")");
      $("#input-search-card-id-"+$(cardClicked).data("position") + "-" + $(cardClicked).data("line")).val($(cardClicked).data("id"));
      $("#input-search-card-type-"+$(cardClicked).data("position") + "-" + $(cardClicked).data("line")).val("card");
      $('#cardsModal').modal('toggle');
      $("#cardsSearched").empty();
      $(".elementos-cartas").remove();
      $("#input-search-card").val("");
      $('#added').toast('show');
    };

    function openCardsModal(inputClicked) {
      id_position = $(inputClicked).data("id");
      id_line = $(inputClicked).data("line");
      $('#cardsModal').modal('toggle');
    };

    function openTextModal() {
      $('#cardsModal').modal('toggle');
      $('#textModal').modal('toggle');
    };

    function openCardsModalMenu() {
      $('#textModal').modal('toggle');
      $('#cardsModal').modal('toggle');
      $(body).removeClass('modal-open');
    };

    function getCompletedNameCard(cardClicked, id){
      $("#input-search-card").val(cardClicked.text);
      $(".elementos-cartas").remove();
    }

    function addLine(inputClicked) {

      position = $(inputClicked).data("position");
      $(inputClicked).data("line", $(inputClicked).data("line")+1);
      line = $(inputClicked).data("line");

      html = '<tr id="line-'+line+'-position---'+position+'">'+
        '<th class="py-3">'+
        '<input type="hidden" name="prices['+position+']['+line+'][id]" id="input-search-card-id-'+position+'-'+line+'" value="">'+
        '<input type="hidden" name="prices['+position+']['+line+'][type]" id="input-search-card-type-'+position+'-'+line+'" value="card">'+
        '</th>'+
          '<th class="py-3">'+
            '<div class="input-group w-75">'+
              '<input type="text" name="prices['+position+']['+line+'][name]" id="input-search-card-'+position+'-'+line+'" role="button" data-id="'+position+'" data-line="'+line+'" onclick="openCardsModal(this)" class="form-control" readonly placeholder="Ex. Black Lotus (LEA)" value="">'+
              '<div class="input-group-append">'+
                '<button class="btn btn-primary" onclick="openCardsModal(this)" type="button" data-id="'+position+'" data-line="'+line+'"><i class="fa-solid fa-magnifying-glass"></i></button>'+
              '</div>'+
            '</div>'+
          '</th>'+
          '<th class="py-3"><input type="number" name="prices['+position+']['+line+'][qty]" class="form-control w-75" value="0"></th>'+
          '<th class="py-3 text-center"><input type="checkbox" name="prices['+position+']['+line+'][foil]" class="align-middle"></th>'+
          '<th class="text-center"><button class="btn btn-danger" onclick="removeLine('+position+', '+line+')" type="button"><i class="fa-solid fa-trash"></i></button></th>'+
        '</tr>';
        $("#line-1-position---"+position).after(html);
    }

    function removePosition(position) {
      positions--;
      $("#line---"+position).remove();

      $('tr[id$="position---'+position+'"]').each(function( index ) {
        $( this ).remove()
      });
    }

    function removeLine(position, line) {
      $("#line-"+line+"-position---"+position).remove();
    }
</script>