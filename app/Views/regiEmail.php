<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    </head>
    <body>
        <p>Hello <?= esc($first_name)?> <?= esc($last_name)?></p>
        <p>These are the steps to pay for your membership fee:</p>
        <br>
        <?= esc($paymentMethod['steps'], 'raw')?>
    </body>
</html>