<!DOCTYPE html>
<html lang="en">
<?php 
if(!isset($_SESSION["iduser"])){
    header("Location: /login");
}
require_once "cards/clases/Conexion.php";
$c=new conectar();
$conexion=$c->conexion();

  $num_per_page=10;

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
<?php if(isset($_GET["success"])) { ?>
    <?php if($_GET["success"] == "add") { ?>
        <svg xmlns="http://www.w3.org/2000/svg" style="display: none;">
        <symbol id="check-circle-fill" fill="currentColor" viewBox="0 0 16 16">
            <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"/>
        </symbol>
        </svg>
        <div class="alert alert-success alert-dismissible"  style="margin-top: 5rem; margin-bottom: -5rem;" role="alert"><svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Success:"><use xlink:href="#check-circle-fill"/></svg> Success Added To Tournaments <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>
    <?php } ?>
    <?php if($_GET["success"] == "remove") { ?>
        <svg xmlns="http://www.w3.org/2000/svg" style="display: none;">
        <symbol id="check-circle-fill" fill="currentColor" viewBox="0 0 16 16">
            <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"/>
        </symbol>
        </svg>
        <div class="alert alert-success alert-dismissible"  style="margin-top: 5rem; margin-bottom: -5rem;" role="alert"><svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Success:"><use xlink:href="#check-circle-fill"/></svg> Success Removed Of Tournaments <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>
    <?php } ?>
<?php } ?>
<div class="card mb-3 filterBox">
        <div class="card-header">
            <h6><span class="fa fa-calendar mr-3"></span>Decks Filter</h6>
        </div>

        <div class="card-body">
            <div class="row px-4">
                <form>
                    <div class="input-group">
                        <div class="mr-3 col-md-3" style="margin-right: 1rem;">
                            <label for="name" class="form-label">Tournament Name</label>
                            <input type="text" class="form-control" id="name" placeholder="Ex. Saturday Modern" name="name" value="<?php if(isset($_GET["name"])){ echo $_GET["name"]; } ?>">
                        </div>

                        <div class="ml-3 col-md-3" style="margin-right: 1rem;">
                            <label for="location" class="form-label">Location</label>
                            <input type="text" class="form-control" id="location" placeholder="Ex. Ubication/Shop Name" name="location" value="<?php if(isset($_GET["location"])){ echo $_GET["location"]; } ?>">
                        </div>

                        <div class="ml-3 col-md-3" style="margin-right: 1rem; margin-bottom: 20px;">
                            <label for="date" class="form-label">Min Date</label>
                            <input type="date" class="form-control" id="date" name="date" value="<?php if(isset($_GET["date"])){ echo $_GET["date"]; } ?>">
                        </div>
                    </div>

                    <div class="mb-3">
                        <button type="submit" class="btn btn-success" style="float:right; margin: 5px;" id="searchFilter">Search</button>
                        <a href="/tournaments/new-tournament"><button type="button" class="btn btn-secondary" style="float:right; margin: 5px;" id="searchFilter">New Tournament</button></a>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- <div id="contenedor_carga"> 
        <div id="carga"></div>
    </div>-->
    <div class="searchedTournaments container mb-3" id="searchedCards"></div>

    <div class="container text-center d-none" id="tournamentNotFound">
        <div class="card">
            <div class="card-body">
                <h1>No Tournaments Found</h1>
            </div>
        </div>
    </div>

    <div class="container text-center d-none" id="pager">
        <?php 
        
            $sql="select * from Tournaments where user_id=".$_SESSION['iduser']." ";
            

            if(isset($_GET["name"]) && $_GET["name"] != ""){
                $name = $_GET["name"];
                $sql .= "AND tournament_name LIKE '%$name%' ";
            }

            if(isset($_GET["location"]) && $_GET["location"] != ""){
                $location = $_GET["location"];
                $sql .= "AND tournament_site LIKE '%$location%' ";
            }

            if(isset($_GET["date"]) && $_GET["date"] != ""){
                $date = $_GET["date"];
                $sql .= "AND tournament_date > '$date' ";
            }

            if(isset($_GET["deck_id"]) && $_GET["deck_id"] != ""){
                $deck_id = $_GET["deck_id"];
                $sql .= "AND tournament_used_deck > '$deck_id' ";
            }

            $rs_result=mysqli_query($conexion, $sql);
            $total_records=mysqli_num_rows($rs_result);
            $total_pages=ceil($total_records/$num_per_page);

            if($page>1)
            {
                echo "<a href='/tournaments?page=".($page - 1)."".(isset($name) ? "&name=".$name : "").(isset($location) ? "&location=".$location : "").(isset($date) ? "&date=".$date : "")."'><button class='btn btn-primary' style='margin: 5px;'>Previous</button></a>" ;
            }

            for($i=1;$i<=$total_pages;$i++)
            {
                if($page == $i){
                    echo "<a href='/tournaments?page=".$i."".(isset($name) ? "&name=".$name : "").(isset($location) ? "&location=".$location : "").(isset($date) ? "&date=".$date : "")."'><button class='btn btn-success' style='margin: 5px;'>".$i."</button></a>" ;
                } else {
                    echo "<a href='/tournaments?page=".$i."".(isset($name) ? "&name=".$name : "").(isset($location) ? "&location=".$location : "").(isset($date) ? "&date=".$date : "")."'><button class='btn btn-primary' style='margin: 5px;'>".$i."</button></a>" ;
                }
                
            }

            if($i>$page && $total_pages != 1)
            {
                echo "<a href='/tournaments?page=".($page+1)."".(isset($name) ? "&name=".$name : "").(isset($location) ? "&location=".$location : "").(isset($date) ? "&date=".$date : "")."'><button class='btn btn-primary' style='margin: 5px;'>Next</button></a>";
            }
            
        ?>
    </div>
