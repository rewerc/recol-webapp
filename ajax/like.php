<?php
require("../../AAR/config.php"); 
if (isset($_GET["username"]) && $_GET["rid"]) {
    $username = $_GET["username"];
    $rid = $_GET["rid"];
    query ("INSERT INTO likenview (uname,rid,type) VALUES ('$username', $rid, 'like')");
    query ("UPDATE recipe SET likes = likes + 1 WHERE id = $rid");

    $ds = retrieve("SELECT likes, views FROM recipe WHERE id = $rid");
    $ds2 = retrieve("SELECT SUM(likes) AS likesum, SUM(views) AS viewsum FROM recipe WHERE uploader = (SELECT uploader FROM recipe WHERE id = $rid)");
    $ds3 = retrieve("SELECT post, clicks FROM aar_users WHERE uname = (SELECT uploader FROM recipe WHERE id = $rid)");

    $likes = $ds[0]["likes"];
    $views = $ds[0]["views"];
    $totalLikes = $ds2[0]["likesum"];
    $totalViews = $ds2[0]["viewsum"];
    $post = $ds3[0]["post"];
    $clicks = $ds3[0]["clicks"];

    $pop = popularVal($likes, $clicks, $post, $totalLikes, $totalViews, $views);
    query("UPDATE recipe SET popularity = $pop WHERE id = $rid");
}