<!DOCTYPE html>
<html>
    <head>
        <title>Nicht schon wieder!</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" type="text/css" href="css/main.css">
    </head>
    <body>
        <div class="gray">
            <div>
                <?php echo $sex ?> hat es schon <span class="big"><?php echo $count ?>x</span> getan!
            </div>
            <div class="again">
                <a href="<?php echo $conf['baseurl'].$page ?>/inc">Schon wieder!</a><br>
            </div>
            <div class="last">
                Das letzte Mal am <?php echo date("d.m.Y", $last) ?> um <?php echo date("H:i:s", $last) ?>
            </div>
        </div>
    </body>
</html>
