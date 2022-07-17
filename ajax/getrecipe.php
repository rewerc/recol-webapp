<?php 

include("../../AAR/config.php");

$liked = false;
if (isset($_GET["keyword"]) && isset($_GET["username"])) {
   $kw = $_GET["keyword"];
   $username = $_GET["username"];
   if (!empty(retrieve("SELECT id FROM likenview WHERE uname = '$username' AND rid = $kw AND type = 'like'"))) $liked = true;
   $recipeDetails = retrieve("SELECT id, name, description, ingredients, instructions, photoloc, likes, views, uploader FROM recipe WHERE id = $kw");

   if (empty(retrieve("SELECT id FROM likenview WHERE uname = '$username' AND rid = $kw AND type = 'view'")) && 
      !($recipeDetails[0]["uploader"] == $username)) {
         query("INSERT INTO likenview (uname, rid, type) VALUES ('$username', $kw, 'view')");
         query("UPDATE recipe SET views = views + 1 WHERE id = $kw");
         $recipeDetails[0]["views"] += 1;
   }

   $ds = retrieve("SELECT likes, views FROM recipe WHERE id = $kw");
   $ds2 = retrieve("SELECT SUM(likes) AS likesum, SUM(views) AS viewsum FROM recipe WHERE uploader = (SELECT uploader FROM recipe WHERE id = $kw)");
   $ds3 = retrieve("SELECT post, clicks FROM aar_users WHERE uname = (SELECT uploader FROM recipe WHERE id = $kw)");
   $likes = $ds[0]["likes"];
   $views = $ds[0]["views"];
   $totalLikes = $ds2[0]["likesum"];
   $totalViews = $ds2[0]["viewsum"];
   $post = $ds3[0]["post"];
   $clicks = $ds3[0]["clicks"];
   $pop = popularVal($likes, $clicks, $post, $totalLikes, $totalViews, $views);
   query("UPDATE recipe SET popularity = $pop WHERE id = $kw");

}
else if (isset($_GET["keyword"])) {
    $kw = $_GET["keyword"];
    $recipeDetails = retrieve("SELECT id, name, description, ingredients, instructions, photoloc, likes, views FROM recipe WHERE id = $kw");
}

$fromBrowse = false;
if (isset($_GET["browse"])) {
   $fromBrowse = true;
}

?>
<form class="modal-content animate" action="" method="post">

   <div class="iconcontainer">
      <span onclick="document.getElementById('id02').style.display='none'" class="close"
         title="Close Modal">&times;</span>
   </div>

   <div class="modal_container">
      <h2 id="name-con" class="upload-title" style="text-align: left; font-weight:700">
         <?php echo $recipeDetails[0]["name"] ?>
      </h2>
   </div>

   <hr style="color:rgb(189, 189, 189); font-weight:200;">

   <div class="modal_container2" style="padding-left:29px">
      <div style="font-size: 20pt; font-weight: 700; text-decoration: underline; text-align: center">
         Description
      </div>
      <div>
         <p id="description-con" style="text-align: center; font-size:14px;">
            <?php
               $desc = $recipeDetails[0]["description"];
               $desc = join("<br>", explode("`", $desc));
               echo $desc;
            ?>
         </p>
      </div>
      <div class="row">
         <div class="" style="font-size: 20pt; font-weight: 700; text-decoration: underline; padding-bottom:10px;">
            Ingredients
         </div>
         <div>
            <p id="ingredient-con" style="color: black; font-weight:100; font-size: 14px; padding: bottom 8px;">
               <?php 
                  $ingr = $recipeDetails[0]["ingredients"];
                  $ingr = join("<br>", explode("`", $ingr));
                  echo $ingr;
               ?>
            </p>
         </div>
      </div>

      <div class="row">
         <div style="font-size: 20pt; font-weight: 700; text-decoration: underline; padding-bottom:8px;">
            Instructions
         </div>
         <div>
            <p id="instruction-con" style="color: black; font-weight:100; font-size: 14px;">
               <?php   
                  $inst = $recipeDetails[0]["instructions"];
                  $inst = join("<br>", explode("`", $inst));
                  echo $inst;
               ?>
            </p>
         </div>
      </div>
   </div>

   <br>
   <hr>

   <div class="modal_container" style="padding: 17px; text-align:right;">
      <?php if (!$fromBrowse): ?>
      <div class="modal-btn">
         <button type="submit" formaction="../AAR/home.php" formmethod="POST" name="delete" value='<?= $recipeDetails[0]["id"] ?>`<?= $recipeDetails[0]["photoloc"] ?>' class="deletebtn"
            style="padding-bottom:7px;">Delete</button>
      </div>

      <div id="edit-container" class="modal-btn">
         <button id="editbtn" value="<?= $recipeDetails[0]["id"] ?>" name="update" type="button" class="editbtn" style="padding-bottom:7px;">Edit</button>
      </div>

      <?php else: ?>
         <span style="font-size: 14px; color: darkgrey; margin-right: 50px;">
            <?= $recipeDetails[0]["views"] ?> people viewed this
         </span>
         <?php if ($liked): ?>
            <button id="likebtn" type="button" value="<?= $recipeDetails[0]["id"] ?>" name="like" class="likebtn likebtn-liked">LIKE <span id="like-count"><?= $recipeDetails[0]["likes"] ?></span></button>
         <?php else: ?>
            <button id="likebtn" type="button" value="<?= $recipeDetails[0]["id"] ?>" name="like" class="likebtn">LIKE <span id="like-count"><?= $recipeDetails[0]["likes"] ?></span></button>
         <?php endif; ?>

      <?php endif; ?>
   </div>
</form>