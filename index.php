<?php
$file = 'name.txt';
$nom ='';

if (isset($_POST["submitBtn"]) ){

    $nom = $_POST["inputName"];
    file_put_contents($file, $nom . "," . "\n", FILE_APPEND);
    echo file_get_contents($file);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
</head>
<body>
<h1>ton Nom: <?php htmlspecialchars($nom)?></h1>
<form action="index.php" method="post">

    <input name="inputName" type="text">
    <button name="submitBtn" type="submit">submit</button>

</form>

</body>
</html>
