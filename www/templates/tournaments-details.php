<!DOCTYPE html>
<html lang="en">
<?php 
require_once "cards/clases/Conexion.php";
if(!isset($_SESSION["iduser"])){
    header("Location: /login");
}
$c=new conectar();
$conexion=$c->conexion();

  $num_per_page=05;

	if(isset($_GET["page"]))
	{
		$page=$_GET["page"];
	}
	else
	{
		$page=1;
	}

	$start_from=($page-1)*$num_per_page;
?>
<?php require_once('header.php'); ?>
<body id="body-pd" class="body-pd" style="overflow-x: hidden;">

    <?php require_once('navControlPanel.php') ?>
<div style="position: relative;">

<div class="card mb-3 filterBox">
        <div class="card-header">
            <h6><span class="fa fa-calendar mr-3"></span>Tournament Details</h6>
        </div>

        <div class="card-body">
            <div class="row px-4">
                <div class="col-md-7">
                    <h4 style="display: inline-block;">Friday Night Modern </h4><span style="display: inline-block;">&nbsp; <span id="tournament_date"></span></span></br>
                    <span><b>Site: </b> <span id="tournament_site"></span></span></br>
                    <span><b>Format: </b><span id="tournament_format"></span></span></br>
                    <span><b>Score: </b> <span id="tournament_score"></span></span></br>
                    <span><b>Deck: </b> <span id="tournament_deck"></span></span></br>
                    <span><b>Player: </b> <span id="tournament_user"></span></span>
                </div>

                <div class="col-md-5">
                    <div>
                        <button class="btn btn-primary mb-3" href="/tournaments" style="float:right;"><i class='bx bx-left-arrow-alt'></i> Tournaments Page</button></br>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="contenedor_carga">
        <div id="carga"></div>
    </div>
    <div class="rounds container mb-3" id="rounds"></div>

</div>
    
</body>

</html>

<script src="/cards/assets/js/headerControler.js"></script>

<script>
    var dark = true;
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
    
  window.onload = function(){
      var contenedor = document.getElementById('contenedor_carga');
      setTimeout(() => {contenedor.style.visibility = 'hidden';
      contenedor.style.opacity = '0';
      document.body.style.overflowY= "visible"; contenedor.style.position = "absolute"}, 0);
  }

$( document ).ready(function() {
    updateRounds(1);
    $("#pager").toggleClass("d-none");

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


});

function updateRounds(round){
    $.ajax({
        url: '/procesos/tournaments/getTournaments',
        type: 'POST',
        data: {tournament_id: <?php echo $id_tournament; ?>},
        success: function(data) {
            tournament = JSON.parse(data);
            
            $("#tournament_site").append(tournament[0].Tournament.Site);
            $("#tournament_format").append(tournament[0].Tournament.Format);
            $("#tournament_score").append(tournament[0].Tournament.Score);
            $("#tournament_deck").append(tournament[0].Tournament.Deck);
            $("#tournament_user").append(tournament[0].Tournament.User);
            $("#tournament_date").append(tournament[0].Tournament.Date);

            $.ajax({
                url: '/procesos/tournaments/getRounds',
                type: 'POST',
                data: {tournament_id: <?php echo $id_tournament; ?>},
                success: function(data) {
                    rounds = JSON.parse(data);
                    var i = 0;
                    rounds.forEach(round => {
                        i++;
                        var query = '<div class="card mb-3">'+
                            '<div class="card-header">'+
                                '<h5><span class="fa fa-calendar mr-3"></span>Round '+i+'</h5>'+
                            '</div>'+

                            '<div class="card-body">'+
                                '<div class="row px-4">'+
                                    '<div class="col-md-7">'+
                                        '<span><b>Opponent Deck:</b> '+round.Round.Opp_Deck+'</span></br>'+
                                        '<span><b>Result:</b> '+round.Round.Status+'</span></br>'+
                                        '</br><h5><b>Game Info:</b></h5>'+
                                    '</div>'+
                                '</div>'+
                            '</div>'+
                            '<div class="row">'+
                                '<div id="games'+i+'" style="margin-top: -2%;"></div>'+
                            '</div>'+
                        '</div>';

                        $("#rounds").append(query);
                        updateGames(i, round.Round.Id);
                    });
                }
            });
        }
    });
}

function updateGames(round, round_id){

    $.ajax({
        url: '/procesos/tournaments/getGames',
        type: 'POST',
        data: {round_id: round_id},
        success: function(data) {
            games = JSON.parse(data);
            var i = 0;
            games.forEach(game => {
                i++;
                var query = '<div class="col-md-4" style="display: inline-block;">'+
                    '<div class="card m-3">'+
                        '<div class="card-header">'+
                            '<h5><span class="fa fa-calendar mr-3"></span>Game '+i+'</h5>'+
                        '</div>'+
                        '<div class="card-body">'+
                            '<div class="col-md-12">'+
                                '<span><b>Result:</b> Win</span></br>'+
                                '<span><b>Game Info:</b></br>'+game.Game.Game_info+'</span>'+
                            '</div>'+
                        '</div>'+
                    '</div>'+
                '</div>';

                $("#games"+round).append(query);
            });

        }
    });

    
}
</script>