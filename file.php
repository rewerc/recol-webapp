<?php 

if (isset($_FILES["img"])) {
    var_dump($_FILES["img"]);
    $name = $_FILES["img"]["tmp_name"];
    echo "<img src='$name'>";
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Check file super</title>
</head>
<body>
    <form action="" method="post" enctype="multipart/form-data">
        <input type="file" name="img">
        <button type="submit">Submit</button>
    </form>
</body>
</html>