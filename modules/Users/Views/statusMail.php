<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    </head>
    <body>
        <p>Hello <?= esc($first_name)?> <?= esc($last_name)?></p>
        <p>Your status in FEAMS website has been changed to: <?= esc($status)?></p>
    </body>
</html>