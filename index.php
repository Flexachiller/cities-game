<?php

use App\Game;

require_once("vendor/autoload.php");


if(isset($_POST['submit']))
{
    $game = new Game();
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form method="post">
        <label>Слово:</label>
        <label><?php if(isset($game)){ echo $game->all_cities[array_key_last($game->all_cities)]; }; ?></label>
        <input type="text" name="city">
        <br><br><br>
        <input type="submit" name="submit" value="Отправить" >  
    </form>
</body>
</html>