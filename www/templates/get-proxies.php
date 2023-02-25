<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MTGCollectioner Proxies</title>
    <style>
        @media print {
        @page { margin: 0; }
        body { margin: 0; }
        }
    </style>
</head>
<?php require_once("cards/www/controllers/get-proxies.php"); ?>
<body class="m-0">
    <?php foreach ($cards as $idx => $img) { ?>
        <img src="<?=$img;?>" alt="proxy" width="235px" height="302px">
    <?php } ?>
</body>
<script>
    window.print();
</script>
<?php require_once('cards/www/templates/_footer.php'); ?>
</html>