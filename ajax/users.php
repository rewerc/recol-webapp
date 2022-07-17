<?php

require("../../AAR/config.php");
$userData = array();

if (isset($_GET["keyword"])) {
    $kw = $_GET["keyword"];
    $query = "SELECT uid, uname, email, ts FROM aar_users WHERE uname LIKE '%$kw%' OR email LIKE '%$kw%'";
    $userData = array_merge($userData, retrieve($query));
}
else {
    $query = "SELECT uid, uname, email, ts FROM aar_users";
    $userData = array_merge($userData, retrieve($query));
}

?>


<?php for ($i = 0; $i < count($userData); $i++) : ?>
    
<form action="" method="post">
    <div class="container-fluid" style="height: 40px; color: black">
        <?php if ($i === count($userData) - 1) : ?>
        <div class="row p-2 bg-light pb-2" style="border-radius: 0 0 10px 10px">
        <?php else : ?>
        <div class="row p-2 bg-light pb-2">
        <?php endif ?>

                <div class="col-1"><?= $i + 1 ?></div>
                <div class="col-3" id="name<?= $userData[$i]["uid"] ?>"><?= htmlspecialchars($userData[$i]["uname"]) ?>
                </div>
                <div class="col-3" id="email<?= $userData[$i]["uid"] ?>"><?= htmlspecialchars($userData[$i]["email"]) ?>
                </div>
                <div class="col-2"><?= $userData[$i]["ts"] ?></div>
                <div class="col-1" id="editcol<?= $userData[$i]["uid"] ?>">
                    <button class="btn btn-link p-0 editbtn" id="edit<?= $userData[$i]["uid"] ?>">Edit</button>
                </div>
                <div class="col-1">
                    <form action="" method="post">
                        <button class="btn btn-link p-0" name="delete" type="submit" value="<?= $userData[$i]["uid"] ?>"
                            style="color: red" formaction="" formmethod="post">Delete</button>
                    </form>
                </div>

            </div>
        </div>
</form>
<?php endfor; ?>