</div>
    
</body>

</html>

<script src="cards/assets/js/headerControler.js"></script>

<script>
    
  window.onload = function(){
      var contenedor = document.getElementById('contenedor_carga');
      setTimeout(() => {contenedor.style.visibility = 'hidden';
      contenedor.style.opacity = '0';
      document.body.style.overflowY= "visible"; contenedor.style.position = "absolute"}, 0);
  }

$( document ).ready(function() {
    updateTournaments();
    $("#pager").toggleClass("d-none");

    $("#tournaments").addClass('active');


});

function updateTournaments(){
        $.ajax({
            url: '/procesos/tournaments/getTournaments',
            type: 'POST',
            async: false,
            data: {userId: <?php echo $_SESSION["iduser"]; ?>, startFrom: "<?php echo $start_from; ?>", numPerPage: "<?php echo $num_per_page; ?>"
                <?php if(isset($_GET["name"])) {?>, name: "<?php echo $_GET["name"]; ?>"
                <?php } if(isset($_GET["location"])){?>
                    ,location: "<?php echo $_GET["location"]; ?>"
                <?php } if(isset($_GET["date"])){ ?>
                    ,date: "<?php echo $_GET["date"]; ?>"
                <?php } if(isset($_GET["deck_id"]) && $_GET["deck_id"] != ""){?>
                    ,deck_id: <?=$_GET["deck_id"];?>
                <?php } ?>
            },
            success: function(data) {
                tournaments = JSON.parse(data);
            }
        });

        tournaments.forEach(tournament => {
            var score = tournament.Tournament.Score.split("-");
            var rounds = parseInt(score[0]) + parseInt(score[1]) + parseInt(score[2]);
            var color = "green";

            if((parseInt(score[0])/rounds) < 0.55){
                var color = "red";
            }
            
            var query = '<div class="card mt-4" style="width: 100%;">'+
            '<div class="card-body">'+
                '<div class="col-md-1 align-middle" style="display: inline-block;">'+
                    '<input type="checkbox" style="margin: 15px;">'+
                '</div>'+
                '<div class="col-md-3 align-middle" style="display: inline-block;">'+
                    '<h6>'+tournament.Tournament.Name+'</h6>'+
                    '<a style="color: '+color+';">Score '+tournament.Tournament.Score+'</a>'+
                '</div>'+
                '<div class="vr align-middle"></div>'+
                '<div class="col-md-5 container align-middle" style="display: inline-block;">'+
                    '<a><b>Location:</b> '+tournament.Tournament.Site+'</a></br>'+
                    '<a><b>Deck:</b> '+tournament.Tournament.Deck+' - '+tournament.Tournament.Format+'</a>'+'<small href="#"><b> Date: </b>'+tournament.Tournament.Date+' </small>'+
                '</div>'+
                '<div class="vr align-middle"></div>'+
                '<div class="col-md-2 align-middle text-center" style="display: inline-block; float:right;"></br>'+
                    '<a href="/tournaments/view-details/'+tournament.Tournament.Id+'" class="btn btn-primary ml-auto">View Details</a>'+
                    '<a href="/tournaments/edit-tournament/'+tournament.Tournament.Id+'" class="btn btn-secondary" style="margin-left: 1rem;"><i class="bx bxs-edit"></i></a>'+
                '</div>'+
            '</div>'+ 
        '</div>';

        $("#searchedCards").append(query);
        });

        if(tournaments.length <= 0) {
            $("#tournamentNotFound").toggleClass("d-none");
        }
    }
</script>