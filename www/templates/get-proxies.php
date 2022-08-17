<!DOCTYPE html>
<html lang="en">
<?php require_once("cards/www/controllers/get-proxies.php"); ?>
<body style="margin: 0px;">
    <?php foreach ($cards as $idx => $img) { ?>
        <img src="<?=$img;?>" alt="" width="235px" height="302px">
    <?php } ?>
</body>
<script>
    window.print();
</script>
</html>