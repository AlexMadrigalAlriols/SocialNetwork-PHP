<!DOCTYPE html>
<html lang="en">
<?php 
if(!isset($_SESSION["iduser"])){
    header("Location: /login");
}
require_once "cards/clases/Conexion.php";
$c=new conectar();
$conexion=$c->conexion();

    $num_per_page=12;

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
<div style="position:relative;">
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
            <h6><span class="fa fa-calendar mr-3"></span>Cards Filter</h6>
        </div>

        <div class="card-body">
            <div class="row px-4">
                <form>
                    <div class="input-group">
                        <div class="ml-3 col-lg-3" style="margin-right:1rem;">
                            <label for="name" class="form-label">Card Name</label>
                            <input type="text" class="form-control" id="name" placeholder="Ex. Lighting Bolt" name="name" value="<?php if(isset($_GET["name"])){ echo $_GET["name"]; } ?>">
                        </div>

                        <div class="col-lg-3" style="margin-right:1rem;">
                            <label for="info" class="form-label">Card Info</label>
                            <input type="text" class="form-control" id="info" name="info" placeholder="Ex. Foil" value="<?php if(isset($_GET["info"])){ echo $_GET["info"]; } ?>">
                        </div>

                        <div class="col-lg-3" style="margin-right:1rem;">
                            <label for="colors" class="form-label">Card Colors</label>
                            <select name="colors" id="colors" class="form-select">
                                <option value="all">All Colors</option>
                                <option value="R">Red</option>
                                <option value="W">White</option>
                                <option value="U">Blue</option>
                                <option value="B">Black</option>
                                <option value="G">Green</option>
                                <option value=" ">Colorless</option>
                            </select>
                        </div>
                    </div>

                    <div class="mb-3">
                        <button type="submit" class="btn btn-success" style="float:right;" id="searchFilter">Search</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div id="contenedor_carga">
        <div id="carga"></div>
    </div>
    <div class="searchedCollection" style="position: relative;" id="searchedCards"></div>
</div>
    <div class="container text-center d-none" id="cardsNoFound">
        <div class="card">
            <div class="card-body">
                <h1>No Cards Found</h1>
            </div>
        </div>
    </div>
    <div class="container text-center d-none" id="pager">
        <?php 
            
            $sql="select * from cards where user_id=".$_SESSION["iduser"]. " ";
            
            if(isset($_GET["name"]) && $_GET["name"] != ""){
                $name = $_GET["name"];
                $sql .= "AND card_name LIKE '%$name%' ";
            }

            if(isset($_GET["info"]) && $_GET["info"] != ""){
                $info = $_GET["info"];
                $sql .= "AND card_info LIKE '%$info%' ";
            }

            if(isset($_GET["colors"]) && $_GET["colors"] != "all"){
                $colors = $_GET["colors"];
                $sql .= "AND color_identity LIKE '%$colors%' ";
            }

            $rs_result=mysqli_query($conexion, $sql);
            $total_records=mysqli_num_rows($rs_result);
            $total_pages=ceil($total_records/$num_per_page);
            
            if($page>1)
            {
                echo "<a href='/cards?page=".($page - 1)."".(isset($name) ? "&name=".$name : "").(isset($info) ? "&info=".$info : "").(isset($colors) ? "&colors=".$colors : "")."'><button class='btn btn-primary' style='margin: 5px;'>Previous</button></a>" ;
            }

            for($i=1;$i<=$total_pages;$i++)
            {
                if($page == $i){
                    echo "<a href='/cards?page=".$i."".(isset($name) ? "&name=".$name : "").(isset($info) ? "&info=".$info : "").(isset($colors) ? "&colors=".$colors : "")."'><button class='btn btn-success' style='margin: 5px;'>".$i."</button></a>" ;
                } else {
                    echo "<a href='/cards?page=".$i."".(isset($name) ? "&name=".$name : "").(isset($info) ? "&info=".$info : "").(isset($colors) ? "&colors=".$colors : "")."'><button class='btn btn-primary' style='margin: 5px;'>".$i."</button></a>" ;
                }
                
            }

            if($i>$page && $total_pages != 1)
            {
                echo "<a href='/cards?page=".($page+1)."".(isset($name) ? "&name=".$name : "").(isset($info) ? "&info=".$info : "").(isset($colors) ? "&colors=".$colors : "")."'><button class='btn btn-primary' style='margin: 5px;'>Next</button></a>";
            }
        ?>
    </div>
    
</body>

<!-- Modals -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="card-name" style="color: black;">Undefined </h5><span id="card-set" style="color: black;"><b>&nbsp; </b></span>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <h6 style="color: black;">Remove Qty:</h6>
        <form>
            <input type="number" name="card_qty" class="form-control" min="1" id="qty_cards" value="1">
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-danger" id="deleteCard">Remove of Collection</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="modalAdd" tabindex="-1" aria-labelledby="modalAddLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="card-name-add" style="color: black;">Undefined </h5><span id="card-set-add" style="color: black;"><b>&nbsp; </b></span>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <h6 style="color: black;">Select Qty:</h6>
        <form>
            <input type="number" name="card_qty" class="form-control" min="1" id="qty_cards" value="1">
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-primary" id="addMoreCards">Add to Collection</button>
      </div>
    </div>
  </div>
