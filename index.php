<?php 
require_once("src/Logic.php");

if(isset($_POST['submit']))
{
    $game = new Logic();
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
    <form action="" method="post">
        <label>Слово:</label>
        <label><?php echo $game->all_cities[array_key_last($game->all_cities)];?></label>
        <input type="text" name="city" namespace="Введите слово">
        <br><br><br>
        <input type="submit" name="submit" value="Отправить">  
    </form>
</body>
</html>