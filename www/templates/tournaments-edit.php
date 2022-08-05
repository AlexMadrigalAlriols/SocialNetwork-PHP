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

  $sql="select name, id_deck from decks WHERE user_id =".$_SESSION["iduser"];

  if ($resultado = mysqli_query($conexion, $sql)) {

    while ($fila = mysqli_fetch_row($resultado)) {
      $userDecks[$fila[0]] = $fila[1];
    }
  }
?>
<body id="body-pd" class="body-pd" style="overflow-x: hidden;">

    <?php require_once('navControlPanel.php') ?>
    <div class="form-decks" style="position: relative;">
    
      <div class="card ml-3 filterBox card-active" id="firstStep" style="margin-left: 2rem;">
            <div class="card-header">
               <h6><span class="fa fa-calendar mr-3"></span>New Tournament</h6>
            </div>
        <div class="card-body">
                <div class="row">
                    <form>
                        <div class="input-group">
                            <div class="ml-3 mb-4 col-lg-12">
                                <label for="tournamentName" class="form-label">Tournament Name</label>
                                <input type="text" class="form-control" id="tournamentName" placeholder="Ex. Friday Night" name="tournamentName" aria-describedby="validationServer03Feedback">
                                <div id="validationServer03Feedback" class="invalid-feedback">
                                    Please put a valid tournament name.
                                </div>
                            </div>
                        </div>

                        <div class="input-group">
                            <div class="ml-3 mb-4 col-lg-12">
                                <label for="tournamentLoc" class="form-label">Tournament Location</label>
                                <input type="text" class="form-control" id="tournamentLoc" placeholder="Shop/Ubication" name="tournamentLoc" aria-describedby="validationServer03Feedback">

                            </div>
                        </div>

                        <div class="input-group" id="roundsCount">
                            <div class="ml-3 mb-4 col-lg-5">
                                <label for="roundsWon" class="form-label">Rounds Won</label>
                                <input type="number" class="form-control" id="roundsWon" placeholder="Ex. 5" name="roundsWon" value="0" min="0">
                                <div id="validationServer03Feedback" class="invalid-feedback">
                                    At least put 1 round
                                </div>
                            </div>
                            
                            <div class="ml-3 mb-3 col-lg-3" style="margin-left: 4%;">
                                <label for="roundsLost" class="form-label">Rounds Lost</label>
                                <input type="number" class="form-control" id="roundsLost" placeholder="Ex. 5" name="roundsLost" value="0" min="0">
                            </div>

                            <div class="ml-3 mb-4 col-lg-3" style="margin-left: 4%;">
                                <label for="roundsDraw" class="form-label">Rounds Draw</label>
                                <input type="number" class="form-control" id="roundsDraw" placeholder="Ex. 5" name="roundsDraw" value="0" min="0">
                            </div>
                        </div>


                        <div class="input-group">
                            <div class="ml-3 mb-4 col-lg-12">
                                <label for="deckUsed" class="form-label">Deck Played</label>
                                <select class="form-select" aria-label="Default select example" name="deckUsed" id="deckUsed">
                                  <option value="-1" selected>----</option>
                                  <?php foreach ($userDecks as $name => $id) {?>
                                  <option value="<?php echo $id; ?>"><?php echo $name; ?></option>
                                  <?php } ?>
                                  <option value="other" disabled>----</option>
                                  <option value="-1">Other</option>
                                </select>
                            </div>
                        </div>

                        <div class="input-group">
                            <div class="ml-3 mb-4 col-lg-12">
                                <label for="formatTournament" class="form-label">Tournament Format</label>
                                <select class="form-select" aria-label="Default select example" name="formatTournament" id="formatTournament">
                                  <option value="----" selected>----</option>
                                  <option value="Modern">Modern</option>
                                  <option value="Standard">Standard</option>
                                  <option value="Pauper">Pauper</option>
                                  <option value="Historic">Historic</option>
                                  <option value="Pioneer">Pioneer</option>
                                </select>
                            </div>
                        </div>

                        <div class="input-group">
                            <div class="ml-3 mb-4 col-lg-12">
                                <label for="deckOptionsLabel" class="form-label">Options</label>
                                <div class="form-check">
                                  <input class="form-check-input" type="checkbox" id="configInfo" name="configInfo">
                                  <label class="form-check-label" for="configInfo">
                                    Config Info About Rounds
                                  </label>
                                </div>

                                <div class="form-check">
                                  <input class="form-check-input" type="checkbox" value="" id="privateDeck" name="privateDeck">
                                  <label class="form-check-label" for="privateDeck">
                                    Config prices won
                                  </label>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <button type="button" class="btn btn-success" style="float:right; margin: 5px;" id="saveTournament">Save</button>
                            <button type="button" class="btn btn-success d-none" style="float:right; margin: 5px;" id="nextStepInfo">Next</button>
                            <a href="/tournaments"><button type="button" class="btn btn-danger" style="float:right; margin: 5px;">Cancel</button></a>
                        </div>
                    </form>
                </div>
            </div>
      </div>

      <div class="card mb-3 filterBox card2" id="secondStep">
          <div class="card-header">
              <h6><span class="fa fa-calendar mr-3"></span>New Tournament</h6> <a class="btn btn-primary" style="display: inline-block; float:right;" onclick="addRound('win')">Add Round</a>   
          </div>

          <div class="card-body">
              <div class="row">
                  <form>
                      <div class="input-group" id="rounds"></div>

                      <div class="mb-3 buttons-editDeck" >
                          <a href="/tournaments"><button type="button" class="btn btn-danger" style="margin: 5px;">Cancel</button></a>
                          <button type="button" class="btn btn-warning" style="margin: 5px;" id="backAddCards">Back</button>
                          <button type="button" class="btn btn-success" style="margin: 5px;" id="addTournamentInfo">Save</button>
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
    var rounds = 0;
    var totalRounds = 0;
    var virtualRounds = 0;
    var atras = false;
    var edit_rounds = false;
    $.ajax({
        url: '/procesos/settings/checkSettings',
        type: 'POST',
        data: {userId: <?php echo $_SESSION["iduser"]; ?>},
        success: function(data) {
            data = JSON.parse(data);

            if(data[0].darkMode){
                $('#body-pd').toggleClass("dark-mode");
                $('#modeCheck').prop("checked", true);
                dark = false;
            }
        }
    });
