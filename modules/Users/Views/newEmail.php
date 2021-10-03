<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    </head>
    <body>
        <p>Hello <?= esc($first_name)?> <?= esc($last_name)?></p>
        <a href="<?= base_url()?>/activate/<?= esc($email_code)?>">Click here to activate your account.</a>
    </body>
</html>