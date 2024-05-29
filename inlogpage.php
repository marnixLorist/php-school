<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php
    if($_POST['email'] == "piet@worldonline.nl" && $_POST['wachtwoord'] == "doetje123") {
        echo "welkom" . "<br>";
    } else if ($_POST['email'] == "klaas@carpets.nl" && $_POST['wachtwoord'] == "snoepje777") {
        echo "welkom" . "<br>";
    } else if ($_POST['email'] == "truushendriks@wegweg.nl" && $_POST['wachtwoord'] == "arkiearkie201") {
        echo "welkom" . "<br>";
    } else {
        echo "Sorry, geen toegang" . "<br>";
    }
    ?>
</body>
</html>