<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Custom styles for this template-->
    <link href="/cards/assets/css/sb-admin-2.css" rel="stylesheet">
</head>
<?php 
if(!isset($_SESSION["iduser"])){
    header("Location: /login");
}

require_once('header.php'); 
require_once "cards/framework/autoload/clases/Conexion.php";
$c=new conectar();
$conexion=$c->conexion();

$sql= "select * from cards where user_id=".$_SESSION["iduser"];

$rs_result=mysqli_query($conexion, $sql);
$cards = mysqli_num_rows($rs_result);

$sql="select * from decks where user_id=".$_SESSION["iduser"];

$rs_result=mysqli_query($conexion, $sql);
$decks = mysqli_num_rows($rs_result);

$sql="select * from Tournaments where user_id=".$_SESSION['iduser']." AND tournament_score LIKE '%0-0' OR tournament_score LIKE '%0-1'";
$rs_result=mysqli_query($conexion, $sql);
$tournamentsWin = mysqli_num_rows($rs_result);

$sql="select * from Tournaments where user_id=".$_SESSION['iduser'];
$rs_result=mysqli_query($conexion, $sql);
$tmpTournaments = mysqli_num_rows($rs_result);

$winrateTournaments = ($tmpTournaments == 0 ?  0 : number_format(($tournamentsWin * 100) / $tmpTournaments, 2));
?>
<body id="body-pd" class="body-pd" style="overflow-x: hidden;">

    <?php require_once('navControlPanel.php') ?>
<div style="position:relative;">
<?php if(isset($_GET["success"])) { ?>
    <?php if($_GET["success"] == "verification") { ?>
        <svg xmlns="http://www.w3.org/2000/svg" style="display: none;">
        <symbol id="check-circle-fill" fill="currentColor" viewBox="0 0 16 16">
            <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"/>
        </symbol>
        </svg>
        <div class="alert alert-success alert-dismissible"  style="margin-top: 5rem; margin-bottom: -5rem;" role="alert"><svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Success:"><use xlink:href="#check-circle-fill"/></svg> Success Verified Your Account! <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>
    <?php } ?>
    <?php if($_GET["success"] == "error") { ?>
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-exclamation-triangle-fill flex-shrink-0 me-2" viewBox="0 0 16 16" role="img" aria-label="Warning:">
            <path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/>
        </svg>
        <svg xmlns="http://www.w3.org/2000/svg" style="display: none;">
        <symbol id="danger-circle-fill" fill="currentColor" viewBox="0 0 16 16">
        <path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/>
        </symbol>
        </svg>
        <div class="alert alert-danger alert-dismissible"  style="margin-top: 5rem; margin-bottom: -5rem;" role="alert"><svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Warning:"><use xlink:href="#danger-circle-fill"/></svg> Error on verificate your account. Contact Us.<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>
    <?php } ?>
<?php } ?>
<!-- Begin Page Content -->
<div class="container-fluid filterBox">

<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 mt-4">Dashboard</h1>
</div>

<!-- Content Row -->
<div class="row">

    <!-- Earnings (Monthly) Card Example -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                            Cards On Collection</div>
                        <div class="h5 mb-0 font-weight-bold"><?= $cards; ?></div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-calendar fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Earnings (Monthly) Card Example -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-success shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                            Decks On Collection</div>
                        <div class="h5 mb-0 font-weight-bold"><?= $decks; ?></div>
                    </div>
                    <div class="col-auto">
                        
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Earnings (Monthly) Card Example -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-info shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                            Tournaments Won</div>
                        <div class="h5 mb-0 font-weight-bold"><?=$tournamentsWin;?></div>
                    </div>
                    <div class="col-auto">
                        
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Pending Requests Card Example -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-warning shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                            Tournament Winrate</div>
                        <div class="h5 mb-0 font-weight-bold"><?=$winrateTournaments;?> %</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-comments fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Content Row -->

<div class="row">
    <!-- Pie Chart -->
    <div class="col-xl-5 col-lg-6">
        <div class="card shadow mb-4">
            <!-- Card Header - Dropdown -->
            <div
                class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary"><i class='bx bxs-bell'></i> Notifications</h6>
            </div>
            <!-- Card Body -->
            <div class="card-body">
                <div class="card mb-2">
                    <div class="card-body">
                        <a class="d-flex align-items-center" href="#">
                            <div class="mr-3">
                                <div class="icon-circle bg-primary">
                                    <i class='bx bxs-file text-white' ></i>
                                </div>
                            </div>
                            <div>
                                <div class="small">December 14, 2022</div>
                                <h6>A new monthly report is ready to download!</h6>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        <a class="d-flex align-items-center" href="#">
                            <div class="mr-3">
                                <div class="icon-circle bg-success">
                                    <i class='bx bxs-file text-white' ></i>
                                </div>
                            </div>
                            <div>
                                <div class="small">December 14, 2022</div>
                                <h6>A new monthly report is ready to download!</h6>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Area Chart -->
    <div class="col-xl-7 col-lg-6">
        <div class="card shadow mb-4">
            <!-- Card Header - Dropdown -->
            <div
                class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Collection Earnings</h6>
            </div>
            <!-- Card Body -->
            <div class="card-body">
                <div class="chart-area">
                    <canvas id="myAreaChart"></canvas>
                </div>
            </div>
        </div>
    </div>

</div>

</div>
<!-- End of Main Content -->
<!-- Custom scripts for all pages-->
<script src="/cards/assets/js/sb-admin-2.js"></script>
<script src="/cards/assets/vendor/chart.js/Chart.min.js"></script>
<script src="/cards/assets/demo/chart-area-demo.js"></script>
<script src="/cards/assets/demo/chart-pie-demo.js"></script>
<script src="/cards/assets/js/headerControler.js"></script>

</html>

<script>
    $( document ).ready(function() {
        $.ajax({
            url: '/procesos/cards/getCardsPerMonth',
            type: 'POST',
            async: false,
            data: {userid: <?= $_SESSION["iduser"]; ?>},
            success: function(data) {
                allMonths = JSON.parse(data);
                createChar(allMonths.jan,allMonths.feb,allMonths.mar,allMonths.apr,allMonths.may,allMonths.jun,
                allMonths.jul,allMonths.aug,allMonths.sep,allMonths.oct,allMonths.nov,allMonths.dec);
            }
        });

        <?php if(isset($id_verification) && $id_verification != ""){ ?>
            $.ajax({
                url: '/procesos/users/mail_verification',
                type: 'POST',
                async: false,
                data: {id_verification: "<?= $id_verification; ?>"},
                success: function(data) {
                    if(data == 1){
                        window.location="/dashboard?success=verification";
                    } else {
                        window.location="/dashboard?success=error";
                    }
                    
                }
            });
        <?php } ?>
        $("#dashboard").addClass('active');
    });
</script>