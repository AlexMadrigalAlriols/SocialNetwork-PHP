<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CollectionSaver Proxies</title>
</head>
<?php require_once("cards/www/controllers/get-proxies.php"); ?>
<body class="m-0">
    <?php foreach ($cards as $idx => $img) { ?>
        <img src="<?=$img;?>" alt="" width="235px" height="302px">
    <?php } ?>
</body>
<script>
    window.print();
</script>
</html>