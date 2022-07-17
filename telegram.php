<?php
require("config.php");

$input = file_get_contents("php://input");
$update = json_decode($input, 1);
$message = $update["message"]["text"];
$chatid = $update["message"]["chat"]["id"];

if ($message == "/getrecipe"){
    $res = retrieve("SELECT name, description, ingredients, instructions, uploader FROM recipe");
    $data = $res[rand(0, count($res) - 1)];
    
    $name = $data["name"];
    $desc = $data["description"];
    $ingr = join("\n", explode("`", $data["ingredients"]));
    $inst = join("\n", explode("`", $data["instructions"]));
    $uploader = $data["uploader"];
    
    $feedback = urlencode("$name \n\nDescription: $desc \n\nIngredients: \n$ingr \n\nInstructions: \n$inst \n\nBy: $uploader");
    file_get_contents("https://api.telegram.org/bot2130529523:AAG-4T614V_EEam2-A8B445Azk3cFWv7q-8/sendMessage?chat_id=$chatid&text=$feedback");
}
elseif (substr($message , 0, 8) == "/search ") {
    $kw = trim(substr($message, 7));
    $res = retrieve("SELECT name, description, ingredients, instructions, uploader
                        FROM recipe WHERE 
                        name LIKE '%$kw%' OR
                        description LIKE '%$kw%' OR
                        ingredients LIKE '%$kw%' OR
                        uploader LIKE '%$kw%'
                        ORDER BY popularity DESC")[0];
    
    $name = $res["name"];
    $desc = $res["description"];
    $ingr = join("\n", explode("`", $res["ingredients"]));
    $inst = join("\n", explode("`", $res["instructions"]));
    $uploader = $res["uploader"];
    
    $feedback = urlencode("$name \n\nDescription: $desc \n\nIngredients: \n$ingr \n\nInstructions: \n$inst \n\nBy: $uploader");
    file_get_contents("https://api.telegram.org/bot2130529523:AAG-4T614V_EEam2-A8B445Azk3cFWv7q-8/sendMessage?chat_id=$chatid&text=$feedback");
}
else {
    file_get_contents("https://api.telegram.org/bot2130529523:AAG-4T614V_EEam2-A8B445Azk3cFWv7q-8/sendMessage?chat_id=$chatid&text=$message");
}