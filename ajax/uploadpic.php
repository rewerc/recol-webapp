<?php 

require("../../AAR/config.php");
if (isset($_POST["dish-name"]) && isset($_POST["dish-desc"]) && isset($_POST["ingredient-post"]) && isset($_POST["instruction-post"])) {
    $name = join("`", explode("\n", $_POST["dish-name"]));
    $desc = join("`", explode("\n", $_POST["dish-desc"]));
    $ingredients = join("`", explode("\n", $_POST["ingredient-post"]));
    $instructions = join("`", explode("\n", $_POST["instruction-post"]));
    $username = $_POST["username"];

    if (isset($_FILES["photo"]["name"])) {
        $filename = uniqid() . "-" . time();
        $split = explode(".", $_FILES["photo"]["name"]);
        $ext = end($split);
        $location = "../../AAR/uploads/" . $filename . "." . $ext;
        move_uploaded_file($_FILES['photo']['tmp_name'], $location);
        query("INSERT INTO recipe(name, description, ingredients, instructions, uploader, photoloc) 
            VALUES('$name', '$desc', '$ingredients', '$instructions', '$username', '$location')");
    }
    else {
        query("INSERT INTO recipe(name, description, ingredients, instructions, uploader) 
            VALUES('$name', '$desc', '$ingredients', '$instructions', '$username')");
    }

    $res = retrieve("SELECT post FROM aar_users WHERE uname = '$username'");
    $res = $res[0]["post"] + 1;
    query("UPDATE aar_users SET post = $res WHERE uname = '$username'");
}