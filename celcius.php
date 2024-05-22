<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>

<?php
     if(isset($_POST['Celcius'])){
        $celcius = $_POST['Celcius'];
        $fahrenheit = $celcius * 1.8 + 32;
    }
?>
    <h1>celcius naar fahrenheit</h1>
    <form action=""method="post" >
    <input type="text" name="Celcius" >
    <input type="submit" value="submit">
    </form>
     <?php echo $fahrenheit; ?>
</body>
</html>