$( document ).ready(function() {
    var dark = true;
    
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
    
    $("#tournaments").addClass('active');

    <?php if(isset($id_tournament)) { ?>
        $.ajax({
          url: '/procesos/tournaments/getTournaments',
          type: 'POST',
          async: false,
          data: {tournament_id: <?php echo $id_tournament; ?>},
          success: function(data) {
              tournament = JSON.parse(data);
              if(tournament[0].Tournament.User_Id != "<?php echo $_SESSION["iduser"]; ?>") {
                window.location="/decks";

              } else {

                $("#textCards").val("Deck");
                $("#tournamentName").val(tournament[0].Tournament.Name);
                $("#tournamentLoc").val(tournament[0].Tournament.Site);

                var score = tournament[0].Tournament.Score.split("-");

                $("#roundsWon").val(score[0]);
                $("#roundsLost").val(score[1]);
                $("#roundsDraw").val(score[2]);

                if(tournament[0].Tournament.Rounds){
                  $('#configInfo').prop("checked", true);
                  $("#roundsCount").toggleClass("d-none");
                  $("#saveTournament").toggleClass("d-none");
                  $("#nextStepInfo").toggleClass("d-none");      

                  $.ajax({
                    url: '/procesos/tournaments/getRounds',
                    type: 'POST',
                    data: {tournament_id: <?php echo $id_tournament; ?>},
                    success: function(data) {
                        rondas = JSON.parse(data);
                        var i = 0;
                        rondas.forEach(round => {
                            i++;
                            rounds++;
                            totalRounds++;

                            var query = '<div class="mb-4 col-md-4" id="round'+i+'" data-id="'+round.Round.Id+'">'+
                                '<div class="card" style="margin-left: 4%;">'+
                                  '<div class="card-header">Round '+i+'</div>'+
                                    '<div class="card-body">'+
                                      '<div class="input-group">'+
                                        '<div class="ml-3 mb-4 col-lg-12">'+
                                          '<label for="roundResult'+i+'" class="form-label">Round Result</label>'+
                                            '<select class="form-select" name="roundResult'+i+'" id="roundResult'+i+'">'+
                                              '<option value="win">Win</option>'+
                                              '<option value="lose">Lose</option>'+
                                              '<option value="draw">Draw</option>'+
                                              '<option value="bye">Bye</option>'+
                                            '</select>'+
                                          '</div>'+
                                        '</div>'+
                                        '<div class="input-group">'+
                                          '<div class="ml-3 mb-4 col-lg-12">'+
                                            '<label for="oppDeck'+i+'" class="form-label">Opponent`s Deck</label>'+
                                            '<input type="text" class="form-control" id="oppDeck'+i+'" placeholder="Ex. Death`s Shadow" name="oppDeck'+i+'" value="'+round.Round.Opp_Deck+'">'+
                                          '</div>'+
                                          '</div>'+
                                          '<h5>Games Played</h5>'+
                                            '<div id="games'+i+'" data-totalGames="1"></div>'+
                                            '<div class="container text-center">'+
                                              '<div class="col-lg-12">'+
                                                '<button class="btn btn-primary" id="addGames" type="button" onclick="addGame('+i+');">Add Games</button>'+
                                              '</div>'+
                                            '</div>'+

                                        '</div>'+
                                      '</div>'+
                                    '</div>';

                            $("#rounds").append(query);

                            if(round.Round.Status == '2-0-0'){
                              $('#roundResult'+i+' option[value="win"]').prop("selected", true);

                            } else if(round.Round.Status == '1-2-0') {
                              $('#roundResult'+i+' option[value="lose"]').prop("selected", true);
                              
                            } else if(round.Round.Status == '0-2-0') {
                              $('#roundResult'+i+' option[value="lose"]').prop("selected", true);

                            } else if(round.Round.Status == '2-1-0') {
                              $('#roundResult'+i+' option[value="win"]').prop("selected", true);

                            } else if(round.Round.Status == '1-1-0') {
                              $('#roundResult'+i+' option[value="draw"]').prop("selected", true);

                            } else if(round.Round.Status == '1-0-0') {
                              $('#roundResult'+i+' option[value="bye"]').prop("selected", true);
                            }
                            updateGames(i, round.Round.Id);
                        });
                    }
                });
                }
                
                $('#formatTournament option[value="'+tournament[0].Tournament.Format+'"]').prop("selected", true);
                $('#deckUsed option[value="'+tournament[0].Tournament.Deck_id+'"]').prop("selected", true);
              }
          }
        });
    <?php } ?>

    $('#configInfo').change(function() {
      $("#saveTournament").toggleClass("d-none");
      $("#nextStepInfo").toggleClass("d-none");
      $("#roundsCount").toggleClass("d-none");
    });

    $('#nextStepInfo').click(function() {
      if(formValidation()) {
        $("#roundsWon").addClass("is-valid");
        $("#roundsWon").removeClass("is-invalid");
        $("#tournamentName").addClass("is-valid");
        $("#tournamentName").removeClass("is-invalid");
        $('#secondStep').toggleClass("card2");
        $('#secondStep').toggleClass("card-active");
        $('#firstStep').toggleClass("card1");
      }
    });

    $('#backAddCards').click(function() {
      $('#firstStep').toggleClass("card1");
      $('#firstStep').toggleClass("card-active");
      $('#secondStep').toggleClass("card2");
      atras = true;
    });

    $('#addTournamentInfo').click(function(){
      var score = $("#roundsWon").val() + "-" + $("#roundsLost").val() + "-" + $("#roundsDraw").val();
      var win = 0;
      var lose = 0;
      var draw = 0;

      for (let idx = 0; idx < rounds; idx++) {
        if($("#roundResult"+idx).val() == "lose"){
          lose++;
        } else if($("#roundResult"+idx).val() == "draw"){
          draw++;
        } else{
          win++;
        }
        
      }

      score = (win + "-" + lose + "-" + draw);
      
      <?php if(!isset($id_tournament)){ ?>
            $.ajax({
              url: '/procesos/tournaments/new-tournament',
              type: 'POST',
              data: {userId: <?php echo $_SESSION["iduser"]; ?>, tournament_name: $("#tournamentName").val(),tournament_site:$("#tournamentLoc").val(), tournament_score: score, tournament_used_deck: ($("#deckUsed").val() != "" ? $("#deckUsed").val() : "Do not know"), tournament_format: $("#formatTournament").val()},
              success: function(data) {
                if(data != -1){
                  for (let idx = 1; idx <= rounds; idx++) {
                    var roundResult = $("#roundResult"+idx).val();
                    var opponentDeck = $("#oppDeck"+idx).val();
                    
                    win = 0;
                    lose = 0;
                    draw = 0;
                    for (let index = 1; index < parseInt($('#games'+idx).data('totalgames')); index++) {
                        var gameResult = $("#games"+idx+" #gameResult"+index).val();
                        if(gameResult == "win"){
                          win++;
                        } else if(gameResult == 'lose'){
                          lose++;
                        } else {
                          draw++;
                        }
                    }

                    $.ajax({
                      url: '/procesos/tournaments/new-round',
                      type: 'POST',
                      data: {game_status: (win + "-"+lose+"-"+draw), opponent_deck: opponentDeck, tournament_id: data},
                      success: function(data) {
                        if(data != -1){
                          for (let index = 1; index < parseInt($('#games'+idx).data('totalgames')); index++) {
                            var gameResult = $("#games"+idx+" #gameResult"+index).val();
                            var gameInfo = $("#games"+idx+" #textInfo"+index).val();

                              $.ajax({
                                url: '/procesos/tournaments/new-game',
                                type: 'POST',
                                data: {game_num: index, game_info: gameInfo, game_result: gameResult, round_id: data},
                                success: function(data) {
                                  window.location="/tournaments?success=add";
                                }
                              });
                            }
                          }
                      }
                    });
                    // END AJAX
                  }
                  // End FOR
                }
                // END IF
              }
            });
        <?php } else { ?>
          $.ajax({
              url: '/procesos/tournaments/new-tournament',
              type: 'POST',
              data: {userId: <?php echo $_SESSION["iduser"]; ?>, tournament_name: $("#tournamentName").val(),tournament_site:$("#tournamentLoc").val(), tournament_score: score, tournament_used_deck: ($("#deckUsed").val() != "" ? $("#deckUsed").val() : "Do not know"), tournament_format: $("#formatTournament").val(), tournament_id: <?php echo $id_tournament; ?>},
              success: function(data) {
                  for (let idx = 1; idx <= rounds; idx++) {
                    var roundResult = $("#roundResult"+idx).val();
                    var opponentDeck = $("#oppDeck"+idx).val();
                    var roundId = $("#round"+idx).data('id');

                    win = 0;
                    lose = 0;
                    draw = 0;
                    for (let index = 1; index < parseInt($('#games'+idx).data('totalgames')); index++) {
                        var gameResult = $("#games"+idx+" #gameResult"+index).val();

                        if(gameResult == "win"){
                          win++;
                        } else if(gameResult == 'lose'){
                          lose++;
                        } else {
                          draw++;
                        }
                    }
                    
                    if($("#round"+idx).data("id") != undefined){
                      $.ajax({
                      url: '/procesos/tournaments/new-round',
                      type: 'POST',
                      data: {game_status: (win + "-"+lose+"-"+draw), opponent_deck: opponentDeck, tournament_id: data, round_id: roundId},
                      success: function(data) {
                          if(data != -1){
                            for (let index = 1; index < parseInt($('#games'+idx).data('totalgames')); index++) {
                              var gameResult = $("#games"+idx+" #gameResult"+index).val();
                              var gameInfo = $("#games"+idx+" #textInfo"+index).val();
                              var gameId = $("#games"+idx+" #game"+index).data('id');
                              if(gameId == undefined){
                                $.ajax({
                                  url: '/procesos/tournaments/new-game',
                                  type: 'POST',
                                  data: {game_num: index, game_info: gameInfo, game_result: gameResult, round_id: roundId},
                                  success: function(data) {
                                    window.location="/tournaments?success=add";
                                  }
                                });
                              } else {
                                $.ajax({
                                  url: '/procesos/tournaments/new-game',
                                  type: 'POST',
                                  data: {game_num: index, game_info: gameInfo, game_id: gameId, game_result: gameResult},
                                  success: function(data) {
                                    window.location="/tournaments?success=add";
                                  }
                                });
                              }
                            }
                          }
                        }
                      });
                    } else {
                      
                      $.ajax({
                      url: '/procesos/tournaments/new-round',
                      type: 'POST',
                      data: {game_status: (win + "-"+lose+"-"+draw), opponent_deck: opponentDeck, tournament_id: <?php echo $id_tournament; ?>},
                        success: function(data) {
                          alert(data);
                          if(data != -1){
                            for (let index = 1; index < parseInt($('#games'+idx).data('totalgames')); index++) {
                              var gameResult = $("#games"+idx+" #gameResult"+index).val();
                              var gameInfo = $("#games"+idx+" #textInfo"+index).val();
                              var gameId = $("#games"+idx+" #game"+index).data('id');

                              $.ajax({
                                url: '/procesos/tournaments/new-game',
                                type: 'POST',
                                data: {game_num: index, game_info: gameInfo, game_result: gameResult, round_id: data},
                                success: function(data) {
                                  window.location="/tournaments?success=add";
                                }
                              });
                            }
                          }
                        }
                      });
                    } 
                  }
              }
            });
        <?php } ?>
    });

    $('#saveTournament').click(function(){
        if(formValidation()){
          var score = $("#roundsWon").val() + "-" + $("#roundsLost").val() + "-" + $("#roundsDraw").val();
          $.ajax({
            url: '/procesos/tournaments/new-tournament',
            type: 'POST',
            data: {userId: <?php echo $_SESSION["iduser"]; ?>, tournament_name: $("#tournamentName").val(),tournament_site:$("#tournamentLoc").val(), tournament_score: score, tournament_used_deck: $("#deckUsed").val(), tournament_format: $("#formatTournament").val()},
            success: function(data) {
              if(data != -1){
                window.location="/tournaments?success=add";
              } else {
                alert("Error!");
              }
            }
          });
        }
    });

});

  function showImg(x) {
    $(x).find('.showImgCard').toggleClass("d-none");
  }

  function formValidation() {
    if($("#tournamentLoc").val().trim().length === 0){
      $("#tournamentLoc").val("----");
    }
    if($("#tournamentName").val().trim().length === 0){
      $("#tournamentName").addClass("is-invalid");
      return false;
    } 

    if($("#roundsWon").val() == 0 && $("#roundsLost").val() == 0 && $("#roundsDraw").val() == 0 && !$("#configInfo").prop("checked")) {
      $("#roundsWon").addClass("is-invalid");
      return false;
    }

    return true;
    
  }

  function addGame(round){
      var games = $('#games'+round).data('totalgames');
      var query = '<div id="game'+games+'"><div class="input-group game" style="margin-left: 3%;">'+
                    '<div class="ml-3 mb-4 col-lg-11">'+
                      '<label for="roundResult" class="form-label">Game '+games+'</label><a type="button" style="float:right;" onclick="removeGame('+games+', '+round+')">X</a>'+
                        '<select class="form-select" name="gameResult'+games+'" id="gameResult'+games+'">'+
                          '<option value="win" selected>Win</option>'+
                          '<option value="lose">Lose</option>'+
                          '<option value="draw">Draw</option>'+
                        '</select>'+
                      '</div>'+
                    '</div>'+
                    '<div class="ml-3 mb-4 col-lg-11" style="margin-left: 3%;">'+
                      '<label for="roundResult" class="form-label">Game Info</label>'+
                      '<textarea name="" id="textInfo'+games+'" cols="10" rows="4" class="form-control" placeholder="Ex. Sideplan, Experience vs opponent deck or interessant info."></textarea>'+
                    '</div></div>';
      $('#games'+round).data('totalgames', parseInt(games) + 1);
      $('#games'+round).append(query);
  }

  function updateGames(roundNum, roundId){
    $.ajax({
        url: '/procesos/tournaments/getGames',
        type: 'POST',
        data: {round_id: roundId},
        success: function(data) {
          gamet = JSON.parse(data);

          var i = 0;
          gamet.forEach(game => {
            i++;
            var query = '<div id="game'+i+'" data-id="'+game.Game.Id+'"><div class="input-group game" style="margin-left: 3%;">'+
                    '<div class="ml-3 mb-4 col-lg-11">'+
                      '<label for="roundResult" class="form-label">Game '+i+'</label><a type="button" style="float:right;" onclick="removeGame('+i+', '+roundNum+')">X</a>'+
                        '<select class="form-select" name="gameResult'+i+'" id="gameResult'+i+'">'+
                          '<option value="win">Win</option>'+
                          '<option value="lose">Lose</option>'+
                          '<option value="draw">Draw</option>'+
                        '</select>'+
                      '</div>'+
                    '</div>'+
                    '<div class="ml-3 mb-4 col-lg-11" style="margin-left: 3%;">'+
                      '<label for="roundResult" class="form-label">Game Info</label>'+
                      '<textarea name="" id="textInfo'+i+'" cols="10" rows="4" class="form-control" placeholder="Ex. Sideplan, Experience vs opponent deck or interessant info.">'+game.Game.Game_info+'</textarea>'+
                    '</div></div>';

            $("#games"+roundNum).append(query);
            $('#games'+roundNum+' #game'+i+' option[value="'+game.Game.Game_result+'"]').prop("selected", true);

            var gameTotal = $('#games'+roundNum).data('totalgames');
            $('#games'+roundNum).data('totalgames', parseInt(gameTotal) + 1);
          });
        }
    });
  }

  function addRound(result) {
    rounds++;
    virtualRounds = totalRounds;
    virtualRounds++;

    var query = '<div class="mb-4 col-md-4" id="round'+rounds+'">'+
                  '<div class="card" style="margin-left: 4%;">'+
                    '<div class="card-header">Round '+rounds+'</div>'+
                      '<div class="card-body">'+
                        '<div class="input-group">'+
                          '<div class="ml-3 mb-4 col-lg-12">'+
                            '<label for="roundResult'+rounds+'" class="form-label">Round Result</label>'+
                              '<select class="form-select" name="roundResult'+rounds+'" id="roundResult'+rounds+'">'+
                                '<option value="win">Win</option>'+
                                '<option value="lose">Lose</option>'+
                                '<option value="draw">Draw</option>'+
                                '<option value="bye">Bye</option>'+
                              '</select>'+
                            '</div>'+
                          '</div>'+
                          '<div class="input-group">'+
                            '<div class="ml-3 mb-4 col-lg-12">'+
                              '<label for="oppDeck'+rounds+'" class="form-label">Opponent`s Deck</label>'+
                                  '<input type="text" class="form-control" id="oppDeck'+rounds+'" placeholder="Ex. Death`s Shadow" name="oppDeck'+rounds+'">'+
                              '</div>'+
                            '</div>'+
                            '<h5>Games Played</h5>'+
                              '<div id="games'+rounds+'" data-totalGames="1"></div>'+
                              '<div class="container text-center">'+
                                '<div class="col-lg-12">'+
                                  '<button class="btn btn-primary" id="addGames" type="button" onclick="addGame('+rounds+');">Add Games</button>'+
                                '</div>'+
                              '</div>'+

                          '</div>'+
                        '</div>'+
                      '</div>';
    $("#rounds").append(query);

    if(result == "win"){
      $('#roundResult'+rounds+' option[value="win"]').prop("selected", true);
    } else if(result == "draw") {
      $('#roundResult'+rounds+' option[value="draw"]').prop("selected", true);
    } else if(result == "lose"){
      $('#roundResult'+rounds+' option[value="lose"]').prop("selected", true);
    }
  }

  function removeGame(id,round){
    $('#games'+round).data('totalgames', parseInt($('#games'+round).data('totalgames')) - 1);
    $("#round"+round+" #game"+id).remove();
  }
</script>