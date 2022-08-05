<!DOCTYPE html>
<html lang="en">
<?php 
if(!isset($_SESSION["iduser"])){
    header("Location: /login");
}
require_once "cards/clases/Conexion.php";
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
<?php if(isset($_GET["success"])) { ?>
    <?php if($_GET["success"] == "add") { ?>
        <svg xmlns="http://www.w3.org/2000/svg" style="display: none;">
        <symbol id="check-circle-fill" fill="currentColor" viewBox="0 0 16 16">
            <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"/>
        </symbol>
        </svg>
        <div class="alert alert-success alert-dismissible"  style="margin-top: 5rem; margin-bottom: -5rem;" role="alert"><svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Success:"><use xlink:href="#check-circle-fill"/></svg> Success Added To Collection <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>
    <?php } ?>
    <?php if($_GET["success"] == "remove") { ?>
        <svg xmlns="http://www.w3.org/2000/svg" style="display: none;">
        <symbol id="check-circle-fill" fill="currentColor" viewBox="0 0 16 16">
            <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"/>
        </symbol>
        </svg>
        <div class="alert alert-success alert-dismissible"  style="margin-top: 5rem; margin-bottom: -5rem;" role="alert"><svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Success:"><use xlink:href="#check-circle-fill"/></svg> Success Removed Of Collection <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>
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
                        <div class="ml-3 col-lg-3 mt-2" style="margin-right: 1rem;">
                            <label for="name" class="form-label">Deck Name</label>
                            <input type="text" class="form-control" id="name" placeholder="Ex. Death's Shadow" name="name" value="<?php if(isset($_GET["name"])){ echo $_GET["name"]; } ?>">
                        </div>
                        <div class="ml-3 col-lg-4 mt-2">
                            <label for="format" class="form-label">Format</label>
                            <select class="form-select" id="format" name="format">
                                <option value="" selected>All formats</option>
                                <option value="Modern">Modern</option>
                                <option value="Standard">Standard</option>
                                <option value="Pioneer">Pioneer</option>
                                <option value="Historic">Historic</option>
                                <option value="Commander">Commander</option>
                            </select>
                        </div>
                    </div>
                    

                    <div class="mb-3">
                        <button type="submit" class="btn btn-success" style="float:right; margin: 5px;" id="searchFilter">Search</button>
                        <a href="/decks/new-deck"><button type="button" class="btn btn-secondary" style="float:right; margin: 5px;" id="searchFilter">New Deck</button></a>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div id="contenedor_carga">
        <div id="carga"></div>
    </div>
    <div class="searchedDecks" id="searchedCards"></div>
    
    <div class="container text-center d-none" id="deckNoFound">
        <div class="card">
            <div class="card-body">
                <h1>No Decks Found</h1>
            </div>
        </div>
    </div>
    <div class="container text-center d-none" id="pager">
        <?php 
        
            $sql="select * from decks where user_id=".$_SESSION["iduser"]. " ";
            
            if(isset($_GET["name"]) && $_GET["name"] != ""){
                $name = $_GET["name"];
                $sql .= "AND name LIKE '%$name%' ";
            }

            if(isset($_GET["format"]) && $_GET["format"] != ""){
                $format = $_GET["format"];
                $sql .= "AND format LIKE '%$format%' ";
            }

            $rs_result=mysqli_query($conexion, $sql);
            $total_records=mysqli_num_rows($rs_result);
            $total_pages=ceil($total_records/$num_per_page);

            if($page>1)
            {
                echo "<a href='/decks?page=".($page - 1)."".(isset($name) ? "&name=".$name : "").(isset($format) ? "&format=".$format : "")."'><button class='btn btn-primary' style='margin: 5px;'>Previous</button></a>" ;
            }

            for($i=1;$i<=$total_pages;$i++)
            {
                if($page == $i){
                    echo "<a href='/decks?page=".$i."".(isset($name) ? "&name=".$name : "").(isset($format) ? "&format=".$format : "")."'><button class='btn btn-success' style='margin: 5px;'>".$i."</button></a>" ;
                } else {
                    echo "<a href='/decks?page=".$i."".(isset($name) ? "&name=".$name : "").(isset($format) ? "&format=".$format : "")."'><button class='btn btn-primary' style='margin: 5px;'>".$i."</button></a>" ;
                }
                
            }

            if($i>$page && $total_pages != 1)
            {
                echo "<a href='/decks?page=".($page+1)."".(isset($name) ? "&name=".$name : "").(isset($format) ? "&format=".$format : "")."'><button class='btn btn-primary' style='margin: 5px;'>Next</button></a>";
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
    $("#pager").toggleClass("d-none");
    updateDecks();

    <?php if(isset($_GET["format"])){ ?>
            $('#format option[value="<?php echo $_GET["format"]; ?>"]').prop("selected", true);
    <?php } ?>

    $('.btnDeleteDeck').click(function() {
      $.ajax({
        url: '/procesos/decks/deleteDeck',
        type: 'POST',
        data: {deckId: $(this).data("id")},
        success: function(data) {
          window.location="/decks?success=remove";
        }
      });
    });

    $("#decks").addClass('active');
});

function updateDecks(){
        $.ajax({
            url: '/procesos/decks/getDecks',
            type: 'POST',
            async: false,
            data: {userId: <?php echo $_SESSION["iduser"]; ?>, startFrom: "<?php echo $start_from; ?>", numPerPage: "<?php echo $num_per_page; ?>"
                <?php if(isset($_GET["name"])) {?>, name: "<?php echo $_GET["name"]; ?>"
                <?php } if(isset($_GET["format"])){?>
                    ,format: "<?php echo $_GET["format"]; ?>"
                <?php } ?>},
            success: function(data) {
                decks = JSON.parse(data);
            }
        });
        
        decks.forEach(deck => {

          var query = '<div class="card text-center deck-card" style="width: 18rem; display: inline-block;">' +
                    '<h5 class="card-header"><b>'+deck.Deck.Name+'</b></h5>' +
                    '<img src="'+deck.Deck.Img+'" class="card-img-top" style="width: 100%; margin: 0; height: 175px;">'+
                    '<div class="card-body" style="float:left; text-align: left;">'+
                      '<p class="card-text"><b>Format:</b> '+deck.Deck.Format+'</p>'+
                      '<p class="card-text"><b>Colors:</b> '+deck.Deck.Colors+'</p>'+
                      '<p class="card-text"><b>Actual Price:</b> '+deck.Deck.TotalPrice+' €</p>'+
                      '<div class="text-center">'+
                        '<a href="/deck/'+deck.Deck.Id+'"><button class="btn btn-primary" style="margin-right: 6px;">View Deck</button></a>'+
                        '<a href="/decks/edit_deck/'+deck.Deck.Id+'"><button class="btn btn-success" style="margin-right: 6px;">Edit Deck</button></a>'+
                        '<button class="btn btn-danger btnDeleteDeck" data-id="'+deck.Deck.Id+'"><i class="bx bxs-trash"></i></button>'+
                      '</div>'+
                  '</div>'+
                '</div>'+
              '</div>';
          $("#searchedCards").append(query);
        });

        if(decks.length <= 0) {
            $("#deckNoFound").toggleClass("d-none");
        }
    }
</script>