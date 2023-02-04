<!DOCTYPE html>
<?php
    require_once("cards/framework/globalController.php");
    $user = &fwUser::getInstance();
    $user_details = userService::getUserDetails($user->get("id_user"));
    $shop_config = json_decode($user_details["shop_config"], true);
    $primary_color = (isset($_GET["pcolor"]) && $_GET["pcolor"] != "" ? $_GET["pcolor"] : "#55566a");
    $secondary_color = (isset($_GET["scolor"]) && $_GET["scolor"] != "" ? $_GET["scolor"] : "#ffffff");

    $month = (isset($_GET["month"]) ? $_GET["month"] : date('m'));
    $year = (isset($_GET["year"]) ? $_GET["year"] : date('Y'));
    $calendar_date = $year. "-". $month . "-01";

    $message = (isset($_GET["message"]) ? $_GET["message"] : "");
    
    $calendar = new fwCalendar($calendar_date);
    $tournaments = tournamentService::getAllTournamentsByShop($user->get("id_user"));
    foreach ($tournaments as $idx => $tournament) {
        $calendar->add_event($tournament["format"].'</br>'.date_format(date_create($tournament["start_date"]), 'H:i').'</br>'.$tournament["tournament_price"].'€', date_format(date_create($tournament["start_date"]), 'Y-m-d'), 1, $tournament["format"]);
    }
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CollectionSaver Imager</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Work+Sans:wght@100;300;400;500;600;700;900&display=swap" rel="stylesheet">
</head>
<style>

    #my-node {
        width: 1280px !important; 
        height: 720px !important; 
        font-family: 'Work Sans', sans-serif !important;
    }

    .calendar {
        flex-flow: column;
    }
    .calendar .header .month-year {
        font-size: 20px;
        font-weight: bold;
        color: black;
        padding: 20px 0;
        margin-left: 1rem !important;
    }
    .calendar .days {
        display: flex;
        flex-flow: wrap;
    }
    .calendar .days .day_name {
        width: calc(100% / 7);
        border-right: 1px solid <?=$secondary_color;?>;
        border-top: 1px solid <?=$secondary_color;?>;
        padding: 20px;
        text-transform: uppercase;
        font-size: 12px;
        font-weight: bold;
        color: <?=$secondary_color;?>;
        color: <?=$secondary_color;?>;
        background-color: <?=$primary_color;?>;
    }
    .calendar .days .day_name:nth-child(7) {
        border-top: 1px solid <?=$secondary_color;?>;
        border-right: none;
    }
    .calendar .days .day_num {
        display: flex;
        flex-flow: column;
        width: calc(100% / 7);
        border-right: 1px solid #e6e9ea;
        border-bottom: 1px solid #e6e9ea;
        padding: 15px;
        font-weight: bold;
        color: #7c878d;
        min-height: 100px;
    }
    .calendar .days .day_num span {
        display: inline-flex;
        width: 30px;
        font-size: 14px;
    }
    .calendar .days .day_num .event {
        margin-top: 10px;
        font-weight: 500;
        font-size: 14px;
        padding: 3px 6px;
        border-radius: 4px;
        background-color: #f7c30d;
        color: #fff;
        word-wrap: break-word;
    }
    .calendar .days .day_num .event.Modern {
        background-color: #51ce57;
    }
    .calendar .days .day_num .event.Pioneer {
        background-color: #518fce;
    }
    .calendar .days .day_num .event.Standard {
        background-color: #ce5151;
    }
    .calendar .days .day_num .event.Pauper {
        background-color: orange;
    }
    .calendar .days .day_num .event.Historic {
        background-color: BlueViolet;
    }
    .calendar .days .day_num .event.Alchemy {
        background-color: DeepPink;
    }
    .calendar .days .day_num:nth-child(7n+1) {
        border-left: 1px solid #e6e9ea;
    }

    .calendar .days .day_num.ignore {
        background-color: #fdfdfd;
        color: #ced2d4;
        cursor: inherit;
    }
    .calendar .days .day_num.selected {
        background-color: #f1f2f3;
        cursor: inherit;
    }

    * {
        box-sizing: border-box;
        font-family: -apple-system, BlinkMacSystemFont, "segoe ui", roboto, oxygen, ubuntu, cantarell, "fira sans", "droid sans", "helvetica neue", Arial, sans-serif;
        font-size: 16px;
        -webkit-font-smoothing: antialiased;
        -moz-osx-font-smoothing: grayscale;
        margin: 0 !important;
    }

    .content {
        width: 800px;
        margin: 0 auto;
    }

    .shop-logo {
        display: inline-block !important;
        width: 250px;
    }

    table {
        background-color: <?=$primary_color?>;
    }
    
    table tr th {
        width: 50%;
    }

    table tr th:nth-child(1) {
        border-right: 1px solid <?=$secondary_color;?>;
    }

    .month-name {
        font-size: 28px;
        color: <?=$secondary_color?>;
    }

    .message {
        width: 100%; 
        background-color: <?= $primary_color; ?>;; 
        text-align: center;
        color: <?= $secondary_color; ?>;
        padding: 0.8rem;
        font-size: 20px;
        font-weight: bold;
    }
</style>
<body>
        <div class="content" id="my-node">
            <div>
                <table width="100%">
                    <tr>
                        <th><h1 class="month-name"><?=$user->i18n("month.".$month);?> <?=$year;?></h1></th>
                        <th>                        
                            <?php if(isset($shop_config["shop_img"]) && $shop_config["shop_img"] != "") { ?>
                                <img src="/<?=$shop_config["shop_img"];?>" alt="" class="shop-logo">
                            <?php } ?>
                        </th>
                    </tr>
                </table>
            </div>

            <?=$calendar?>
            <?php if($message != "") { ?>
                <div class="message">
                    <?=$message;?>
                </div>
            <?php } ?>
		</div>
</body>
<script src="/cards/assets/vendor/htmlToImage/dom-to-image.js"></script>
<script>
domtoimage.toJpeg(document.getElementById('my-node'), { quality: 0.95, bgcolor: "#FFFFFF" })
    .then(function (dataUrl) {
        var link = document.createElement('a');
        link.download = 'tournament-image.jpeg';
        link.href = dataUrl;
        link.click();

        var link2 = document.createElement('a');
        link2.href = '/tournaments/0';
        link2.click();
    });
</script>
<?php require_once('cards/www/templates/_footer.php'); ?>
</html>