</div>

</html>

<script>
    var cardId = "";
    var cardName = "";

    window.onload = function(){
        var contenedor = document.getElementById('contenedor_carga');
        setTimeout(() => {contenedor.style.visibility = 'hidden';
        contenedor.style.opacity = '0';
        document.body.style.overflowY= "visible"; contenedor.style.position = "absolute"}, 0);
    }

    $( document ).ready(function() {
        $("#collection").addClass('active');
        $("#pager").toggleClass("d-none");

        <?php if(isset($_GET["colors"])){ ?>
            $('#colors option[value="<?php echo $_GET["colors"]; ?>"]').prop("selected", true);
        <?php } ?>

        $(document).on("click", "#deleteCard", function () {
            if (confirm("You want to delete "+$("#qty_cards").val()+" "+cardName+"?")) {
                $.ajax({
                    url: '/removeCard',
                    type: 'POST',
                    async: false,
                    data: {cardId:cardId, cardQty: $("#qty_cards").val(), userId: <?php echo $_SESSION["iduser"] ?>},
                    success: function(data) {
                        window.location="/cards?success=remove";
                    }
                });
            }
        });

        $(document).on("click", "#addMoreCards", function () {
            $.ajax({
                url: '/addCardsCollection',
                type: 'POST',
                async: false,
                data: {cardId:cardId, cardName: cardName, cardQty: $("#qty_cards").val(), userId: <?php echo $_SESSION["iduser"] ?>},
                success: function(data) {
                    window.location="/cards?success=add";
                }
            });
        });

        //-------------------------- MODALS ----------------------------\\
        $(document).on("click", ".openDelModal", function () {
            cardId = $(this).data('id');
            cardName = $(this).data('name');
            qty = $(this).data('qty');
            cardSet = $(this).data('set');

            $('#qty_cards').attr("max", qty)
            $('#card-name').text(cardName);
            $('#card-set').html("<b> &nbsp; (" + cardSet + ") </b>");
        });

        $(document).on("click", ".openAddModal", function () {
            cardId = $(this).data('id');
            cardName = $(this).data('name');
            qty = $(this).data('qty');
            cardSet = $(this).data('set');

            $('#card-name-add').text(cardName);
            $('#card-set-add').html("<b> &nbsp; (" + cardSet + ") </b>");
        });

        updateCards();
    });

    function updateCards(){
        $.ajax({
            url: '/getCards',
            type: 'POST',
            async: false,
            data: {userId: <?php echo $_SESSION["iduser"]; ?>, startFrom: "<?php echo $start_from; ?>", numPerPage: "<?php echo $num_per_page; ?>"
                <?php if(isset($_GET["name"])) {?>, name: "<?php echo $_GET["name"]; ?>"
                <?php } if(isset($_GET["info"])){?>
                    ,info: "<?php echo $_GET["info"]; ?>"
                <?php } if(isset($_GET["colors"])){?>
                    ,colors: "<?php echo $_GET["colors"]; ?>"
                <?php } ?>},
            success: function(data) {
                cards = JSON.parse(data);
            }
        });
        
        cards.forEach(card => {
            $.ajax({
                url: '/getCards',
                type: 'POST',
                async: false,
                data: {cardId: card.Card.Id},
                success: function(data) {
                    uCard = JSON.parse(data);
                    var query = '<div class="card text-center deck-card" style="width: 18rem; display:inline-block;">'+
                                '<h5 class="card-header"><b>'+uCard[0].Card.Name+'</b></h5>'+
                                '<img src='+uCard[0].Card.Img+' class="card-img-top container" style="margin: 10px; width: 225px;">'+
                                '<hr style="margin-bottom: -5px;">'+
                                '<div class="card-body" style="float:left; text-align: left;">'+
                                    '<p class="card-text"><b>Qty: </b> '+card.Card.Qty+'</p>'+
                                    '<p class="card-text"><b>Aditional Info: </b> '+card.Card.Info+' </p>'+
                                    '<p class="card-text"><b>Price: </b> '+uCard[0].Card.Price+' €</p>'+
                                    '<p class="card-text"><b>Tix Price: </b> '+uCard[0].Card.tixPrice+' tix</p>'+
                                    '<div class="text-center container">'+
                                        '<button class="btn btn-success openAddModal" style="margin-right: 5px;" type="button" data-bs-toggle="modal" data-bs-target="#modalAdd" data-id="'+uCard[0].Card.Id+'" data-qty="'+card.Card.Qty+'" data-set="'+uCard[0].Card.Set+'" data-name="'+uCard[0].Card.Name+'">Add More</button>'+
                                        '<button class="btn btn-danger openDelModal" type="button" data-bs-toggle="modal" data-bs-target="#exampleModal" data-id="'+uCard[0].Card.Id+'" data-qty="'+card.Card.Qty+'" data-set="'+uCard[0].Card.Set+'" data-name="'+uCard[0].Card.Name+'">Remove Cards</button>'+
                                    '</div>'+
                                '</div>'+
                            '</div>';
                    $("#searchedCards").append(query);
                }
            });
        });

        if(cards.length <= 0) {
            $("#cardsNoFound").toggleClass("d-none");
        }
    }
</script>

<script src="/cards/assets/js/headerControler.js"></script>