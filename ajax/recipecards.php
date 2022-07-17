<?php 

require("../../AAR/config.php");

if (isset($_GET["keyword"]) && isset($_GET["username"])) {
    $username = $_GET["username"];
    $kw = $_GET["keyword"];
    $recipes = retrieve("SELECT id, name, description, uploader, photoloc, popularity
                        FROM recipe WHERE uploader = '$username' AND (
                        name LIKE '%$kw%' OR
                        description LIKE '%$kw%' OR
                        ingredients LIKE '%$kw%' OR
                        uploader LIKE '%$kw%')
                        ORDER BY name");
}
elseif (isset($_GET["keyword"])) {
    $kw = $_GET["keyword"];
    $recipes = retrieve("SELECT id, name, description, uploader, photoloc, popularity
                        FROM recipe WHERE
                        name LIKE '%$kw%' OR
                        description LIKE '%$kw%' OR
                        ingredients LIKE '%$kw%' OR
                        uploader LIKE '%$kw%'
                        ORDER BY name");
}
elseif (isset($_GET["username"])) {
    $username = $_GET["username"];
    $recipes = retrieve("SELECT id, name, description, uploader, photoloc, popularity
    FROM recipe WHERE uploader = '$username' ORDER BY name");
}
else {
    $recipes = retrieve("SELECT id, name, description, uploader, photoloc, popularity
    FROM recipe");
}

$recipes = bubble_sort($recipes);
?>


<?php for($i = 0; $i < count($recipes); $i++): ?>


    <div value="<?= $recipes[$i]['id'] ?>" class="card_ openDetails" data-target="#dish-content">
        <a href="#" title="Add dish..." data-target="#addDish" onclick="document.getElementById('id02').style.display='block'; document.getElementById('id02').style.position='fixed'">
            <?php if ($recipes[$i]['photoloc']): ?>
            <img src="<?= $recipes[$i]["photoloc"] ?>" style="width: 100%; height: 200px">
            <?php else: ?>
            <img src="../AAR/assets/images/default-photo.png" style="width: 100%; height: 200px">    
            <?php endif; ?>
            <div class="card_contents">
                <h2><b><?= $recipes[$i]["name"] ?></b></h2>
                <div>
                    <br> 
                    <p class="card_title">
                    <?php 
                        $desc = $recipes[$i]["description"];
                        $desc = join('<br>', explode('`', $desc));
                        echo($desc);
                    ?>    
                    </p>
                </div>
            </div>
            <p><button class="card_btn">Uploaded by <?= $recipes[$i]["uploader"] ?></button></p>
        </a>
    </div>

<?php endfor; ?>







