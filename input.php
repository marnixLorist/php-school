<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php
    echo $_POST['inlognaam'] . "<br>";
    if($_POST['inlognaam'] == "" ) {
        echo "Vul je inlognaam in" . "<br>";
       echo "<a href='input.html'>terug naar de inlogpagina</a>" . "<br>";
    }
    echo $_POST['adres'] . "<br>";
    if($_POST['adres'] == "" ) {
        echo "vul je adres in" . "<br>";
        echo "<a href='input.html'>terug naar de inlogpagina</a>" . "<br>";
    }
    echo $_POST['email'] . "<br>";
    if($_POST['email'] == "" ) {
        echo "vul je email in" . "<br>";
        echo "<a href='input.html'>terug naar de inlogpagina</a>" . "<br>";
    }
    ?>
</body>
</html>