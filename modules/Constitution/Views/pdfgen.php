<!DOCTYPE html>
<html lang="en">
 
<head>
    <meta charset="utf-8">
    <title>Welcome to CodeIgniter</title>
</head>
 
<body>
    <div id="container">
        <?php foreach($consti as $const):?>
            <h1 style="text-align: center;"><?= esc($const['area'])?></h1>
            <div id="body">
                <?= esc($const['content'], 'raw')?>
            </div>
        <?php endforeach;?>
    </div>
</body>
 
</html>