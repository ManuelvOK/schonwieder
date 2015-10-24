<!DOCTYPE html>
<html>
    <head>
        <title>Nicht schon wieder!</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" type="text/css" href="css/main.css">
    </head>
    <body>
        <div class="grey">
            Er hat es schon <span class="big"><?php echo $count ?>x</span> getan!<br>
            <a href="<?php echo $conf['baseurl'].$page ?>/inc">Schon wieder!</a>
        </div>
    </body>
</html>
